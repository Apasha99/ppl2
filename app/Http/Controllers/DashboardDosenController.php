<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class DashboardDosenController extends Controller
{
    public function dashboardDosen(Request $request){  
    if (Auth::user()->role_id === 2) {
            // Ambil data dosen yang sedang login
            $dosens = Dosen::leftJoin('users', 'dosen_wali.iduser', '=', 'users.id')
                ->where('dosen_wali.iduser', Auth::user()->id)
                ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.username')
                ->first();
            $mahasiswaCount = Mahasiswa::count();
            $mahasiswaPerwalian = Mahasiswa::join('dosen_wali','mahasiswa.nip','=','dosen_wali.nip')
                                    ->where('dosen_wali.iduser', Auth::user()->id)
                                    ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'dosen_wali.nip as dosen_wali_nip')
                                    ->get();
            $mahasiswaPerwalianCount = $mahasiswaPerwalian->count();
            
            $user = User::where('id', Auth::user()->id)->select('foto')->first();
            if ($dosens) {
                return view('dashboardDosen', ['dosens' => $dosens, 'user' => $user, 'mahasiswaCount'=> $mahasiswaCount,'mahasiswaPerwalian'=>$mahasiswaPerwalian,'mahasiswaPerwalianCount'=>$mahasiswaPerwalianCount]);
            }
        }

        // Jika user tidak memiliki role_id 1 atau tidak ditemukan data mahasiswa yang sesuai, Anda dapat mengirimkan tampilan yang sesuai.
        return view('dashboardDosen'); // Misalnya, tampilan kosong.
    } 

    public function searchMahasiswa(Request $request)
    {
        $search = $request->input('search');
        $dosens = Dosen::leftJoin('users', 'dosen_wali.iduser', '=', 'users.id')
            ->where('dosen_wali.iduser', Auth::user()->id)
            ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.username')
            ->first();
        $mahasiswaCount = Mahasiswa::count();
        $mahasiswaPerwalian = Mahasiswa::join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->where('dosen_wali.iduser', Auth::user()->id)
            ->select('mahasiswa.nama as nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'dosen_wali.nip as dosen_wali_nip')
            ->get();
        $mahasiswaPerwalianCount = $mahasiswaPerwalian->count();

        $user = User::where('id', Auth::user()->id)->select('foto')->first();

        // Menggunakan metode WHERE LIKE untuk mencari mahasiswa yang sesuai
        $mahasiswaPerwalian = Dosen::where('dosen_wali.iduser', Auth::user()->id)
            ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
            ->where(function ($query) use ($search) {
                $query->where('mahasiswa.nama', 'like', '%' . $search . '%')
                    ->orWhere('mahasiswa.nim', 'like', '%' . $search . '%')
                    ->orWhere('mahasiswa.angkatan', 'like', '%' . $search . '%')
                    ->orWhere('mahasiswa.status', 'like', '%' . $search . '%');
            })
            ->get();
        
        return view('dashboardDosen', ['user' => $user, 'dosens' => $dosens, 'mahasiswaCount' => $mahasiswaCount, 'mahasiswaPerwalian' => $mahasiswaPerwalian, 'mahasiswaPerwalianCount' => $mahasiswaPerwalianCount]);
    }

}
