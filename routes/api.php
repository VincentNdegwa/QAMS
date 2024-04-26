<?php

use App\Http\Controllers\OrganisationController;
use Illuminate\Support\Facades\Route;

// Route::middleware("auth")->group(function () {
Route::post("organisation", [OrganisationController::class, "create"])->name("organisation.create");
// });
