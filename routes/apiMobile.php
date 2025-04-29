<?php
use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\Api\MapController;
use App\Http\Controllers\Api\MenuMobileController;
use App\Http\Controllers\Api\MobileDetailsController;
use App\Http\Controllers\Api\MobileHomeController;
use App\Http\Controllers\Api\PanierController;
use App\Http\Controllers\Api\PlatController;
use Illuminate\Support\Facades\Route;

Route::apiResource("paniers", PanierController::class);
Route::apiResource("map", MapController::class);
Route::apiResource("commandes", CommandeController::class);
Route::get("mobile-home", [MobileHomeController::class, "home"]);
//Route::get("mobile-menu", [MobileHomeController::class, "menu"]);
Route::get("mobile-plats-menu/{id}", [MobileHomeController::class, "plats_by_menu"]);
Route::get("mobile-plat/{id}", [MobileDetailsController::class, "plat"]);
Route::apiResource("mobile-menu", MenuMobileController::class);
Route::get("search/{mot}", [PlatController::class, "search"]);
Route::get("search/", [PlatController::class, "all"]);