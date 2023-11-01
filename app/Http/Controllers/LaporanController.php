<?php

namespace App\Http\Controllers;

use App\Services\LaporanService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LaporanController extends Controller
{
    public function AddTransaksiPage(Request $request)
    {
        return view('tambah-laporan');
    }

    public function tambahLaporan(Request $request, Authenticatable $user)
    {
        $laporanBaru = (new LaporanService())->addLaporan($request, $user->id);        
        return redirect(route('laporan.daftar'));
    }

    public function listLaporan(Authenticatable $user)
    {
        $laporanData = [];
        // TODO: refactor authorization handling
        if ($user->divisi_id == 2) {
            $laporanData = (new LaporanService())->getAllLaporan(5);
        } else {
            $laporanData = (new LaporanService())->getAllLaporanUser($user->id, 5);
        }
        return view('list-laporan', [
            "daftar_laporan" => $laporanData,
        ]);
    }

    public function detailLaporan(
        Request $request,
        string $laporanId,
    ) {
        $user = $request->user();
        $dataLaporan = (new LaporanService())
            ->getLaporanById($laporanId);

        // TODO: refactor authorization handling
        if (
            $user->id != $dataLaporan->user_id
            && $user->isAdmin()
        ) {
            return redirect(route('laporan.daftar'));
        }

        return view('detail-laporan', [
            'laporan' => $dataLaporan,
        ]);
    }
}
