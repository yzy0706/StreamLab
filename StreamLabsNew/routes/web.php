<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Redirect to GitHub's OAuth page
Route::get('login/{provider}', [AuthController::class, 'oauthLogin']);

// Handle OAuth callback from GitHub
Route::get('callback/{provider}', [AuthController::class, 'handleProviderCallback']);

Route::get('/', function () {
    return view('welcome');
});
