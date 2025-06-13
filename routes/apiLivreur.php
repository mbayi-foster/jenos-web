<?php
use App\Http\Controllers\Api\LivreurController;
use App\Http\Controllers\Api\CommandeLivreurController;
use Illuminate\Support\Facades\Route;

Route::post("login-livreur", [LivreurController::class, "login"]);
Route::get("pending-commandes-livreur/{id}", [CommandeLivreurController::class, "pending"]);