<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ZoneController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::apiResource('zones', ZoneController::class);
Route::get('status/change/{id}', [UserController::class, 'change_status'])->name('status.users.change');
Route::get('zones/status/change/{id}', [ZoneController::class, 'change_status'])->name('status.zones.change');