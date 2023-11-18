<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Skripsi;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\IRS;
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
                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'dosen_wali.nama as dosen_nama','mahasiswa.jalur_masuk')
                ->first();

            $nim = $request->user()->mahasiswa->nim;
            $user = User::where('id', Auth::user()->id)->select('foto')->first();

            $latestPKL = PKL::where('nim',$nim)
                        ->orderBy('created_at', 'desc')->first();
            $statusPKL = $latestPKL ? $latestPKL->statusPKL : null;
            $status = $latestPKL ? $latestPKL->status : null;

            $latestSkripsi = Skripsi::where('nim',$nim)
                        ->orderBy('created_at', 'desc')->first();
            $statusSkripsi = $latestSkripsi ? $latestSkripsi->statusSkripsi : null;
            $statusSkr = $latestSkripsi ? $latestSkripsi->status : null;

            $latestKHS = KHS::where('nim',$nim)
                            ->orderBy('created_at', 'desc')->first();
            $SKSKumulatif = $latestKHS ? $latestKHS->jumlah_sks_kumulatif : null;
            $IPKumulatif = $latestKHS ? $latestKHS->ip_kumulatif : null;
            $statusKHS = $latestKHS ? $latestKHS->status : null;

            $latestIRS = IRS::where('nim',$nim)
                            ->orderBy('created_at', 'desc')->first();
            $SemesterAktif = $latestIRS ? $latestIRS->semester_aktif : null;
            $JumlahSKS = $latestIRS ? $latestIRS->jumlah_sks : null;
            $statusIRS = $latestIRS ? $latestIRS->status : null;
            
            if ($mahasiswa) {
                return view('dashboardMahasiswa', ['statusIRS'=>$statusIRS,'JumlahSKS'=>$JumlahSKS,'SemesterAktif'=>$SemesterAktif,'statusKHS'=>$statusKHS,
                'mahasiswa' => $mahasiswa, 'user' => $user,'status'=>$status,'statusSkr'=>$statusSkr, 
                'statusPKL' => $statusPKL,'statusSkripsi'=>$statusSkripsi,'SKSKumulatif'=>$SKSKumulatif,'IPKumulatif'=>$IPKumulatif]);
            }
        }

        // Jika user tidak memiliki role_id 1 atau tidak ditemukan data mahasiswa yang sesuai, Anda dapat mengirimkan tampilan yang sesuai.
        return view('dashboardMahasiswa'); // Misalnya, tampilan kosong.
    }
}
