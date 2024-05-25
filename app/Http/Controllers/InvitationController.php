<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    public function inviteUser(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
        ]);

        $invitation = Invitation::create([
            'user_id' => $validatedData['user_id'],
            'company_id' => $validatedData['company_id'],
            'company_hash' => Hash::make($validatedData['company_id']),
            'status' => 'opened',
            'expiration_date' => Carbon::now()->addHours(24),
        ]);

        return response()->json($invitation);
    }
}
