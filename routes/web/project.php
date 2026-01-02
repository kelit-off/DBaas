<?php

use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;

Route::get("/project/{project_id}", [ProjectsController::class, "showGlobal"])->name('projects.show'); // Vue du projet (databases list)
Route::get("/new/{team_id}", [ProjectsController::class, 'create'])->name('teams.newProject'); // Crée un projet dans la team sélectionnée
