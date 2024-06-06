<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function openAccount()
    {
        $user_id = auth()->id();
        // enum('joined','opened','closed', 'expired')

        $invitation = Invitation::where("user_id", $user_id)->with('company')->paginate(5);
        $this->confirmInvitations($invitation->items());
        return Inertia::render("Account", [
            "invitations" => $invitation,
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
}
