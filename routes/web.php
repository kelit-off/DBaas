<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TeamsController;
use App\Services\TeamService;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('home', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard', [
            'teams' => (new TeamService())->getListe()
        ]);
    })->name('dashboard');

    Route::prefix("dashboard")->group(function () {
        require __DIR__ . '/web/team.php';
        require __DIR__ . '/web/project.php';
    });

    Route::get('/onbording', function () {
        return Inertia::render('onbording');
    })->name('onbording');

    Route::post('/teams', [TeamsController::class, 'store'])->name('teams.store');
    Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
});


require __DIR__ . '/settings.php';

require __DIR__ . '/auth.php';
