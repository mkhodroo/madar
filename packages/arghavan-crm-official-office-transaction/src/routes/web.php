<?php

use Arghavan\OfficialOfficeTransaction\Controllers\IndexOfficialOfficeTransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('official-office-transactions.')->prefix('official-office-transactions')->middleware(['web', 'auth','access:گزارش دفتر رسمی'])->group(function(){
    Route::get('index', [IndexOfficialOfficeTransactionController::class, 'index'])->name('index');
    Route::get('export', [IndexOfficialOfficeTransactionController::class, 'export'])->name('export');
});
