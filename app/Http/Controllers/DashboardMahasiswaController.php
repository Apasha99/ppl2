<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswaController extends Controller
{
    public function dashboardMahasiswa(Request $request)
    {
        // Pastikan bahwa yang sedang login memiliki role_id 1 (mahasiswa)
        if (Auth::user()->role_id === 1) {
            // Ambil data mahasiswa yang sedang login
            $mahasiswa = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
                ->join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
                ->where('mahasiswa.iduser', Auth::user()->id)
                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'dosen_wali.nama as dosen_nama')
                ->first();
            $user = User::select('foto');

            // Lebih baik mengecek jika $mahasiswa tidak null sebelum mengirimkannya ke tampilan.
            // Ini untuk menghindari kesalahan jika tidak ada data mahasiswa yang sesuai dengan user yang sedang login.
            if ($mahasiswa) {
                return view('dashboardMahasiswa', ['mahasiswa' => $mahasiswa,'user'=>$user]);
            }
        }

        // Jika user tidak memiliki role_id 1 atau tidak ditemukan data mahasiswa yang sesuai, Anda dapat mengirimkan tampilan yang sesuai.
        return view('dashboardMahasiswa'); // Misalnya, tampilan kosong.
    }
  
}
