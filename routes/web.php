<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\DataPasienController;
use App\Http\Controllers\ReservasiController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Localization Group for Public Routes
|--------------------------------------------------------------------------
*/
$localizationGroupData = [
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
];

Route::group($localizationGroupData, function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| Admin (Control Panel) Routes
|--------------------------------------------------------------------------
*/
Route::prefix('c-panel')->middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // User Management
    Route::get('users', [UserController::class, 'index'])->name('users.index');

    // Profile Management
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // Summernote Example
    Route::view('summernote', 'vendor.summernote.example')->name('summernote');

    /*
    |--------------------------------------------------------------------------
    | Data Pasien Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('data-pasien')->group(function () {

    // Route restore harus di atas {id}
    Route::get('/restore', [DataPasienController::class, 'restoreView'])->name('data-pasien.restore-view');
    Route::post('/restore/{id}', [DataPasienController::class, 'restore'])->name('data-pasien.restore');

    // CRUD biasa
    Route::get('/', [DataPasienController::class, 'index'])->name('data-pasien.index');
    Route::get('/create', [DataPasienController::class, 'create'])->name('data-pasien.create');
    Route::post('/', [DataPasienController::class, 'store'])->name('data-pasien.store');
    Route::get('/{id}/edit', [DataPasienController::class, 'edit'])->name('data-pasien.edit');
    Route::put('/{id}', [DataPasienController::class, 'update'])->name('data-pasien.update');
    Route::delete('/{id}', [DataPasienController::class, 'destroy'])->name('data-pasien.destroy');
    Route::get('/{id}', [DataPasienController::class, 'show'])->name('data-pasien.show'); // taruh paling bawah
});


    /*
    |--------------------------------------------------------------------------
    | Reservasi Pasien Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('reservasi')->group(function () {
        Route::get('/', [ReservasiController::class, 'index'])->name('reservasi.index');
        Route::get('/create', [ReservasiController::class, 'create'])->name('reservasi.create'); // menerima ?pasien_id=
        Route::post('/store', [ReservasiController::class, 'store'])->name('reservasi.store');
        Route::get('/{pasien_id}/detail', [ReservasiController::class, 'detail'])->name('reservasi.detail');
        Route::put('/konfirmasi/{id}', [ReservasiController::class, 'konfirmasiKedatangan'])->name('reservasi.konfirmasiKedatangan');
        Route::post('/reschedule', [ReservasiController::class, 'reschedule'])->name('reservasi.reschedule');
    });

});

/*
|--------------------------------------------------------------------------
| File Manager Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
