<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class IRSController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::select('nama','nim')->get();
        
        $irsData = IRS::select('nim','status','jumlah_sks','semester_aktif')->get();

        return view('irs', [
            'mahasiswa' => $mahasiswa,
            'irsData' => $irsData,
        ]);
    }
    public function create(Request $request)
    {
        $nim = $request->input('nim');
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $semesterSaatIni = $this->hitungSemesterSaatIni();

        return view('irs-create', [
            'mahasiswa' => $mahasiswa,
            'semesterSaatIni' => $semesterSaatIni,
        ]);
    }
    public function store(Request $request)
    {
        $nim = $request->input('nim');

        // Validasi input sesuai kebutuhan
        $validatedData = $request->validate(IRS::rules($request->input('semester_aktif'), $nim));

        // Menyimpan data IRS
        $irs = new IRS($validatedData);
        $irs->save();

        return redirect()->route('irs.irs', ['nim' => $nim])->with('success', 'IRS berhasil ditambahkan.');
    }



    // public function create(Request $request)
    // {
    //     $nim = $request->irs;
    //     $irs = IRS::where('nim', $nim)->first();
        
    //     if (!$irs) {
    //         return redirect()->route('irs.create')->with('error', 'Mahasiswa tidak ditemukan.');
    //     }

    //     // Mendapatkan daftar IRS yang sudah diisi
    //     $irsSudahDiisi = IRS::where('nim', $nim)->pluck('semester_aktif');

    //     return view('irs-create', [
    //         'irs' => $irs,
    //         'irsSudahDiisi' => $irsSudahDiisi,
    //     ]);
    // }

    // public function store(Request $request)
    // {
    //     // Validasi input sesuai kebutuhan

    //     $nim = $request->irs;
    //     $irs = IRS::where('nim', $nim)->first();
        
    //     if (!$irs) {
    //         return redirect()->route('irs.create')->with('error', 'Mahasiswa tidak ditemukan.');
    //     }

    //     $irs = new IRS();
    //     $irs->semester_aktif = $request->input('semester_aktif');
    //     $irs->scanIRS = $request->input('scanIRS');
    //     $irs->jumlah_sks = $request->input('jumlah_sks');
    //     $irs->status = 'Pending';
    //     $irs->nim = $nim;

    //     // Anda perlu mendapatkan NIP dari data mahasiswa, Anda dapat melakukannya seperti ini
    //     $mahasiswa = Mahasiswa::where('nim', $nim)->first();
    //     if ($mahasiswa) {
    //         $irs->nip = $mahasiswa->nip;
    //     } else {
    //         return redirect()->route('irs.create')->with('error', 'NIP tidak ditemukan.');
    //     }

    //     $irs->save();

    //     return redirect()->route('irs.create')->with('success', 'IRS berhasil ditambahkan.');
    // }

    private function hitungSemesterSaatIni()
    {
        $bulanSekarang = date('m'); // Mengambil bulan saat ini (format 'm' adalah format angka bulan)
        $tahunAngkatan = // Ambil tahun angkatan dari data mahasiswa (misalnya, $mahasiswa->angkatan);

        // Menghitung tahun dan semester saat ini
        $tahunSekarang = date('Y'); // Mengambil tahun saat ini
        $selisihTahun = $tahunSekarang - $tahunAngkatan;

        if ($bulanSekarang >= 1 && $bulanSekarang <= 7) {
            // Semester ganjil (Januari - Juli)
            return ($selisihTahun * 2) + 1;
        } else {
            // Semester genap (Agustus - Desember)
            return $selisihTahun * 2;
        }
    }

    // Tambahkan fungsi pengiriman IRS ke dosen wali di sini
}

