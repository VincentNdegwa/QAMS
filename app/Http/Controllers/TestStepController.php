<?php

namespace App\Http\Controllers;

use App\Models\ExpectedResult;
use App\Models\TestCase;
use App\Models\TestStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TestStepController extends Controller
{
    function addStep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "testCase_id" => 'required',
        ]);

        if ($validator->fails()) {
            return [
                "error" => true,
                "message" => $validator->errors()->first()
            ];
        } else {

            try {
                $data = $request->input("data");
                $testSteps = $data["test_steps"];
                DB::beginTransaction();
                foreach ($testSteps as $step) {
                    $stepStatus = "";
                    if ($step["pass"] == 'false') {
                        $stepStatus = "Pending";
                    } else {
                        $stepStatus = "Complete";
                    }
                    $newTestStep = TestStep::create([
                        'step_description' => $step["step"],
                        'step_status' => $stepStatus,
                        'testcase_id' => $request->input("testCase_id")
                    ]);

                    $found = '';
                    if (isset($step["found"])) {
                        $found = $step["found"];
                    }
                    $newExpected = ExpectedResult::create([
                        'result_description' => $step["expected"],
                        'test_step_id' => $newTestStep->id,
                        "found_description" => $found,
                        'pass' => $step['pass']
                    ]);
                }
                DB::commit();
                return response()->json([
                    "error" => false,
                    "message" => "Test Steps Added Successfully",
                    "data" => [$newExpected, $newTestStep]
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                $message = $th->getMessage();
                return [
                    "error" => true,
                    "message" => $message
                ];
            }
        }
    }

    function updateTestStep(Request $request)
    {
        try {
            $stepStatus = "";
            if ($request->expected_result['pass'] == 'false') {
                $stepStatus = "Pending";
            } else {
                $stepStatus = "Complete";
            }
            $testStep = TestStep::find($request->id);
            $testStep->step_description = $request->step_description;
            $testStep->step_status = $stepStatus;
            $testStep->save();

            $expectedResult = ExpectedResult::find($request->expected_result['id']);
            $expectedResult->result_description = $request->expected_result['result_description'];
            $expectedResult->found_description = $request->expected_result['found_description'];
            $expectedResult->pass = $request->expected_result['pass'];
            $expectedResult->save();

            // Call the updateTestCase method with the testcase_id from the request
            $this->updateTestCase($request->testcase_id);

            return response()->json([
                'error' => false,
                'message' => 'Test step updated successfully.',
                "data" => [
                    "testCase" => TestCase::where("id", $request->testcase_id)->with([
                        "testSteps" => function ($query) {
                            $query->with("expectedResult");
                        }
                    ])
                        ->with("tester")
                        ->with("project")
                        ->first(),
                    "testCase_id" => $request->testcase_id
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage(),
            ]);
        }
    }

    function upDateTestCase($testCaseId)
    {
        $testCase = TestCase::where("id", $testCaseId)->with("testSteps")->first();
        $allStepsComplete = $testCase->testSteps->every(function ($step) {
            return $step->step_status === 'Complete';
        });

        if ($allStepsComplete) {
            $testCase->status = 'Complete';
        } else {
            $testCase->status = 'Incomplete';
        }

        $testCase->save();
    }
}
