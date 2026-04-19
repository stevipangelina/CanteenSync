<?php

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

//Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth');

//Route::get('/logout', [AuthController::class, 'logout']);

// Route::get('/register', [AuthController::class,'showRegister']);
// Route::post('/register', [AuthController::class,'register']);

// Route::get('/login', [AuthController::class,'showLogin']);
// Route::post('/login', [AuthController::class,'login']);

// Route::get('/dashboard', [AuthController::class,'dashboard'])->middleware('auth');

// Route::get('/logout', [AuthController::class,'logout']);