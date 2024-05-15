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
            ])->paginate(10);
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

        $updatedIssue = Issue::where("id", $request->input("id"))->with([
            "project" => function ($query) {
                $query->select('name', 'id');
            }
        ])->first();

        return response()->json([
            "error" => false,
            "message" => "Issue updated successfully",
            "data" => $updatedIssue
        ]);
    }
    public function searchAndFilterIssue(Request $request)
    {
        $search = $request->input("search");
        $filter = $request->input("filter");
        $page = $request->input("page", 1);
        $rows_per_page = $request->input("rows_per_page", 10);

        $query = Issue::query();
        if ($search) {
            $query->where("title", "like", "%" . $search . "%")
                ->orWhere("description", "like", "%" . $search . "%")
                ->orWhere("id", "like", "%" . $search . "%")
                ->with([
                    "project" => function ($query) {
                        $query->select('name', 'id');
                    }
                ]);
        }

        if ($filter && $filter != 'all') {
            $query->where("stage", $filter);
        }

        $issues = $query->with([
            "project" => function ($query) {
                $query->select('name', 'id');
            }
        ])->paginate($rows_per_page, ['*'], 'page', $page);

        return response()->json([
            "error" => false,
            "data" => $issues
        ]);
    }
}
