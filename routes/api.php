<?php

use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TestCaseController;
use App\Http\Controllers\TestStepController;
use Illuminate\Support\Facades\Route;

Route::post("organisation/add", [OrganisationController::class, "create"])->name("organisation.create");
Route::post("project/add", [ProjectController::class, "create"])->name("project.create");
Route::prefix("/testCase")->group(function () {
    Route::post("add", [TestCaseController::class, "newTestCase"]);
    Route::post("retrieve", [TestCaseController::class, "getTestCases"]);
});
Route::prefix("/testStep")->group(function () {
    Route::post("/add", [TestStepController::class, "addStep"]);
    Route::post("/update", [TestStepController::class, "updateTestStep"]);
});
