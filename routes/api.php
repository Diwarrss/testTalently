<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function () {
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/login', [AuthController::class, 'login']);

  Route::middleware('auth:sanctum')->group(function () {
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    /**
     * Add Routes for Tasks
     */
    Route::get('tasks', [TaskController::class, 'index']);
    Route::post('tasks', [TaskController::class, 'store']);
    Route::put('tasks/sync', [TaskController::class, 'sync']);
    Route::put('tasks/{task}', [TaskController::class, 'update']);

    /**
     * Add Routes for Statuses
     */
    Route::get('statuses', [StatusController::class, 'index']);
  });
});
