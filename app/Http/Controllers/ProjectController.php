<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function Termwind\render;

class ProjectController extends Controller
{
    function open($organisation_id)
    {
        $projects = Project::where("company_id", $organisation_id)->with([
            "company" => function ($query) {
                $query->select("id", "name");
            }
        ])->withCount(['testCases', 'issues'])->get();

        return Inertia::render("Projects", [
            "projects" => $projects,
            "org_id" => $organisation_id
        ]);
    }

    function create(Request $request)
    {
        try {
            $project = Project::create([
                'name' => $request->input("name"),
                'company_id' => $request->input("company_id")
            ]);
            if ($project) {
                $projectDetails = Project::where("id", $project->id)->with([
                    "company" => function ($query) {
                        $query->select("id", "name");
                    },
                ])->withCount(['testCases', 'issues'])->first();
                if ($projectDetails) {
                    return response()->json([
                        "error" => false,
                        "message" => "Project created successfully.",
                        "project" => $projectDetails
                    ]);
                } else {
                    return response()->json([
                        "error" => true,
                        "message" => "Failed to get Project Details, Try to refresh"
                    ]);
                }
            } else {
                return response()->json([
                    "error" => true,
                    "message" => "Failed to create  project."
                ]);
            }
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                "error" => true,
                "message" => $message
            ]);
        }
    }
}
