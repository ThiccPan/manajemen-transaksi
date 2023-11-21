<?php

namespace App\Http\Controllers;

use App\Services\LaporanService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LaporanController extends Controller
{
    private LaporanService $laporanService;
    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function AddTransaksiPage(Request $request)
    {
        return view('tambah-laporan');
    }

    public function tambahLaporan(Request $request, Authenticatable $user)
    {
        $laporanBaru =
            $this->laporanService
            ->addLaporan($request, $user->id);

        return redirect(route('laporan.daftar'));
    }

    public function listLaporan(Request $request)
    {
        $user = $request->user();
        $laporanData = [];
        // TODO: refactor authorization handling
        if ($user->isAdmin()) {
            $laporanData = $this->laporanService->getAllLaporan(5);
        } else {
            $laporanData = $this->laporanService->getAllLaporanUser($user->id, 5);
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
        $dataLaporan = $this
            ->laporanService
            ->getLaporanById($laporanId);

        // TODO: refactor authorization handling
        if (
            $user->id != $dataLaporan->user_id
            && !$user->isAdmin()
        ) {
            return redirect(route('laporan.daftar'));
        }

        return view('detail-laporan', [
            'laporan' => $dataLaporan,
        ]);
    }
}
