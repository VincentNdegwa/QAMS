<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class InvitationController extends Controller
{
    public function inviteUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'company_id' => 'required|exists:companies,id',
            ]);
            DB::beginTransaction();

            $invitation = Invitation::create([
                'user_id' => $validatedData['user_id'],
                'company_id' => $validatedData['company_id'],
                'company_hash' => Str::random(32),
                'status' => 'opened',
                'expiration_date' => Carbon::now()->addHours(24),
            ]);
            $invitationData = [
                "link" => $invitation['company_hash'],
                "organisation" => 'STAR'
            ];
            Mail::to($request->input('email'))->queue(new InvitationMail($invitationData));
            DB::commit();
            return response()->json([
                'error' => false,
                'message' => 'Invitation created successfully.',
                'data' => $invitation,
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => null,
            ], 422);
        } catch (\Exception  $e) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    public function checkInvitation(Request $request)
    {
        $id = $request->input("link");
        $invitation = Invitation::where('company_hash', $id)->first();
        if ($invitation) {
            return Inertia::render('Invitation', [
                'error' => false,
                'message' => 'Invitation found.',
                'data' => $invitation,
            ]);
        } else {
            return Inertia::render('Invitation', [
                'error' => true,
                'message' => 'Invitation not found.',
                'data' => null,
            ]);
        }
    }
}
