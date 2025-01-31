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
    Route::put('travel/{id}/status', 'updateStatus')->middleware('auth:sanctum');
    Route::get('travel/{id}', 'show')->middleware('auth:sanctum');
    Route::get('travels', 'showAll')->middleware('auth:sanctum');
});
