<?php

namespace App\Services;

use App\Models\Laporan;
use App\Models\LaporanStatus;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $laporanBaru->type = $request->type;

        $inputCoordinate = $request->coordinate;
        $fileBuktiPembayaran = $request->file("buktiPembayaran");
        // TODO: handle multiple mage
        $fileExt = $fileBuktiPembayaran[0]->extension();

        $fileBuktiPembayaran[0]->storeAs('public', "images/{$laporanBaru->id}.{$fileExt}");

        $laporanBaru->url_koordinat = $inputCoordinate;
        $laporanBaru->dokumen = "images/{$laporanBaru->id}.{$fileExt}";

        $laporanBaru->status = LaporanStatus::CHECK_IN->value;

        $laporanBaru->save();
        return $laporanBaru;
    }

    public function updateLaporan($updateLaporanDTO)
    {
        $checkOutTime = Carbon::now()->toDateTimeString();
        $data = Laporan::where('id', '=', $updateLaporanDTO["laporanId"])
            ->first();
        $data->check_out_at = $checkOutTime;
        $data->status = LaporanStatus::CHECK_OUT->value;
        $data->save();
        Log::info("laporan " . $data->id . " is updated");
    }
}
