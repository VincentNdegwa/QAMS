<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
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
            $company = Company::where("id", $validatedData['company_id'])->select('name', 'id')->first();
            $user = User::where('id', $validatedData['user_id'])->select('name', 'id')->first();
            $invitationData = [
                "link" => $invitation['company_hash'],
                "organisation" => $company->name,
                "host" => $user->name
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

        $expectedDeadline = Carbon::parse($invitation->created_at)->addDay();
        $expirationDateTime = $invitation->expiration_date;


        if ($expectedDeadline > $expirationDateTime) {
            return $this->renderError('The invitation has expired.');
        }

        if ($invitation->status !== 'opened') {
            return $this->renderError('The invitation is ' . $invitation->status . '.');
        }

        $invitation->now = $expectedDeadline;
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

    public function enrollUser(Request $request)
    {
        $request->validate([
            'invited_user_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:companies,id',
            'status' => 'required|boolean',
            'role' => 'required|string|max:255',
            'company_hash' => 'required|string'
        ]);

        $user_id = $request->invited_user_id;
        $company_id = $request->company_id;
        $status = $request->status;
        $role = $request->role;
        $company_hash = $request->company_hash;

        $invitation = Invitation::where('company_hash', $company_hash)
            ->first();

        if (!$invitation) {
            return response()->json([
                'error' => true,
                'message' => 'Invitation not found.',
                'data' => null,
            ], 404);
        }

        if ($status) {
            $existingEntry = UserCompany::where('user_id', $user_id)
                ->where('company_id', $company_id)
                ->first();

            if ($existingEntry) {
                return response()->json([
                    'error' => true,
                    'message' => 'User is already enrolled in the company.',
                    'data' => null,
                ], 400);
            }

            $userCompany = UserCompany::create([
                'user_id' => $user_id,
                'company_id' => $company_id,
                'role' => $role,
            ]);

            $invitation->update(['status' => 'joined']);

            return response()->json([
                'error' => false,
                'message' => 'User enrolled successfully and invitation updated to joined.',
                'data' => $userCompany,
            ], 201);
        } else {
            $invitation->update(['status' => 'closed']);

            return response()->json([
                'error' => false,
                'message' => 'Invitation updated to closed.',
                'data' => $invitation,
            ], 200);
        }
    }
}
