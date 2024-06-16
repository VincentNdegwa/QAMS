<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Company;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class OrganisationController extends Controller
{
    function open()
    {
        $id = auth()->id();
        $data = [];
        $Organisation2 = UserCompany::where("user_id", auth()->id())->with("company")->orderBy('created_at', 'DESC')->get();

        foreach ($Organisation2 as $item) {
            $org_proj = Project::with("company")->where("company_id", $item->company_id)->withCount("testCases")->get();
            $org_project_count = $org_proj->count();
            $org_test_count = $org_proj->sum("test_cases_count");
            $org = [
                "name" => $item->company->name,
                "id" => $item->company_id,
                "created_at" => $item->company->created_at,
                "created_by" => UserCompany::where("role", "creator")->with("users")->where("company_id", $item->company_id)->first(),
                "role" => $item->role,
                "project_count" => $org_project_count,
                "test_case_count" => $org_test_count,
                "issues_count" => Issue::where("project_id", $item->company_id)->count(),
            ];
            $data[] = $org;
        }






        return Inertia::render('Organisations', [
            "user_id" => $id,
            "organisations" => $data
        ]);
    }
    function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            "user_id" => 'required|exists:users,id'
        ]);
        if (!$validation->fails()) {
            $user = User::where("id", $request->input("user_id"))->first();
            DB::beginTransaction();
            try {
                $company = Company::create([
                    "name" => $request->input("name"),
                    "creator_id" => $request->input("user_id")
                ]);

                UserCompany::create([
                    'company_id' => $company->id,
                    'user_id' => $request->input("user_id"),
                    'role' => 'creator'
                ]);

                $userComp = UserCompany::where("role", "creator")->with("users")->where("company_id", $company->id)->first();
                $user = $userComp->users;

                $projects = Project::with("company")->where("company_id", $company->id)->withCount("testCases")->get();
                $projectCount = $projects->count();
                $testCaseCount = $projects->sum("test_cases_count");

                $activity = Activity::create([
                    "activity_text" => "@" . $user->name . " Created a organisation " . "'" . $company->name . "'",
                ]);

                DB::commit();


                return response()->json([
                    "organisation" => [
                        "name" => $company->name,
                        "id" => $company->id,
                        "created_at" => $company->created_at,
                        "created_by" => UserCompany::where("role", "creator")->with("users")->where("company_id", $company->id)->first(),
                        "project_count" => $projectCount,
                        "test_case_count" => $testCaseCount,
                    ],
                    "error" => false,
                    "message" => "Organisation created successfully."
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                $message = $th->getMessage();
                return  response()->json(['error' => true, "message" => $message]);
            }
        } else {
            return response(["error" => true, "message" => $validation->errors()]);
        }
    }

    public function updateOrganisation(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "id" => "required",
            "name" => 'required',
            "existing_name" => 'required',
            'user_id' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                "error" => true,
                "message" => $validation->errors()->first()
            ]);
        } else {

            try {
                DB::beginTransaction();
                $update = Company::find($request->input("id"))->update([
                    "name" => $request->input("name")
                ]);
                if (!$update) {
                    return response()->json([
                        "error" => true,
                        "message" => "Organisation with Id " . $request->input("id") . " not found",
                    ]);
                }

                $existing_name = $request->input('existing_name');
                $user = User::where("id", $request->input("user_id"))->first();

                $newActivity = Activity::create([
                    "activity_text" => "@" . $user->name . " updated the organisation '" . $existing_name . "' to '" . $request->input("name") . "'",
                ]);

                DB::commit();

                return response()->json([
                    "error" => false,
                    "message" => "Organisation updated",
                    "data" => [
                        "id" => $request->input("id"),
                        "name" => $request->input("name")
                    ]
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    "error" => true,
                    "message" => $th->getMessage()
                ]);
            }
        }
    }

    public function searchOrganisation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => true,
                "message" => $validator->errors()->first()
            ]);
        } else {
            try {
                $search = $request->input("search");
                $id = $request->input("user_id");
                $data = [];

                $Organisations = Company::where("name", 'LIKE', "%" . $search . "%")->with([
                    'userCompany' => function ($query) use ($id) {
                        $query->where('user_id', $id);
                    }
                ])->with('projects')->get();
                foreach ($Organisations as $organisation) {
                    $projectCount = $organisation->projects->count();
                    $org_test_count = $organisation->projects()->withCount("testCases")->get();
                    $issues_count = 0;
                    foreach ($organisation->projects as $project) {
                        $issues_count += $project->issues->count();
                    }

                    $org = [
                        "name" => $organisation->name,
                        "id" => $organisation->id,
                        "created_at" => $organisation->created_at,
                        "created_by" => UserCompany::where("role", "creator")->with("users")->where("company_id", $organisation->id)->first(),
                        "project_count" => $projectCount,
                        "test_case_count" => $org_test_count->sum('test_cases_count'),
                        "issues_count" => $issues_count,
                        "user_id" => $id,
                    ];
                    $data[] = $org;
                }

                return response()->json([
                    "error" => false,
                    "data" => $data
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    "error" => true,
                    "message" => $th->getMessage()
                ]);
            }
        }
    }

    public function deleteOrganisation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => 'required',
            "user_id" => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => true,
                "message" => $validator->errors()->first()
            ]);
        } else {
            $id = $request->input("id");
            $user_id = $request->input("user_id");
            $user = User::where("id", $user_id)->first();
            try {
                $organisation = Company::where("id", $id)->first();
                $organisationName = $organisation->name;
                $organisation->delete();

                Activity::create([
                    "activity_text" => "@" . $user->name . " Deleted organisation " . $organisationName,
                ]);
                return response()->json([
                    "error" => false,
                    "message" => "Organisation deleted successfully"
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    "error" => true,
                    "message" => $th->getMessage()
                ]);
            }
        }
    }
}
