<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function openAccount()
    {
        $user_id = auth()->id();
        $invitation = Invitation::where("user_id", $user_id)->with('company')->get();
        return Inertia::render("Account", [
            "invitations"=>$invitation,
        ]);
    }
}
