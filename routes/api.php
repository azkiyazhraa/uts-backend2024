<?php

use App\Http\Controllers\AlumniController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// alumni
Route::get('/alumni', [AlumniController::class, 'index']);
Route::post('/alumni', [AlumniController::class, 'store']);
Route::get('/alumni/{id}', [AlumniController::class, 'show']);
Route::put('/alumni/{id}', [AlumniController::class, 'update']);
Route::delete('/alumni/{id}', [AlumniController::class, 'destroy']);
Route::get('/alumni/search/{name}', [AlumniController::class, 'search']);
Route::get('/alumni/freshgraduate', [AlumniController::class, 'carilulus']);
Route::get('/alumni/employed', [AlumniController::class, 'employed']);
Route::get('/alumni/unemployed', [AlumniController::class, 'unemployed']);
