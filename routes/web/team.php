<?php

use App\Http\Controllers\TeamsController;
use Illuminate\Support\Facades\Route;

Route::get("/new", [TeamsController::class, "create"]); // Crée une team

Route::get("/org/{team_id}/member", [TeamsController::class, "showMember"])->name("teams.showMember");
Route::get("/org/{team_id}/settings", [TeamsController::class, "showSettings"])->name("teams.showSettings");
Route::get("/org/{team_id}", [TeamsController::class, 'show'])->name('teams.show'); // Vue de la team (sélection projet)
