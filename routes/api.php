<?php

use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TestCaseController;
use Illuminate\Support\Facades\Route;

Route::post("organisation/add", [OrganisationController::class, "create"])->name("organisation.create");
Route::post("project/add", [ProjectController::class, "create"])->name("project.create");
Route::prefix("/testCase")->group(function () {
    Route::post("add", [TestCaseController::class, "newTestCase"]);
});
