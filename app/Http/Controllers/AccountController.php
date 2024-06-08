<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function openAccount()
    {
        $user_id = auth()->id();
        // enum('joined','opened','closed', 'expired')

        $invitation = Invitation::where("user_id", $user_id)->with('company')->orderBy("created_at", "DESC")->paginate(10);
        $this->confirmInvitations($invitation->items());
        $user = User::where("id", $user_id)->select("name", "email")->first();
        return Inertia::render("Account", [
            "invitations" => $invitation,
            "user_id" => $user_id,
            "user" => $user
        ]);
    }
    public function confirmInvitations($invitations)
    {

        foreach ($invitations as $invitation) {
            if ($invitation->status == 'opened') {
                $expirationDateTime = $invitation->expiration_date;
                $now = Carbon::now();
                if ($now > $expirationDateTime) {
                    $invitation->update(['status' => 'expired']);
                }
            }
        }
    }
    public function paginatPage(Request $request)
    {
        try {
            $validated = $request->validate([
                "user_id" => 'required|integer',
                "page" => 'required|integer',
                "rows_per_page" => 'required|integer'
            ]);

            $invitation = Invitation::where("user_id", $validated['user_id'])
                ->with('company')
                ->orderBy("created_at", "DESC")
                ->paginate($validated['rows_per_page'], ['*'], 'page', $validated['page']);

            return response()->json([
                "error" => false,
                "data" => $invitation
            ]);
        } catch (ValidationException $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage(),
                'data' => null,
            ], 422);
        }
    }

}
