<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function detail(Request $request, $nim){
        $mahasiswa = Mahasiswa::where('nim' , $nim)
                            ->select('nama','nim','angkatan','nip')
                            ->first();

        $dosen = Dosen::leftJoin('users', 'dosen_wali.iduser', '=', 'users.id')
                ->where('dosen_wali.iduser', Auth::user()->id)
                ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.username')
                ->first();
        //$irsData = IRS::select('nim', 'jumlah_sks', 'semester_aktif', 'scanIRS')->orderBy('semester_aktif', 'asc')->get();

        $irsData = IRS::with('mahasiswa', 'pkl')
                ->where('irs.nim', $nim)
                ->select('irs.semester_aktif', 'irs.nim', 'irs.jumlah_sks', 'irs.semester_aktif', 'irs.scanIRS', 'pkl.scanPKL', 'pkl.nilai')
                ->orderBy('semester_aktif', 'asc')
                ->get();

        return view('detailMahasiswa', [
            'mahasiswa' => $mahasiswa,
            'dosen' => $dosen,
            'irsData' => $irsData
        ]);
    }
}
