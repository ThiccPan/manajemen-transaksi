<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('laporan/tambah', [ReportController::class, 'addReportPage'])->name('report.add');
    Route::post('laporan/tambah', [ReportController::class, 'addReport'])->name('report.insert');
    Route::get('laporan', [ReportController::class, 'listReport'])->name('report.list');
    Route::get('laporan/detail/{id}', [ReportController::class, 'detailReport'])->name('report.detail');
    Route::put('laporan/detail/{id}', [ReportController::class, 'updateReport'])->name('report.update');

    Route::get('laporan/export', [ReportController::class, 'downloadReport']);
});
