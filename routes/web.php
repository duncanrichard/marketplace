<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PraMemberController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\StrategicPartnershipController;
use App\Http\Controllers\PermissionController;


/*
|--------------------------------------------------------------------------
| 🌐 Public Routes with Localization
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::get('/', fn() => redirect()->route('login'));

    // Form Pendaftaran Pra Member dengan Event
    Route::get('/pra-member/{event}', [PraMemberController::class, 'show'])->name('pra-member.show');
    Route::post('/pra-member/{event}', [PraMemberController::class, 'store'])->name('pra-member.store');
});

/*
|--------------------------------------------------------------------------
| 🔐 Authentication
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| 📂 Protected Panel Routes (c-panel)
|--------------------------------------------------------------------------
*/
Route::prefix('c-panel')->middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/detail/{tanggal}', [DashboardController::class, 'detail'])->name('dashboard.detail');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
    });

    // Event Management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/submission', [EventController::class, 'submission'])->name('submission');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/store', [EventController::class, 'store'])->name('store');
        Route::post('/import', [EventController::class, 'import'])->name('import');
        Route::get('/show/{id}', [EventController::class, 'show'])->name('show');
        Route::patch('/update-status/{id}', [EventController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/upload-photos', [EventController::class, 'uploadPhotos'])->name('uploadPhotos');
        Route::patch('/{id}', [EventController::class, 'update'])->name('update');

        // Import Pra Member ke Event
        Route::post('/{event}/pra-members/import', [EventController::class, 'import_pra_member'])
            ->name('pra-members.import');

        // Email confirmation
        Route::get('/{id}/status', [EventController::class, 'handleEmailAction'])->name('update-status')->middleware('signed');
        Route::get('/{id}/email-action', [EventController::class, 'handleEmailAction'])->name('handle-email-action')->middleware('signed');
    });

    // Notifikasi
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [NotifikasiController::class, 'index'])->name('index');
        Route::get('/{id}/baca', [NotifikasiController::class, 'baca'])->name('baca');
        Route::post('/simpan', [NotifikasiController::class, 'simpan'])->name('simpan');
    });

    // Campaign Management
    Route::prefix('campaign-categories')->name('campaign-categories.')->group(function () {
        Route::get('/', [CampaignController::class, 'index'])->name('index');
        Route::get('/create', [CampaignController::class, 'create'])->name('create');
        Route::post('/', [CampaignController::class, 'store'])->name('store');
        Route::put('/{id}', [CampaignController::class, 'update'])->name('update');
        Route::delete('/{id}', [CampaignController::class, 'destroy'])->name('destroy');
    });

    // Kunjungan Marketing
    Route::resource('visits', VisitController::class);
    Route::post('visits/import', [VisitController::class, 'import'])->name('visits.import');

    // Kerjasama
    Route::resource('strategic-partnerships', StrategicPartnershipController::class);
    Route::post('/strategic-partnerships/import', [StrategicPartnershipController::class, 'import'])->name('strategic-partnerships.import');

    // ✅ Import Pra Member Tanpa Event (Non Event)
    Route::get('/pra-member/import', [PraMemberController::class, 'importForm'])->name('import.pra-member');
    Route::post('/pra-member/import', [PraMemberController::class, 'importStore'])->name('import.pra-member.store');


    // ✅ Hak Akses Dinamis
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionController::class, 'update'])->name('permissions.update');

    // Contoh Editor
    Route::view('/summernote', 'vendor.summernote.example')->name('summernote');
});