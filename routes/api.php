<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// menggunakan group routes dengan perfix
Route::prefix('alumni')->group(function () {
    Route::get('/', [AlumniController::class, 'index']);
    Route::post('/', [AlumniController::class, 'store']);
    Route::get('/{id}', [AlumniController::class, 'show']);
    Route::put('/{id}', [AlumniController::class, 'update']);
    Route::delete('/{id}', [AlumniController::class, 'destroy']);
    Route::get('/search/{name}', [AlumniController::class, 'search']);

    Route::get('/status/fresh-graduate', [AlumniController::class, 'freshgraduate']);
    Route::get('/status/employed', [AlumniController::class, 'employed']);
    Route::get('/status/unemployed', [AlumniController::class, 'unemployed']);
});
