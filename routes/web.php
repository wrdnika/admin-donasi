<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DonationReportController;



Route::get('/', function () {
    return redirect()->route('campaigns.index');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(CheckAdmin::class)->group(function () {
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{id}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
    Route::patch('/campaigns/{id}', [CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('/campaigns/{id}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');
    Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles.index');
    Route::get('/profiles/create', [ProfileController::class, 'create'])->name('profiles.create');
    Route::post('/profiles', [ProfileController::class, 'store'])->name('profiles.store');
    Route::get('/profiles/{id}/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::patch('/profiles/{id}', [ProfileController::class, 'update'])->name('profiles.update');
    Route::delete('/profiles/{id}', [ProfileController::class, 'destroy'])->name('profiles.destroy');
    Route::get('/donation-reports', [DonationReportController::class, 'index'])->name('donation-reports.index');
    Route::patch('donation-reports/{id}', [DonationReportController::class, 'update'])->name('donation-reports.update');
    Route::get('/donation-reports/create', [DonationReportController::class, 'create'])->name('donation-reports.create');
    Route::post('/donation-reports', [DonationReportController::class, 'store'])->name('donation-reports.store');
    Route::get('/donation-reports/{id}/edit', [DonationReportController::class, 'edit'])->name('donation-reports.edit');
    Route::patch('/donation-reports/{id}', [DonationReportController::class, 'update'])->name('donation-reports.update');
    Route::delete('/donation-reports/{id}', [DonationReportController::class, 'destroy'])->name('donation-reports.destroy');
});
