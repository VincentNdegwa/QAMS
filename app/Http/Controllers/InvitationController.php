<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Invitation;
use App\Models\UserCompany;
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
                'expiration_date' => Carbon::now()->addDay(),
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
        $invitation = Invitation::where('company_hash', $id)->with(['user', 'company'])->first();
        $user_id = auth()->id();
        $company_id = $invitation->company_id;

        if (!$invitation) {
            return $this->renderError('Invitation not found.');
        }

        $currentDateTime = Carbon::now();
        $expirationDateTime = $invitation->expiration_date;


        if ($currentDateTime > $expirationDateTime) {
            return $this->renderError('The invitation has expired.');
        }

        if ($invitation->status !== 'opened') {
            return $this->renderError('The invitation is ' . $invitation->status . '.');
        }

        $invitation->now = $currentDateTime;
        $invitation->user_id = $user_id;

        $userExistence = UserCompany::where("company_id", $company_id)->where("user_id", $user_id)->first();
        if ($userExistence) {
            return $this->renderError('You are already a member of this company.');
        }

        return $this->renderSuccess('Invitation found.', $invitation);
    }


    private function renderError(string $message)
    {
        return Inertia::render('Invitation', [
            'error' => true,
            'message' => $message,
            'data' => null,
        ]);
    }

    private function renderSuccess(string $message, $data)
    {
        return Inertia::render('Invitation', [
            'error' => false,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
