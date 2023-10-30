<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    public function dashboardMahasiswa(Request $request){
        // $mahasiswaCount = Mahasiswa::count();
        // $dosenCount = Dosen::count();
        // $departemenCount = Departemen::count();
        // $userCount = User::count();
        
        // $mahasiswas = Mahasiswa::join('users','mahasiswa.iduser', '=', 'users.id')
        //         ->join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
        //         ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username','users.password','dosen_wali.nip','dosen_wali.nama as dosen_nama')
        //         ->get();
        // $users = User::join('roles','users.role_id','=','roles.id')
        //         ->select('users.role_id','roles.name')
        //         ->get();
        // $operators = Operator::join('users','operator.iduser','=','users.id')
        //         ->select('users.username','users.password','operator.nama','operator.nip')
        //         ->first();
        $request->session()->flush();
        return view('dashboardMahasiswa');
    }    
}
