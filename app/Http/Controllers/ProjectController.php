<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;
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
            "org_id" => $organisation_id,
            "user_id" => auth()->id(),
            "company" => $projects[0]->company
        ]);
    }

    function create(Request $request)
    {
        try {
            $user_id = $request->input("user_id");
            $user = User::where("id", $user_id)->first();
            $project = Project::create([
                'name' => $request->input("name"),
                'company_id' => $request->input("company_id")
            ]);
            if ($project) {
                Activity::create([
                    "activity_text" => "@" . $user->name . " Created project " . "'" . $project->name . "'",
                    "project_id" => $project->id,
                ]);
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

    function updateProject(Request $request)
    {
        try {
            $project_id = $request->input("id");
            $user_id = $request->input("user_id");
            $user = User::where("id", $user_id)->first();

            $project = Project::find($project_id);
            if (!$project) {
                return response()->json([
                    "error" => true,
                    "message" => "Project not found."
                ]);
            }

            $project->update([
                'name' => $request->input("name"),
            ]);

            Activity::create([
                "activity_text" => "@" . $user->name . " Updated project " . "'" . $project->name . "'",
                "project_id" => $project->id,
            ]);

            $projectDetails = Project::where("id", $project->id)->with([
                "company" => function ($query) {
                    $query->select("id", "name");
                },
            ])->withCount(['testCases', 'issues'])->first();

            return response()->json([
                "error" => false,
                "message" => "Project updated successfully.",
                "project" => $projectDetails
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                "error" => true,
                "message" => $message
            ]);
        }
    }

    function deleteProject(Request $request)
    {
        try {
            $project_id = $request->input("id");
            $user_id = $request->input("user_id");
            $user = User::where("id", $user_id)->first();
            $project = Project::find($project_id);
            if (!$project) {
                return response()->json([
                    "error" => true,
                    "message" => "Project not found."
                ]);
            }

            $projectName = $project->name;
            $project->delete();

            Activity::create([
                "activity_text" => "@" . $user->name . " Deleted project " . "'" . $projectName . "'",
                "project_id" => $project_id,
            ]);

            return response()->json([
                "error" => false,
                "message" => "Project deleted successfully."
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                "error" => true,
                "message" => $message
            ]);
        }
    }

    function searchProject(Request $request)
    {
        $query = $request->input('query');
        $organisation_id = $request->input("organisation_id");

        $projects = Project::where("company_id", $organisation_id)->where('name', 'like', "%{$query}%")->with([
            "company" => function ($query) {
                $query->select("id", "name");
            }
        ])->withCount(['testCases', 'issues'])->get();

        return response()->json([
            'error' => false,
            'projects' => $projects
        ]);
    }
}
