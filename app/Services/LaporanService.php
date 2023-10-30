<?php

namespace App\Services;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanService
{
    public function getAllLaporan($limit = 5)
    {
        $data = DB::table('laporan')
            ->limit($limit)
            ->get();

        return $data;
    }

    public function addLaporan(Request $request, int $userId)
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
        return $laporanBaru;
    }
}