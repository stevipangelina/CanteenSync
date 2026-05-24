<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KantinController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/', [KantinController::class, 'index']);
Route::get('/dashboard', [KantinController::class, 'dashboard']);
Route::get('/kantin/{id}', [MenuController::class, 'index']);

Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])
    ->name('keranjang.tambah');
Route::get('/keranjang', [KeranjangController::class, 'index'])
    ->name('keranjang.index');
Route::post('/keranjang/update', [KeranjangController::class, 'update'])
    ->name('keranjang.update');
Route::get('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])
    ->name('keranjang.hapus');

Route::get('/checkout', [PemesananController::class, 'index'])
    ->middleware('auth')
    ->name('checkout');
Route::post('/checkout/simpan', [PemesananController::class, 'simpan'])
    ->middleware('auth')
    ->name('checkout.simpan');
Route::get('/pesanan/sukses', [PemesananController::class, 'sukses']);


Route::get('/profil', [ProfileController::class, 'index'])
    ->name('profil');
Route::post('/profil/update', [ProfileController::class, 'update'])
    ->name('profil.update');


Route::get('/riwayat', [RiwayatController::class, 'index'])
    ->name('riwayat');
Route::put('/pesanan/batal/{id}', [RiwayatController::class, 'batalkan'])
    ->name('pesanan.batal');