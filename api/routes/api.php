<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'App\Http\Controllers\AuthController@login');

Route::post(
    'register',
    'App\Http\Controllers\AuthController@register'
)->middleware('auth:sanctum');
