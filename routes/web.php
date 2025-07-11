<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;

/*
|--------------------------------------------------------------------------
| 🌐 Public Routes
|--------------------------------------------------------------------------
*/

// Landing page langsung ke dashboard toko
// Public routes
Route::get('/', [TokoController::class, 'index'])->name('toko.dashboard');
Route::get('/toko', [TokoController::class, 'index']);
Route::get('/checkout', [TokoController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [TokoController::class, 'prosesCheckout'])->name('checkout.submit');
Route::get('/produk/{id}', [TokoController::class, 'show']);

// 🔍 Tambah ini untuk pencarian berdasarkan kode_booking
Route::get('/cek-pesanan', [TokoController::class, 'formCekPesanan'])->name('pesanan.form');
Route::post('/cek-pesanan', [TokoController::class, 'cariPesanan'])->name('pesanan.cari');

/*
|--------------------------------------------------------------------------
| 🔐 Authentication Routes (Login, Register)
|--------------------------------------------------------------------------
*/

// Akses melalui /admin/login
Route::prefix('admin')->group(function () {
    Auth::routes(); // Menyediakan login, register, dll
});

/*
|--------------------------------------------------------------------------
| 🔐 Admin Panel Routes (c-panel)
|--------------------------------------------------------------------------
*/
Route::prefix('c-panel')->middleware('auth')->group(function () {

    // Halaman utama panel
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Dashboard statistik
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/detail/{tanggal}', [DashboardController::class, 'detail'])->name('dashboard.detail');

    /*
    |--------------------------------------------------------------------------
    | 👤 Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | 👥 User Management
    |--------------------------------------------------------------------------
    */
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
    });

    /*
    |--------------------------------------------------------------------------
    | 🔔 Notifikasi
    |--------------------------------------------------------------------------
    */
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [NotifikasiController::class, 'index'])->name('index');
        Route::get('/{id}/baca', [NotifikasiController::class, 'baca'])->name('baca');
        Route::post('/simpan', [NotifikasiController::class, 'simpan'])->name('simpan');
    });

    /*
    |--------------------------------------------------------------------------
    | 🔐 Hak Akses / Permissions
    |--------------------------------------------------------------------------
    */
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionController::class, 'update'])->name('permissions.update');

    /*
    |--------------------------------------------------------------------------
    | ✍️ Summernote Editor (Contoh)
    |--------------------------------------------------------------------------
    */
    Route::view('/summernote', 'vendor.summernote.example')->name('summernote');

    /*
    |--------------------------------------------------------------------------
    | 📦 Kategori Barang
    |--------------------------------------------------------------------------
    */
    Route::resource('kategori', KategoriController::class);

    /*
    |--------------------------------------------------------------------------
    | 📦 Produk (Master Barang)
    |--------------------------------------------------------------------------
    */
    Route::resource('produk', ProdukController::class);
    
});
