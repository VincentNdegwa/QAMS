<?php

use App\Http\Controllers\InvitationController;
use App\Http\Controllers\IssuesController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TestCaseController;
use App\Http\Controllers\TestStepController;
use Illuminate\Support\Facades\Route;

Route::prefix("organisation")->group(function () {
    Route::post("/add", [OrganisationController::class, "create"])->name("organisation.create");
    Route::post("/update", [OrganisationController::class, "updateOrganisation"]);
    Route::post("/search", [OrganisationController::class, "searchOrganisation"]);
    Route::post("/delete", [OrganisationController::class, "deleteOrganisation"]);
});
Route::prefix('project')->group(
    function () {
        Route::post("/add", [ProjectController::class, "create"])->name("project.create");
        Route::post("/update", [ProjectController::class, "updateProject"]);
        Route::post("/delete", [ProjectController::class, "deleteProject"]);
        Route::post("/search", [ProjectController::class, "searchProject"]);
    }
);

Route::prefix("/testCase")->group(function () {
    Route::post("add", [TestCaseController::class, "newTestCase"]);
    Route::post("retrieve", [TestCaseController::class, "getTestCases"]);
});
Route::prefix("/testStep")->group(function () {
    Route::post("/add", [TestStepController::class, "addStep"]);
    Route::post("/update", [TestStepController::class, "updateTestStep"]);
    Route::post("/delete", [TestStepController::class, "Delete"]);
});

Route::prefix("/issues")->group(function () {
    Route::post("/add", [IssuesController::class, "addIssue"]);
    Route::post("/update", [IssuesController::class, "updateIssue"]);
    Route::post("/searchAndFilter", [IssuesController::class, "searchAndFilterIssue"]);
    Route::post("/delete", [IssuesController::class, "deleteIssue"]);
});
Route::prefix("/invite")->group(function () {
    Route::post("/add", [InvitationController::class, "inviteUser"]);
});
