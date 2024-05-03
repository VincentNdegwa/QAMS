<?php

namespace App\Http\Controllers;

use App\Models\ExpectedResult;
use App\Models\TestStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
}
