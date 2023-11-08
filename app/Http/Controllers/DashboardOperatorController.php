<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Departemen;
use App\Models\Operator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class DashboardOperatorController extends Controller
{
    public function dashboardOperator(Request $request){
        $mahasiswaCount = Mahasiswa::count();
        $dosenCount = Dosen::count();
        $departemenCount = Departemen::count();
        $userCount = User::count();
        
        $mahasiswas = Mahasiswa::join('users','mahasiswa.iduser', '=', 'users.id')
                ->join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
                ->join('generate_akun','generate_akun.nim','mahasiswa.nim')
                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username','generate_akun.password','dosen_wali.nip','dosen_wali.nama as dosen_nama')
                ->get();
        $users = User::join('roles','users.role_id','=','roles.id')
                ->select('users.role_id','roles.name')
                ->get();
        $operators = Operator::join('users','operator.iduser','=','users.id')
                ->select('users.username','users.password','operator.nama','operator.nip')
                ->first();
        return view('dashboardOperator', ['operators'=>$operators,'users'=>$users,'mahasiswas'=>$mahasiswas,'user_count'=> $userCount, 'mahasiswa_count'=>$mahasiswaCount,'dosen_count'=>$dosenCount, 'departemen_count'=>$departemenCount]);
    }    
    
}
