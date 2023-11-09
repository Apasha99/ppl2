<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class DepartemenController extends Controller
{
    // public function index_list()
    // {
    //     return view('listMahasiswa');
    // }

    // public function index($angkatan, $status){
    //     $mahasiswas = Mahasiswa::join('pkl', 'pkl.nim', '=', 'mahasiswa.nim')
    //                             ->where('mahasiswa.angkatan', $angkatan)
    //                             ->where('pkl.statusPKL', $status)
    //                             ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai')
    //                             ->get();

    //     return view('listPKLDepartemen', ['mahasiswas' => $mahasiswas]);
    // }

    public function listPKL(Request $request){
        
        $pkl = Mahasiswa::join('pkl','pkl.nim','=','mahasiswa.nim')
                ->join('dosen_wali','dosen_wali.nip','=','mahasiswa.nip')
                ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','pkl.semester_aktif','pkl.scanPKL','pkl.nilai','pkl.status','pkl.statusPKL','dosen_wali.nama as dosen_nama')
                ->get();
        return view('listPKLDepartemen', ['pkl'=>$pkl]);
    }

    public function listSkripsi(Request $request){
        $skripsi = Mahasiswa::join('skripsi','skripsi.nim','=','mahasiswa.nim')
                ->join('dosen_wali','dosen_wali.nip','=','mahasiswa.nip')
                ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','skripsi.semester_aktif','skripsi.scanSkripsi','skripsi.nilai','skripsi.status','skripsi.statusSkripsi','dosen_wali.nama as dosen_nama')
                ->get();
        return view('listSkripsiDepartemen', ['skripsi'=>$skripsi]);
    }

    public function RekapPKL(Request $request){
    
        $result = Mahasiswa::join('pkl', 'pkl.nim', '=', 'mahasiswa.nim')
                ->select('mahasiswa.angkatan')
                ->selectRaw('SUM(CASE WHEN pkl.statusPKL = "lulus" THEN 1 ELSE 0 END) as luluspkl')
                ->selectRaw('SUM(CASE WHEN pkl.statusPKL = "tidak lulus" THEN 1 ELSE 0 END) as tdkluluspkl')
                ->groupBy('mahasiswa.angkatan')
                ->get();
    
        return view('RekapPKLDepartemen', ['data' => $result]);
    }

    public function RekapSkripsi(Request $request){
    
        $result = Mahasiswa::join('skripsi', 'skripsi.nim', '=', 'mahasiswa.nim')
                ->select('mahasiswa.angkatan')
                ->selectRaw('SUM(CASE WHEN skripsi.statusSkripsi = "lulus" THEN 1 ELSE 0 END) as lulusskripsi')
                ->selectRaw('SUM(CASE WHEN skripsi.statusSkripsi = "tidak lulus" THEN 1 ELSE 0 END) as tdklulusskripsi')
                ->groupBy('mahasiswa.angkatan')
                ->get();
    
        return view('RekapSkripsiDepartemen', ['data' => $result]);
    }


}
