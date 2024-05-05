<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PageController extends Controller
{
    function openDashboard()
    {
        $organisations = UserCompany::where("user_id", auth()->id())->with("company")->get();
        $organisationCount = 0;
        $projectCount = 0;
        $testCount = 0;
        $issueCount = 0;
        $testCaseArray = [];
        $projectArray = [];

        foreach ($organisations as $organisation) {
            $organisationCount++;
            $projects = Project::where("company_id", $organisation->id)
                ->select("id", 'name')
                ->withCount("testCases")
                ->withCount("issues")
                ->get();
            $projectArray[] = [
                "name" => $organisation->company->name,
                "project_count" => count($projects)
            ];
            foreach ($projects as $project) {
                $projectCount++;
                $testCount = $testCount + count($project->testCases);
                $issueCount = $issueCount + count($project->issues);
                $testCaseArray[] = [
                    "name" => $project->name,
                    "test_count" => count($project->testCases),
                ];
            }
        }
        return Inertia::render("Dashboard", [
            "data" => [
                "organisationCount" => $organisationCount,
                "projectCount" => $projectCount,
                "testCount" => $testCount,
                "issueCount" => $issueCount,
                "testcaseProject" => $testCaseArray,
                "projectOrganisation" => $projectArray
            ]
        ]);
    }
}
