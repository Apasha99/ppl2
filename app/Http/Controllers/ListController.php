<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function index(Request $request, $angkatan, $status){
        $mahasiswas = Mahasiswa::join('pkl', 'pkl.nim', '=', 'mahasiswa.nim')
                                ->where('mahasiswa.angkatan', $angkatan)
                                ->where('pkl.statusPKL', $status)
                                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai')
                                ->get();

        return view('listMahasiswa', ['mahasiswas' => $mahasiswas]);
    }
    
}