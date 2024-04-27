<?php

use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware("auth")->prefix("/")->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get("organisation", [OrganisationController::class, "open"])->name("organisation");
    Route::get('/organisation/{organisation_id}/project', [ProjectController::class, "open"])->name("project.open");
    
    Route::prefix("/organisation/{organisation}/project/{project}")->group(function () {
        Route::get("/", function ($organisation, $project) {
            return Inertia::render("ProjectOverview");
        });
        Route::get("/test", function ($organisation, $project) {
            return Inertia::render("TestCase");
        });
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
