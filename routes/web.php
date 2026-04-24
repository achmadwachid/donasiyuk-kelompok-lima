<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\DonationController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profil/donatur', [ProfileController::class, 'showDonatur'])->name('profil.donatur');
    Route::post('/profil/donatur', [ProfileController::class, 'updateDonatur']);
    
    Route::get('/profil/panti', [ProfileController::class, 'showPanti'])->name('profil.panti');
    Route::post('/profil/panti', [ProfileController::class, 'updatePanti']);

    Route::get('/halamanutama/donatur', [DonationController::class, 'showDonatur'])->name('halamanutama.donatur');
    Route::get('/halamanutama/panti', [DonationController::class, 'showPanti'])->name('halamanutama.panti');

    Route::post('/halamanutama/panti/request', [DonationController::class, 'storeRequest'])->name('panti.request.store');
    Route::post('/halamanutama/donatur/donate', [DonationController::class, 'storeDonation'])->name('donatur.donate.store');

    Route::get('/riwayat/donatur', [DonationController::class, 'showHistoryDonatur'])->name('riwayat.donatur');
    Route::get('/riwayat/panti', [DonationController::class, 'showHistoryPanti'])->name('riwayat.panti');
    Route::post('/riwayat/panti/confirm/{id}', [DonationController::class, 'confirmDonation'])->name('panti.donation.confirm');
});