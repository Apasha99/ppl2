<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Mahasiswa;
use App\Models\Dosen; // Pastikan mengimpor model Dosen
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function list(Request $request, $tahun, $status){
        $mahasiswas = Mahasiswa::join('pkl', 'pkl.nim', '=', 'mahasiswa.nim')
                                ->where('pkl.tahun', $tahun)
                                ->where('pkl.statusPKL', $status)
                                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai')
                                ->get();

        return view('listMahasiswa', ['mahasiswas' => $mahasiswas]);
    }
}