<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function detail(Request $request, $nim){
        $mahasiswa = Mahasiswa::find($nim)->get();
        //$irsData = IRS::select('nim', 'jumlah_sks', 'semester_aktif', 'scanIRS')->orderBy('semester_aktif', 'asc')->get();

        return view('detailMahasiswa', [
            'mahasiswa' => $mahasiswa,
        ]);
    }
}
