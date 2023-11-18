<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class DepartemenController extends Controller
{
    public function index_list()
    {
        return view('listMahasiswa');
    }

    public function listPKL(){
        
        $pkl = Mahasiswa::join('pkl','pkl.nim','=','mahasiswa.nim')
                ->join('dosen_wali','dosen_wali.nip','=','mahasiswa.nip')
                ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','pkl.semester_aktif','pkl.scanPKL','pkl.nilai','pkl.status','pkl.statusPKL','dosen_wali.nama as dosen_nama')
                ->get();
        return view('listPKLDepartemen', ['pkl'=>$pkl]);
    }

    public function listSkripsi(){
        $skripsi = Mahasiswa::join('skripsi','skripsi.nim','=','mahasiswa.nim')
                ->join('dosen_wali','dosen_wali.nip','=','mahasiswa.nip')
                ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','skripsi.semester_aktif','skripsi.scanSkripsi','skripsi.nilai','skripsi.status','skripsi.statusSkripsi','dosen_wali.nama as dosen_nama')
                ->get();
        return view('listSkripsiDepartemen', ['skripsi'=>$skripsi]);
    }

    public function RekapPKL() {
        $maxAngkatan = Mahasiswa::max('angkatan');

        // Initialize an empty array to store the data
        $data = [];

        // Loop from the maximum 'angkatan' to 6 less than the maximum
        for ($i = $maxAngkatan; $i >= $maxAngkatan - 6; $i--) {
            // Get the count of students who passed and did not pass for the current 'angkatan'
            $luluspkl = Mahasiswa::Join('pkl as p', 'm.nim', '=', 'p.nim')
                                ->where('m.angkatan', $i)
                                ->select('m.angkatan',
                                    DB::raw('COALESCE(SUM(CASE WHEN p.status = "verified" THEN 1 ELSE 0 END), 0) as lulus_count'), 
                                )
                                ->groupBy('m.angkatan')
                                ->get();
            $tdkluluspkl = Mahasiswa::Join('pkl as p', 'm.nim', '=', 'p.nim')
                                ->where('m.angkatan', $i)
                                ->select('m.angkatan',
                                    DB::raw('COALESCE(SUM(CASE WHEN p.nim IS NULL OR p.status != "verified" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
                                ->groupBy('m.angkatan')
                                ->get();

            // Add the data to the array
            $data[] = (object) [
                'angkatan' => $i,
                'luluspkl' => $luluspkl,
                'tdkluluspkl' => $tdkluluspkl
            ];
        }

        $mahasiswas = DB::table('mahasiswa as m')
            ->leftJoin('pkl as p', 'm.nim', '=', 'p.nim')
            ->select('m.angkatan',
                DB::raw('COALESCE(SUM(CASE WHEN p.status = "verified" THEN 1 ELSE 0 END), 0) as lulus_count'), 
                DB::raw('COALESCE(SUM(CASE WHEN p.nim IS NULL OR p.status != "verified" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
            ->groupBy('m.angkatan')
            ->get();
    
        // Tambahkan penanganan jika $mahasiswas kosong
        if ($mahasiswas->isEmpty()) {
            // Atau tindakan yang sesuai dengan kebutuhan Anda, misalnya, 
            // memberikan nilai default atau pesan yang sesuai.
            return view('RekapPKLDepartemen', ['mahasiswas' => null]);
        }
    
        return view('RekapPKLDepartemen', ['mahasiswas' => $mahasiswas, 'data'=> $data]);
    }
    
    

    public function PreviewPKL(){
    
        $mahasiswas = DB::table('mahasiswa as m')
                ->leftJoin('pkl as p', 'm.nim', '=', 'p.nim')
                ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN p.statusPKL = "lulus" THEN 1 ELSE 0 END), 0) as lulus_count'), 
                                        DB::raw('COALESCE(SUM(CASE WHEN m.cekPKL = "0" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
                ->groupBy('m.angkatan')
                ->get();
        return view('DownloadRekapPKLDepartemen', ['mahasiswas' => $mahasiswas]);
    }

    public function RekapPDFPKL() {
        $mahasiswas = DB::table('mahasiswa as m')
                ->leftJoin('pkl as p', 'm.nim', '=', 'p.nim')
                ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN p.statusPKL = "lulus" THEN 1 ELSE 0 END), 0) as lulus_count'), 
                                        DB::raw('COALESCE(SUM(CASE WHEN m.cekPKL = "0" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
                ->groupBy('m.angkatan')
                ->get();

        // Mengambil HTML dari view
        $html = View::make('DownloadRekapPKLDepartemen', ['mahasiswas' => $mahasiswas])->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html);

        // (Opsional) Set konfigurasi PDF
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (generate)
        $pdf->render();

        // Mengembalikan respons dengan file PDF
        return $pdf->stream('rekap_pkl.pdf');
    }
    
    public function RekapSkripsi(){
    
        $mahasiswasSkripsi = DB::table('mahasiswa as m')
                ->leftJoin('skripsi as s', 'm.nim', '=', 's.nim')
                ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN s.status = "verified" THEN 1 ELSE 0 END), 0) as lulus_count'), 
                                        DB::raw('COALESCE(SUM(CASE WHEN s.nim IS NULL OR s.status != "verified" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
                ->groupBy('m.angkatan')
                ->get();
    
        return view('RekapSkripsiDepartemen', ['mahasiswasSkripsi' => $mahasiswasSkripsi]);
    }

    public function PreviewSkripsi(){
    
        $mahasiswasSkripsi = DB::table('mahasiswa as m')
                ->leftJoin('skripsi as s', 'm.nim', '=', 's.nim')
                ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN s.status = "verified" THEN 1 ELSE 0 END), 0) as lulus_count'), 
                                        DB::raw('COALESCE(SUM(CASE WHEN s.nim IS NULL OR s.status != "verified" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
                ->groupBy('m.angkatan')
                ->get();
    
        return view('DownloadRekapSkripsiDepartemen', ['mahasiswasSkripsi' => $mahasiswasSkripsi]);
    }

    public function RekapPDFSkripsi() {
        $mahasiswasSkripsi = DB::table('mahasiswa as m')
                ->leftJoin('skripsi as s', 'm.nim', '=', 's.nim')
                ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN s.status = "verified" THEN 1 ELSE 0 END), 0) as lulus_count'), 
                                        DB::raw('COALESCE(SUM(CASE WHEN s.nim IS NULL OR s.status != "verified" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
                ->groupBy('m.angkatan')
                ->get();

        // Mengambil HTML dari view
        $html = View::make('DownloadRekapSkripsiDepartemen', ['mahasiswasSkripsi' => $mahasiswasSkripsi])->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html);

        // (Opsional) Set konfigurasi PDF
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (generate)
        $pdf->render();

        // Mengembalikan respons dengan file PDF
        return $pdf->stream('rekap_skripsi.pdf');
    }
}
