<?php

use App\Http\Controllers\Api\AuthClientController;
use Illuminate\Routing\Route;

Route::post('login', [AuthClientController::class, 'login'])->name('api-login');