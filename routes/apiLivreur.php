<?php
use App\Http\Controllers\Api\LivreurController;
use App\Http\Controllers\Api\Livreur\CommandeLivreurController;
use App\Http\Controllers\Api\Livreur\AuthLivreurController;
use Illuminate\Support\Facades\Route;

Route::post("login-livreur", [LivreurController::class, "login"]);
Route::get("pending-commandes-livreur/{id}", [CommandeLivreurController::class, "pending"]);

Route::prefix('livreurs')->group(function () {
    Route::post('login', [AuthLivreurController::class, 'login']);
    Route::get('commandes/{id}', [CommandeLivreurController::class, 'commandes']);
    Route::patch('event/{id}', [CommandeLivreurController::class, 'event']);
});