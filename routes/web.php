<?php

use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TestCaseController;
use App\Models\Project;
use App\Models\TestCase;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get("/", [PageController::class, "openDashboard"])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware("auth")->prefix("/")->group(function () {
    Route::get("dashboard", [PageController::class, "openDashboard"])->name('dashboard');

    Route::get("organisation", [OrganisationController::class, "open"])->name("organisation");
    Route::get('/organisation/{organisation_id}/project/', [ProjectController::class, "open"])->name("project.open");

    Route::prefix("/organisation/{organisation}/project/{project}/")->group(function () {

        Route::get("/open", [TestCaseController::class, "view"]);
        Route::get("/test", [TestCaseController::class, "open"])->name("test.page");
        Route::get("/new", [TestCaseController::class, 'index']);
        Route::get("/step", function () {
            return Inertia::render("NewTestStep");
        });
        Route::get("/issues", [TestCaseController::class, "openIssues"]);
        Route::get("view/{id}", [TestCaseController::class, "viewTask"]);
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
