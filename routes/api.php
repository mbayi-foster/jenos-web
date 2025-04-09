<?php

use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\Api\LivreurController;
use Illuminate\Support\Facades\Route;

Route::apiResource('commandes', CommandeController::class);
Route::apiResource('livreurs', LivreurController::class);
Route::get("livreurs/status/{id}", [LivreurController::class, "change_status"]);


require __DIR__ . '/apiMobile.php';
require __DIR__ . '/apiWeb.php';
require __DIR__ . '/apiAuthClient.php';
