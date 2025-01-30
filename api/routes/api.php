<?php

use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;

Route::post('login', 'App\Http\Controllers\AuthController@login');

Route::post(
    'register',
    'App\Http\Controllers\AuthController@register'
)->middleware('auth:sanctum');

Route::controller(TravelController::class)->group(function () {
    Route::post('travel', 'create')->middleware('auth:sanctum');
});
