<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;

///Route::post('/user-logout', [ApiController::class, 'logout'])->middleware('auth:sanctum');

// user route
Route::post('/user-registration',[ApiController::class, "register"]);
Route::post('/user-login',[ApiController::class, "login"]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('profile',[ApiController::class, "profile"]);
    Route::get('/logout',[ApiController::class, "logout"]);

    //content route
    Route::get('/index',[PostController::class, "index"]);
    Route::post('/add-content', [PostController::class, "store"]);
    Route::get('/show/{id}', [PostController::class, "show"]);
    Route::put('/update', [PostController::class, "update"]);
    Route::delete('/destroy/{id}', [PostController::class, "destroy"]);


    //comment route
    Route::get('/index/{postid}', [CommentController::class, "index"]);
    Route::post('/store', [CommentController::class, "store"]);
    Route::get('/show/{commentId}/{postId}', [CommentController::class, "show"]);
    Route::put('/update', [CommentController::class, "update"]);
});


//Role route
Route::post('/create_role',[RoleController::class, "store"]);
Route::get('/fetch-role',[RoleController::class, "index"]);
Route::post('/assign-role',[RoleController::class, "assignRole"])->middleware('auth:sanctum');

