<?php

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('laporan/tambah', [LaporanController::class, 'addTransaksiPage'])->name('laporan.tambah');
    Route::post('laporan/tambah', [LaporanController::class, 'tambahLaporan'])->name('laporan.kirim');
    Route::get('laporan', [LaporanController::class, 'listLaporan'])->name('laporan.daftar');
    Route::get('laporan/detail/{id}', [LaporanController::class, 'detailLaporan'])->name('laporan.detail');
    Route::put('laporan/detail/{id}', [LaporanController::class, 'updateLaporan'])->name('laporan.update');
});
