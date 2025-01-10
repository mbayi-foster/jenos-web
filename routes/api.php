<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::get('status/change/{id}', [UserController::class, 'change_status'])->name('status.change');