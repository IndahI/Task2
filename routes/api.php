<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Routes protected by Sanctum middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tokens/create', [UserController::class, 'createToken']);
    Route::get('/user', [UserController::class, 'show']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::prefix('todos')->group(function () {
        Route::get('/', [TodoController::class, 'index']);
        Route::post('/add', [TodoController::class, 'store']);
        Route::put('/{todo_id}/edit', [TodoController::class, 'update']);
        Route::get('/{todo_id}', [TodoController::class, 'show']);
        Route::delete('/{todo_id}', [TodoController::class, 'destroy']);
    });
});

// Additional route for user information using Sanctum middleware
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
