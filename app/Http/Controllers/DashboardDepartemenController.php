<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class DashboardDepartemenController extends Controller
{
    public function dashboardDepartemen(Request $request){
        if (Auth::user()->role_id === 4){
            $departemen = Departemen::leftJoin('users', 'departemen.iduser', '=', 'users.id')
                ->where('departemen.iduser', Auth::user()->id)
                ->select('departemen.nama', 'departemen.kode', 'users.username')
                ->first();
            
            // $user = User::where('id', Auth::user()->id)->select('foto')->first();
            if ($departemen) {
                return view('dashboardDepartemen', ['departemen' => $departemen]);
            }
        }
        // $request->session()->flush();
        //dd('ini halaman dashboard');
        return view('dashboardDepartemen');
    }
}
