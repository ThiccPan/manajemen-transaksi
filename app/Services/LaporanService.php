<?php

namespace App\Services;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanService
{
    public function getAllLaporanUser(int $userId, $limit = 5)
    {
        $query = Laporan::with('user')->where('user_id', '=', $userId);
        $data = $query->limit($limit)->get();

        return $data;
    }

    public function getAllLaporan($limit = 5)
    {
        $query = Laporan::with('user');
        $data = $query->limit($limit)->get();

        return $data;
    }

    public function getLaporanById(string $laporanId)
    {
        $data = Laporan::with('user')
            ->where('id', '=', $laporanId)
            ->first();

        return $data;
    }

    public function addLaporan(Request $request, int $userId)
    {
        $laporanBaru = new Laporan();
        $laporanBaru->id = $laporanBaru->newUniqueId();
        $laporanBaru->user_id = $userId;

        $inputCoordinate = $request->coordinate;
        $fileBuktiPembayaran = $request->file("buktiPembayaran");
        $fileExt = $fileBuktiPembayaran->extension();

        $fileBuktiPembayaranPath = $fileBuktiPembayaran
            ->storeAs('public/images', "{$laporanBaru->id}.{$fileExt}");

        $laporanBaru->url_koordinat = $inputCoordinate;
        $laporanBaru->dokumen = $fileBuktiPembayaranPath;

        $laporanBaru->save();
        return $laporanBaru;
    }
}
