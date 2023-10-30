<?php

use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('laporan/tambah', [LaporanController::class, 'addTransaksiPage']);

Route::post('laporan/tambah', [LaporanController::class, 'tambahLaporan'])->name('laporan.kirim');

Route::get('laporan', [LaporanController::class, 'listLaporan'])->name('laporan.list');