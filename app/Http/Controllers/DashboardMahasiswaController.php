<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswaController extends Controller
{
    public function dashboardMahasiswa(Request $request)
    {
        // Pastikan bahwa yang sedang login memiliki role_id 1 (mahasiswa)
        if (Auth::user()->role_id === 1) {
            // Ambil data mahasiswa yang sedang login
            $mahasiswa = Mahasiswa::leftJoin('users', 'mahasiswa.iduser', '=', 'users.id')
                ->leftJoin('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
                ->where('mahasiswa.iduser', Auth::user()->id)
                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'dosen_wali.nama as dosen_nama')
                ->first();
            $nim = $request->user()->mahasiswa->nim;
            $user = User::where('id', Auth::user()->id)->select('foto')->first();
            $latestIRS = IRS::where('nim',$nim)
                        ->orderBy('created_at', 'desc')->first();
            $semesterAktif = $latestIRS ? $latestIRS->semester_aktif : null;
            $latestSKSKumulatif = KHS::where('nim',$nim)
                                ->orderBy('created_at', 'desc')->first();
            $SKSKumulatif = $latestSKSKumulatif ? $latestSKSKumulatif->jumlah_sks_kumulatif : null;
            $latestIPKumulatif = KHS::where('nim',$nim)
                                ->orderBy('created_at', 'desc')->first();
            $IPKumulatif = $latestIPKumulatif ? $latestIPKumulatif->ip_kumulatif : null;
            // Lebih baik mengecek jika $mahasiswa tidak null sebelum mengirimkannya ke tampilan.
            // Ini untuk menghindari kesalahan jika tidak ada data mahasiswa yang sesuai dengan user yang sedang login.
            if ($mahasiswa) {
                return view('dashboardMahasiswa', ['mahasiswa' => $mahasiswa, 'user' => $user, 'semesterAktif' => $semesterAktif,'SKSKumulatif'=>$SKSKumulatif,'IPKumulatif'=>$IPKumulatif]);
            }
        }

        // Jika user tidak memiliki role_id 1 atau tidak ditemukan data mahasiswa yang sesuai, Anda dapat mengirimkan tampilan yang sesuai.
        return view('dashboardMahasiswa'); // Misalnya, tampilan kosong.
    }
}
