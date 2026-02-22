<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\SocialAidController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DebtController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [HouseController::class, 'index'])->name('home');

Route::resource('houses', HouseController::class);
Route::get('houses/{house}/kk', [HouseController::class, 'kk'])
    ->name('houses.kk')
    ->middleware(['auth', 'role:super_admin,admin_desa', 'throttle:20,1']);
Route::get('houses-export', [HouseController::class, 'export'])->name('houses.export');
Route::post('houses-import', [HouseController::class, 'import'])->name('houses.import');

// UMKM Management
Route::resource('umkms', UmkmController::class);
Route::get('umkms-export', [UmkmController::class, 'export'])->name('umkms.export');
Route::post('umkms-import', [UmkmController::class, 'import'])->name('umkms.import');

// User Management Routes
Route::middleware(['auth', 'role:super_admin,admin_desa'])->group(function () {
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
});

// Residents Management
Route::middleware('auth')->group(function () {
    Route::resource('residents', ResidentController::class);
    Route::get('residents-export', [ResidentController::class, 'export'])->name('residents.export');
});

// Social Aid Management
Route::middleware('auth')->group(function () {
    Route::resource('social-aids', SocialAidController::class);
    Route::get('social-aids/{socialAid}/recipients', [SocialAidController::class, 'recipients'])->name('social-aids.recipients');
    Route::post('social-aids/{socialAid}/recipients', [SocialAidController::class, 'addRecipient'])->name('social-aids.add-recipient');
    Route::patch('social-aids/{socialAid}/recipients/{resident}', [SocialAidController::class, 'updateRecipientStatus'])->name('social-aids.update-recipient');
});

// Dashboard & Analytics
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');
});

// Debt Management
Route::middleware('auth')->group(function () {
    Route::resource('debts', \App\Http\Controllers\DebtController::class);
    Route::post('debts/{debt}/payment', [\App\Http\Controllers\DebtController::class, 'payment'])->name('debts.payment');
    Route::get('debts-report', [\App\Http\Controllers\DebtController::class, 'report'])->name('debts.report');
    Route::get('debts-export', [\App\Http\Controllers\DebtController::class, 'export'])->name('debts.export');
});
