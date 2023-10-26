<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function AddTransaksiPage()
    {
        return view('tambah-laporan');
    }

    public function tambahLaporan(Request $request)
    {
        $laporanBaru = new Laporan();
        $laporanBaru->id = $laporanBaru->newUniqueId();

        $inputCoordinate = $request->coordinate;
        $fileBuktiPembayaran = $request->file("buktiPembayaran");
        $fileExt = $fileBuktiPembayaran->extension();

        $fileBuktiPembayaranPath = $fileBuktiPembayaran
            ->storeAs('images', "{$laporanBaru->id}.{$fileExt}");

        $laporanBaru->url_koordinat = $inputCoordinate;
        $laporanBaru->dokumen = $fileBuktiPembayaranPath;

        $laporanBaru->save();
        ddd($fileBuktiPembayaran);
    }

    public function listLaporan()
    {
        return view('list-laporan', [
            "daftar_laporan" => [
                "laporan 1",
                "laporan 2"
            ]
        ]);
    }
}
