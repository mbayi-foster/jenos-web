<?php

use App\Http\Controllers\Api\CommandeController;
use Illuminate\Support\Facades\Route;

Route::apiResource('commandes', CommandeController::class); 

require __DIR__.'/apiMobile.php';
require __DIR__.'/apiWeb.php';
require __DIR__.'/apiAuthClient.php';
