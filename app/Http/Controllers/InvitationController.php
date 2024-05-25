<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InvitationController extends Controller
{
    public function inviteUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'company_id' => 'required|exists:companies,id',
            ]);

            $invitation = Invitation::create([
                'user_id' => $validatedData['user_id'],
                'company_id' => $validatedData['company_id'],
                'company_hash' =>Str::random(32),
                'status' => 'opened',
                'expiration_date' => Carbon::now()->addHours(24),
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Invitation created successfully.',
                'data' => $invitation,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => null,
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }
}
