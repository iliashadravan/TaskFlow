<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
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
     });
 });

