<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardDosenController extends Controller
{
    public function dashboardDosen(Request $request){
        $request->session()->flush();
        //dd('ini halaman dashboard');
        return view('dashboardDosen');
    }
}
