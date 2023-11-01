<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardDosenController extends Controller
{
    public function dashboardDosen(Request $request){
        $mahasiswas = Mahasiswa::join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'dosen_wali.nip as dosen_wali_nip')
            ->get();

        $mahasiswaCount = Mahasiswa::count();
        $mahasiswaPerwalianCount = Dosen::count();

        return view('dashboardDosen', [
            'mahasiswas' => $mahasiswas,
            'mahasiswaCount' => $mahasiswaCount,
            'mahasiswaperwalian_count' => $mahasiswaPerwalianCount
        ]);
        
    }    
}