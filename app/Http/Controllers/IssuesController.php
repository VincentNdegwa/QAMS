<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class IssuesController extends Controller
{
    public function addIssue(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "title" => 'required',
                "project_id" => 'required',
                'stage' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "error" => true,
                    "message" => $validator->errors()->first()
                ]);
            } else {
                $newIssue = Issue::create([
                    "title" => $request->input("title"),
                    "project_id" => $request->input("project_id"),
                    'stage' => $request->input("stage"),
                    'description' => $request->input("description")
                ]);
                if ($newIssue) {
                    return response()->json([
                        "error" => false,
                        'message' => 'Issue created',
                        "data" => $newIssue
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                "error" => true,
                "message" => $th->getMessage()
            ]);
        }
    }

    public function getIssues($organisation, $project)
    {
        try {
            $issues = Issue::where("project_id", $project)->with([
                "project" => function ($query) {
                    $query->select('name', 'id');
                }
            ])->get();
            return Inertia::render("IssuesView", [
                "issue" => $issues,
                "project_id" => $project
            ]);
        } catch (\Throwable $th) {
            return Inertia::render("ErrorPage", [
                "message" => $th->getMessage()
            ]);
        }
    }

    public function updateIssue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => 'required|exists:issues,id',
            "title" => 'required',
            "stage" => 'required|in:opened,in progress,closed',
            "description" => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "error" => true,
                "message" => $validator->errors()->first()
            ]);
        }

        $issue = Issue::find($request->input("id"));

        if (!$issue) {
            return response()->json([
                "error" => true,
                "message" => "Issue not found"
            ]);
        }

        $issue->update([
            "title" => $request->input("title"),
            "stage" => $request->input("stage"),
            "description" => $request->input("description"),
        ]);

        $updatedIssue = Issue::where("id", $request->input("id"))->with("project")->first();

        return response()->json([
            "error" => false,
            "message" => "Issue updated successfully",
            "data" => $updatedIssue
        ]);
    }
    public function searchAndFilterIssue(Request $request)
    {
        $issues = Issue::where("title", "like", "%" . $request->input("search") . "%")->get();
    }
}