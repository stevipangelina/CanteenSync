<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KantinController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KeranjangController;
//use App\Http\Controllers\PemesananController;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/dashboard', [KantinController::class, 'dashboard']);  #->middleware('auth');

Route::get('/', [KantinController::class, 'index']);
Route::get('/kantin/{id}', [MenuController::class, 'index']);

Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/update', [KeranjangController::class, 'update'])->name('keranjang.update');
Route::get('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

// Route::get('/checkout', [PemesananController::class, 'index'])->name('checkout');
// Route::post('/checkout/simpan', [PemesananController::class, 'simpan'])->name('checkout.simpan');

// Route::get('/pesanan/sukses', [PemesananController::class, 'sukses']);