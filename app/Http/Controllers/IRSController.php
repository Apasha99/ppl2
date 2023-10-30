<?php

use App\Http\Controllers\Controller;
use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class IRSController extends Controller
{
    public function index(Request $request)
    {
        $nim = $request->input('nim');
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $semesterSaatIni = $this->hitungSemesterSaatIni(); // Fungsi untuk menghitung semester saat ini

        $irsSudahDiisi = IRS::where('nim', $nim)->where('semester_aktif', $semesterSaatIni)->exists();

        return view('irs.index', ['irsSudahDiisi' => $irsSudahDiisi, 'mahasiswa' => $mahasiswa]);
    }

    public function create(Request $request)
    {
        $nim = $request->input('nim');
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $semesterSaatIni = $this->hitungSemesterSaatIni(); // Fungsi untuk menghitung semester saat ini

        $irsSudahDiisi = IRS::where('nim', $nim)->where('semester_aktif', $semesterSaatIni)->exists();

        if (!$irsSudahDiisi) {
            $irs = new IRS();
            $irs->semester_aktif = $semesterSaatIni;
            $irs->scanIRS = $request->input('scanIRS');
            $irs->jumlah_sks = $request->input('jumlah_sks');
            $irs->status = 'Pending';
            $irs->nim = $nim;
            $irs->nip = $mahasiswa->nip;
            $irs->save();

            // Tambahkan logika pengiriman IRS ke dosen wali di sini

            return redirect()->route('irs.index')->with('success', 'IRS berhasil ditambahkan.');
        } else {
            return redirect()->route('irs.index')->with('error', 'IRS untuk semester ini sudah diisi.');
        }
    }

    private function hitungSemesterSaatIni()
    {
        // Implementasikan logika penghitungan semester saat ini sesuai kebutuhan Anda
        // ...
    }

    // Tambahkan fungsi pengiriman IRS ke dosen wali di sini
}

