<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Services\LaporanService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function AddTransaksiPage()
    {
        return view('tambah-laporan');
    }

    public function tambahLaporan(Request $request)
    {
        $user = Auth::getUser();
        $laporanBaru = (new LaporanService())->addLaporan($request, $user->id);
        ddd($laporanBaru);
    }

    public function listLaporan(Authenticatable $user)
    {
        $laporanData = (new LaporanService())->getAllLaporan($user->id, 5);
        // ddd($laporanData);
        return view('list-laporan', [
            "daftar_laporan" => $laporanData,
        ]);
        
    }
}
