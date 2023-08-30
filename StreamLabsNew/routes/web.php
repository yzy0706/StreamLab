<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StreamEventsController;

// Routes for OAuth
Route::get('login/{provider}', [AuthController::class, 'oauthLogin']);
Route::get('callback/{provider}', [AuthController::class, 'handleProviderCallback']);

// Route for getting Stream Events
Route::get('events', [StreamEventsController::class, 'getEvents']);

// Route for marking events as read
Route::post('events/mark-as-read/{id}', [StreamEventsController::class, 'markAsRead']);

// The welcome page
Route::get('/', function () {
    return redirect('/login');
});