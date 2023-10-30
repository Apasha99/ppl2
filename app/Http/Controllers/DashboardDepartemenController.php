<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardDepartemenController extends Controller
{
    public function dashboardDepartemen(Request $request){
        $request->session()->flush();
        //dd('ini halaman dashboard');
        return view('dashboardDepartemen');
    }
}
