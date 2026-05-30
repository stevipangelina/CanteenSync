<?php

// use App\Models\Akun;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KantinController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\PesananMasukController;
use App\Http\Controllers\RekapanPenjualanController;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/dashboard', [KantinController::class, 'dashboard']);  #->middleware('auth');

Route::get('/', [KantinController::class, 'index']);
Route::get('/kantin/{id}', [MenuController::class, 'index']);

Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/update', [KeranjangController::class, 'update'])->name('keranjang.update');
Route::get('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

Route::get('/checkout', [PemesananController::class, 'index'])->middleware('auth')->name('checkout');
Route::post('/checkout/simpan', [PemesananController::class, 'simpan'])->middleware('auth')->name('checkout.simpan');

Route::get('/pesanan/sukses', [PemesananController::class, 'sukses']);
Route::get('/profil', [ProfileController::class, 'index']) ->name('profil') ->middleware('auth');
Route::post('/profil/update', [ProfileController::class, 'update']) ->name('profil.update') ->middleware('auth');

Route::get('/riwayat', [RiwayatController::class, 'index'] )->middleware('auth')->name('riwayat');
Route::put('/pesanan/batal/{id}', [RiwayatController::class, 'batalkan'])->middleware('auth')->name('pesanan.batal');

Route::get('/menu/{id}',[MenuController::class, 'index'])->name('kantin.menu.index');
Route::get('/menu/{id}/create',[MenuController::class, 'create'])->name('kantin.menu.create');
Route::post('/menu/{id}/store',[MenuController::class, 'store'])->name('kantin.menu.store');
Route::get('/menu/{id}/edit/{id_menu}',[MenuController::class, 'edit'])->name('kantin.menu.edit');
Route::put('/menu/{id}/update/{id_menu}',[MenuController::class, 'update'])->name('kantin.menu.update');
Route::delete('/menu/{id}/delete/{id_menu}',[MenuController::class, 'destroy'])->name('kantin.menu.delete');

Route::get('/kantin/pesanan/{id_kantin}',[PesananMasukController::class,'index'])->name('kantin.pesanan');
Route::post('/kantin/pesanan/update-status/{id_pesanan}',[PesananMasukController::class,'updateStatus'])->name('kantin.update.status');

Route::get('/kantin/riwayat/{id_kantin}',[RekapanPenjualanController::class,'index'])->name('kantin.riwayat');
// Route::get('/test-auth', function () {
//     dd(
//         Auth::check(),
//         Auth::id(),
//         session()->all()
//     );
// });


