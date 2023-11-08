<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Dosen; // Pastikan mengimpor model Dosen
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekapController extends Controller
{
    public function index(Request $request){
        $mahasiswas = Mahasiswa::join('pkl', 'pkl.nim', '=', 'mahasiswa.nim')
                                ->select('mahasiswa.angkatan')
                                ->get();
        return view('dashboardDepartemen', ['mahasiswas' => $mahasiswas]);
    }
}