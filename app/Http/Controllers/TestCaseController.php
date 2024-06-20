<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Company;
use App\Models\ExpectedResult;
use App\Models\Issue;
use App\Models\Project;
use App\Models\TestCase;
use App\Models\TestStep;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TestCaseController extends Controller
{
    public function index($organisation, $project)
    {
        $modules = TestCase::where("project_id", $project)->select("module_name")->groupBy("module_name")->orderBy("module_name", "ASC")->get();

        $user = User::where("id", auth()->id())->select("id", "name")->first();

        return Inertia::render("NewTestCase", [
            "organisation_id" => $organisation,
            "project_id" => $project,
            "modules" => $modules,
            "user" => $user,
        ]);
    }
    public function view($organisation, $project)
    {
        $testCases = TestCase::where("project_id", $project)->with('testSteps')->get();
        $activities = Activity::select("activity_text", "created_at")->limit(10)->orderBy("id", "ASC")->where("project_id", $project)->get();
        $issuesCount = Issue::where("project_id", $project)->count();

        $count = 0;
        foreach ($testCases as $testCase) {
            $allStepsComplete = $testCase->testSteps->every(function ($step) {
                return $step->step_status === 'Complete';
            });

            if ($allStepsComplete) {
                $testCase->status = 'Complete';
            } else {
                $testCase->status = 'Incomplete';
            }

            $testCase->save();
            if ($testCase->status === 'Complete') {
                $count++;
            }
        }
        $modules = TestCase::where("project_id", $project)
            ->select("module_name", DB::raw("COUNT(*) as test_count"))
            ->groupBy("module_name")
            ->orderBy("module_name", "ASC")
            ->get();

        $totalTestCaseCount = count($testCases);
        $completedTestCaseCount = $count;

        return Inertia::render("ProjectOverview", [
            "data" => [
                "completedCases" => $completedTestCaseCount,
                "totalCases" => $totalTestCaseCount,
                "moduleCount" => $modules,
                "activities" => $activities,
                "issuesCount" => $issuesCount
            ]
        ]);
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


    function open($organisation, $project)
    {
        $modules = TestCase::where("project_id", $project)
            ->select("module_name", DB::raw("COUNT(*) as test_count"))
            ->groupBy("module_name")
            ->orderBy("module_name", "ASC")
            ->get();

        return Inertia::render("TestCase", [
            "moduleCount" => $modules,
            "userId" => auth()->id(),
            "projectId" => $project,
        ]);
    }

    function getTestCases(Request $request)

    {
        $validator = Validator::make(
            $request->all(),
            [
                "module_name" => "required",
                "user_id" => "required",
                "project_id" => "required",
            ]
        );
        try {
            if ($validator->fails()) {
                return response()->json([
                    "error" => true,
                    "message" => $validator->errors()->first(),
                ]);
            } else {
                $testCases = TestCase::where("project_id", $request->input("project_id"))
                    ->where("module_name", $request->input("module_name"))
                    ->with("tester")
                    ->withCount(["testSteps as expected_result_count" => function ($query) {
                        $query->select(DB::raw("count(*)"));
                    }])
                    ->get();


                return response()->json([
                    "error" => false,
                    "testCases" =>  $testCases,
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "error" => true,
                "message" => $th->getMessage(),
            ]);
        }
    }



    function newTestCase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => "required",
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
                $user = User::where("id", $request->input("tester_id"))->first();
                $userName = $user->name;

                $newTestCase = TestCase::create([
                    "module_name" => $request->input('module'),
                    "title" => $request->input("title"),
                    "tester_id" => $request->input("tester_id"),
                    "status" => "Incomplete",
                    "project_id" => $request->input("project_id"),
                    "description" => $request->input("description"),
                ]);
                Activity::create([
                    "activity_text" => "@" . $userName . " Created a new TestCase " . "'" . $newTestCase->title . "'",
                    "project_id" => $request->input("project_id")
                ]);
                if (count($request->input("test_steps")) > 0) {
                    foreach ($request->input("test_steps") as $step) {
                        $stepStatus = "";
                        if ($step["pass"] == 'false') {
                            $stepStatus = "Pending";
                        } else {
                            $stepStatus = "Complete";
                        }
                        $newTestStep = TestStep::create([
                            'step_description' => $step["step"],
                            'step_status' => $stepStatus,
                            'testcase_id' => $newTestCase->id
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
                } else {
                    $newTestStep = TestStep::create([
                        'step_description' => "null",
                        'step_status' => "pending",
                        'testcase_id' => $newTestCase->id
                    ]);

                    $newExpected = ExpectedResult::create([
                        'result_description' => "null",
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

    function viewTask($organisation, $project, $id)
    {
        $testCase = TestCase::where("id", $id)
            ->with([
                "testSteps" => function ($query) {
                    $query->with("expectedResult");
                }
            ])
            ->with("tester")
            ->with("project")
            ->first();
        return Inertia::render("ViewTestCase", [
            "testCase" => $testCase,
            "testCase_id" => $id
        ]);
    }
    private function fetchReportData($projectId)
    {
        $testReport = TestCase::select('id', 'project_id', 'module_name', 'title', 'tester_id', 'status', 'description')
            ->where('project_id', $projectId)
            ->orderBy('module_name', 'DESC')
            ->with(['testSteps' => function ($query) {
                $query->select('id', 'testcase_id', 'step_description', 'step_status')
                    ->with(['expectedResult' => function ($query) {
                        $query->select('id', 'test_step_id', 'result_description', 'found_description', 'pass');
                    }]);
            }])->get();

        $project = Project::where('id', $projectId)->select('id', 'name')->first();
        $issues = Issue::where("project_id", $projectId)->select("id", "title", "description", "stage")->get();

        return [
            'report' => $testReport,
            'project' => $project,
            "issues" => $issues,
        ];
    }

    public function getFullReport($organisation, $project)
    {
        $data = $this->fetchReportData($project);

        return view('testReport', [
            'testReport' => $data,
        ]);
    }

    public function downloadPdf($organisation, $project)
    {
        $data = $this->fetchReportData($project);

        $pdf = PDF::loadView('components.testReportComponent', [
            'testReport' => $data,
        ]);

        return $pdf->download();
    }

    public function previewPdf($organisation, $project)
    {
        $data = $this->fetchReportData($project);

        $pdf = PDF::loadView('components.testReportComponent', [
            'testReport' => $data,
        ]);
        return $pdf->stream();
    }


    public function ExportCSV($organisation, $project)
    {
        $testCases = TestCase::where("project_id", $project)->with([
            'testSteps' => function ($query) {
                $query->with('expectedResult');
            }
        ])->get();
        $project_name = Project::where("id", $project)->first();

        $csvData = [];
        $csvData[] = ['Module', 'Title', 'Description', 'Step', 'Expected Result'];

        foreach ($testCases as $testCase) {
            foreach ($testCase->testSteps as $step) {
                $csvData[] = [
                    $testCase->module_name,
                    $testCase->title,
                    $testCase->description,
                    $step->step_description,
                    $step->expectedResult->result_description ?? ''
                ];
            }
        }

        $filename = $project_name->name ."-". date('YmdHis').".csv";


        $handle = fopen($filename, "w+");
        foreach ($csvData as $data) {
            fputcsv($handle, $data);
        }
        fclose($handle);
        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return response()->download($filename, $filename, $headers);

    }

    public function ImportJson(Request $request, $organisation, $project)
    {
        $request->validate([
            'file' => 'required|mimes:json',
            'tester_id' => 'required'
        ]);

        $path = $request->file('file')->getRealPath();
        $jsonData = json_decode(file_get_contents($path), true);

        if (!$jsonData) {
            return response()->json([
                "error" => true,
                "message" => "Invalid JSON data in the file."
            ]);
        }

        DB::beginTransaction();
        try {
            foreach ($jsonData as $testCaseData) {
                // Validate each test case data
                $validator = Validator::make($testCaseData, [
                    'Title' => "required",
                    "Module" => "required",
                    "Steps" => "required|array|min:1",
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        "error" => true,
                        "message" => $validator->errors()->first(),
                    ]);
                }

                $user = User::find($request->input('tester_id'));
                if (!$user) {
                    throw new \Exception("User with ID {$request->input('tester_id')} not found.");
                }

                $userName = $user->name;

                // Create new test case
                $newTestCase = TestCase::create([
                    "module_name" => $testCaseData['Module'],
                    "title" => $testCaseData['Title'],
                    "tester_id" => $request->input('tester_id'), // Use tester_id from request
                    "status" => "Incomplete",
                    "project_id" => $project,
                    "description" => $testCaseData['Description'] ?? '',
                ]);

                // Create activity log
                Activity::create([
                    "activity_text" => "@" . $userName . " Created a new TestCase '" . $newTestCase->title . "'",
                    "project_id" => $project
                ]);

                // Create test steps and expected results
                foreach ($testCaseData['Steps'] as $step) {
                    $stepStatus = $step["status"] ? "Complete" : "Pending";

                    $newTestStep = TestStep::create([
                        'step_description' => $step["step"],
                        'step_status' => $stepStatus,
                        'testcase_id' => $newTestCase->id
                    ]);

                    $found = $step["Found result"] ?? '';
                    $newExpected = ExpectedResult::create([
                        'result_description' => $step["expected result"],
                        'test_step_id' => $newTestStep->id,
                        "found_description" => $found,
                        'pass' => $step['status'] ? 'true' : 'false'
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                "error" => false,
                "message" => "Test cases have been created successfully from JSON file.",
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                "error" => true,
                "message" => $th->getMessage(),
            ]);
        }
    }



};
