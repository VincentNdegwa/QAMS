<?php

namespace App\Http\Controllers;

use App\Models\ExpectedResult;
use App\Models\TestCase;
use App\Models\TestStep;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TestCaseController extends Controller
{
    public function index($organisation, $project)
    {
        $modules = TestCase::where("project_id", $project)->select("module_name")->get();
        $user = User::where("id", auth()->id())->select("id", "name")->first();

        return Inertia::render("NewTestCase", [
            "organisation_id" => $organisation,
            "project_id" => $project,
            "modules" => $modules,
            "user" => $user
        ]);
    }
    function newTestCase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => "required",
            // 'description' => "required",
            "module" => "required",
            "project_id" => "required",
            "tester_id" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => true,
                "message" => $validator->errors()->first(),
            ]);
        } else {
            DB::beginTransaction();
            try {
                $newTestCase = TestCase::create([
                    "module_name" => $request->input('module'),
                    "title" => $request->input("title"),
                    "tester_id" => $request->input("tester_id"),
                    "status" => "pending",
                    "project_id" => $request->input("project_id"),

                ]);
                foreach ($request->input("test_steps") as $step) {
                    $newTestStep = TestStep::create([
                        'step_description' => $step["step"],
                        'step_status' => "pending",
                        'testcase_id' => $newTestCase->id
                    ]);

                    $newExpected = ExpectedResult::create([
                        'result_description' => $step["expected"],
                        'test_step_id' => $newTestStep->id
                    ]);
                }
                DB::commit();
                return response()->json([
                    "error" => false,
                    "message" =>  "New test case has been created successfully.",
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    "error" => true,
                    "message" => $th->getMessage(),
                ]);
            }
        }
    }
}
