<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardDepartemenController extends Controller
{
    public function dashboardDepartemen(Request $request)
    {
        if (Auth::user()->role_id === 4) {
            $departemen = Departemen::leftJoin('users', 'departemen.iduser', '=', 'users.id')
                ->where('departemen.iduser', Auth::user()->id)
                ->select('departemen.nama', 'departemen.kode', 'users.username')
                ->first();

            $mahasiswas = DB::table('mahasiswa as m')
                ->leftJoin('pkl as p', 'm.nim', '=', 'p.nim')
                ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN p.statusPKL = "lulus" THEN 1 ELSE 0 END), 0) as lulus_count'), 
                                        DB::raw('COALESCE(SUM(CASE WHEN p.statusPKL = "tidak lulus" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
                ->groupBy('m.angkatan')
                ->get();

            // $user = User::where('id', Auth::user()->id)->select('foto')->first();
            if ($departemen) {
                return view('dashboardDepartemen', ['departemen' => $departemen, 'mahasiswas' => $mahasiswas]);
            }
        }
        // $request->session()->flush();
        //dd('ini halaman dashboard');
        return view('dashboardDepartemen');
    }
}
