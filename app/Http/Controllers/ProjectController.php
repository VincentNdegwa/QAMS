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
            },
            "testCases" => function ($query) {
                $query->count();
            },
            "issues" => function ($query) {
                $query->count();
            }
        ])->get();

        return Inertia::render("Projects", [
            "projects" => $projects,
            "org_id" => $organisation_id
        ]);
    }

    function create(){
        
    }
}
