<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use App\Models\UserCompany;
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
        $organisation = Company::with([
            "users" => function ($query) {
                $query->where("users.id", auth()->id());
            },
            "projects" => function ($query) {
                $query->withCount("testCases");
            }
        ])->get();

        foreach ($organisation as $item) {
            $uC = UserCompany::where("role", "creator")->where("company_id", $item->id)->with("users")->first();
            $org_user = $uC->users;
            $org_proj = Project::with("company")->where("company_id", $item->id)->withCount("testCases")->get();
            $org_project_count = $org_proj->count();
            $org_test_count = $org_proj->sum("test_cases_count");
            $org = [
                "name" => $item->name,
                "id" => $item->id,
                "created_at" => $item->created_at,
                "created_by" => $org_user->name,
                "project_count" => $org_project_count,
                "test_case_count" => $org_test_count,
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

                DB::commit();


                return response()->json([
                    "organisation" => [
                        "name" => $company->name,
                        "id" => $company->id,
                        "created_at" => $company->created_at,
                        "created_by" => $user->name,
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
}