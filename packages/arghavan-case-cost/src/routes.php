<?php

use Illuminate\Support\Facades\Route;
use Arghavan\CaseCost\Controllers\CaseCostController;
use Arghavan\CaseCost\Controllers\CaseCostSettingsController;

Route::prefix('case-cost')->name('case-cost.')->group(function () {
    Route::get('/', [CaseCostController::class, 'index'])->name('index');
    Route::post('/calculate', [CaseCostController::class, 'calculate'])->name('calculate');
    Route::get('/result/{caseNumber}', [CaseCostController::class, 'show'])->name('show');
});

Route::prefix('api/case-cost')->name('api.case-cost.')->group(function () {
    Route::get('/{caseNumber}', [CaseCostController::class, 'apiShow'])->name('show');
});

// Protect case-cost routes with `web` and `auth` middleware as required
Route::middleware(['web', 'auth'])->group(function () {
    Route::prefix('case-cost')->name('case-cost.')->group(function () {
        Route::get('/', [CaseCostController::class, 'index'])->name('index');
        Route::get('/settings', [CaseCostSettingsController::class, 'index'])->name('settings');
        Route::post('/settings/update', [CaseCostSettingsController::class, 'update'])->name('settings.update');
        Route::post('/calculate', [CaseCostController::class, 'calculate'])->name('calculate');
        Route::get('/result/{caseNumber}', [CaseCostController::class, 'show'])->name('show');
    });

    Route::prefix('api/case-cost')->name('api.case-cost.')->group(function () {
        Route::get('/{caseNumber}', [CaseCostController::class, 'apiShow'])->name('show');
    });
});