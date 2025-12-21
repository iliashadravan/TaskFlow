<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });

    Route::prefix('projects')->group(function () {
        Route::get('', [ProjectController::class, 'index']);
        Route::post('', [ProjectController::class, 'store']);
        Route::get('/{project}', [ProjectController::class, 'show']);
        Route::post('/{project}/update', [ProjectController::class, 'update']);
        Route::post('/{project}/delete', [ProjectController::class, 'destroy']);
        Route::post('/{project}/add-user', [ProjectMemberController::class, 'addUser']);
        Route::post('/{project}/remove-user', [ProjectMemberController::class, 'removeUser']);
        Route::get('/{project}/members', [ProjectMemberController::class, 'members']);

        Route::prefix('/{project}/tasks')->group(function () {
            Route::get('', [TaskController::class, 'index']);
            Route::post('', [TaskController::class, 'store']);
            Route::post('/{task}/update', [TaskController::class, 'update']);
            Route::post('/{task}/delete', [TaskController::class, 'destroy']);
            Route::get('/{task}/comments', [CommentController::class, 'index']);
            Route::post('/{task}/comments', [CommentController::class, 'store']);
            Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

        });
    });
});
