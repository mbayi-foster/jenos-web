<?php

use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\LivreurController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthClientController::class, 'login']);
Route::apiResource('clients', AuthClientController::class);
Route::post('new-client', [AuthClientController::class, 'newUser']);
