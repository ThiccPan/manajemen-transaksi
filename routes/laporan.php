<?php

use App\Http\Controllers\LaporanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('laporan/tambah', [LaporanController::class, 'addTransaksiPage']);
    Route::post('laporan/tambah', [LaporanController::class, 'tambahLaporan'])->name('laporan.kirim');
    Route::get('laporan', [LaporanController::class, 'listLaporan'])->name('laporan.daftar');
    Route::get('laporan/detail/{id}', function (Request $request, string $id) {
        return (new LaporanController)->detailLaporan($request, $id, Auth::user());
    })->name('laporan.detail');
});
