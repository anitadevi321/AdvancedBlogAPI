<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PostController;


// user route
Route::post('/user-registration',[ApiController::class, "register"]);
Route::post('/user-login',[ApiController::class, "login"]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('profile',[ApiController::class, "profile"]);
    Route::get('/logout',[ApiController::class, "logout"]);
});
///Route::post('/user-logout', [ApiController::class, 'logout'])->middleware('auth:sanctum');


//Role route
Route::post('/create_role',[RoleController::class, "store"]);
Route::get('/fetch-role',[RoleController::class, "index"]);
Route::post('/assign-role',[RoleController::class, "assignRole"])->middleware('auth:sanctum');


//Content route
Route::post('/add-content', [PostController::class, "store"]);