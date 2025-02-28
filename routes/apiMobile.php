<?php
use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\MobileDetailsController;
use App\Http\Controllers\Api\MobileHomeController;
use Illuminate\Support\Facades\Route;


Route::get("mobile-home", [MobileHomeController::class, "home"]);
Route::get("mobile-menu", [MobileHomeController::class, "menu"]);
Route::get("mobile-plats-recents", [MobileHomeController::class, "plats_recents"]);
Route::get("mobile-plats-pops", [MobileHomeController::class, "plats_pops"]);
Route::get("mobile-plats-most", [MobileHomeController::class, "plats_most_pops"]);
Route::get("mobile-plats-menu/{id}", [MobileHomeController::class, "plats_by_menu"]);
Route::get("mobile-plat/{id}", [MobileDetailsController::class, "plat"]);