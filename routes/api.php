<?php

use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

// Route::middleware("auth")->group(function () {
Route::post("organisation/add", [OrganisationController::class, "create"])->name("organisation.create");
Route::post("project/add", [ProjectController::class, "create"])->name("project.create");
// });
