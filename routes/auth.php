<?php

use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::get("/auth/callback/{provider}", [SocialAuthController::class, 'callback']);
Route::get("/auth/redirect/{provider}", [SocialAuthController::class, 'redirect']);

Route::get("/auth/login", []);

Route::post("/auth/logout", []);