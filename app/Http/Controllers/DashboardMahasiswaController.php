<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    public function dashboardMahasiswa(Request $request){
        $request->session()->flush();
        //dd('ini halaman dashboard');
        return view('dashboardMahasiswa');
    }
}
