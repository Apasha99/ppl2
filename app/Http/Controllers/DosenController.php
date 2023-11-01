<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function detail(Request $request, $mahasiswa){
        if ($mahasiswa) {
            return view('detailMahasiswa', compact('mahasiswa'));
        }
    }
}
