<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class ListController extends Controller
{
    public function index(Request $request, $angkatan, $status) {
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                                    $join->on('mahasiswa.nim', '=', 'pkl.nim')
                                        ->where('pkl.status', '=', 'verified');
                                })
                                ->where('mahasiswa.angkatan', $angkatan)
                                ->where(function ($query) use ($status) {
                                    $query->where('pkl.status', $status);
                                })
                                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.statusPKL', 'pkl.status')
                                ->get();
    
        return view('listMahasiswa', ['mahasiswas' => $mahasiswas->isEmpty() ? [] : $mahasiswas]);
    }    

    public function index2(Request $request, $angkatan, $status) {
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                $join->on('mahasiswa.nim', '=', 'pkl.nim')
                    ->where('pkl.status', '=', 'verified');
                })
                ->where('mahasiswa.angkatan', $angkatan)
                ->where(function ($query) use ($status) {
                    $query->whereNull('pkl.nim')
                        ->orWhere(function ($query) use ($status) {
                            $query->where('pkl.status', '=', $status);
                        });
                })
                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.status')
                ->get();
    
        return view('listMahasiswa2', ['mahasiswas' => $mahasiswas]);
    }    

    public function skripsi(Request $request, $angkatan, $status){
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
            $join->on('mahasiswa.nim', '=', 'skripsi.nim')
                ->where('skripsi.status', '=', 'verified');
        })
        ->where('mahasiswa.angkatan', $angkatan)
        ->where(function ($query) use ($status) {
            $query->where('skripsi.status', $status);
        })
        ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status')
        ->get();
    
        return view('listMahasiswaSkripsi', ['mahasiswas' => $mahasiswas]);
    }    

    public function skripsi2(Request $request, $angkatan, $status){
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
                                $join->on('mahasiswa.nim', '=', 'skripsi.nim')
                                    ->where('skripsi.status', '=', 'verified');
                                })
                                ->where('mahasiswa.angkatan', $angkatan)
                                ->where(function ($query) use ($status) {
                                    $query->whereNull('skripsi.nim')
                                        ->orWhere(function ($query) use ($status) {
                                            $query->where('skripsi.status', '=', $status);
                                        });
                                })
                                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status')
                                ->get();

        return view('listMahasiswaSkripsi2', ['mahasiswas' => $mahasiswas]);
    }
    
    public function PreviewListPKLLulus(Request $request, $angkatan, $status) {
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                                $join->on('mahasiswa.nim', '=', 'pkl.nim')
                                    ->where('pkl.status', '=', 'verified');
                            })
                            ->where('mahasiswa.angkatan', $angkatan)
                            ->where(function ($query) use ($status) {
                                $query->where('pkl.status', $status);
                            })
                            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.statusPKL', 'pkl.status')
                            ->get();
    
        if ($mahasiswas->isEmpty()) {
            // Lakukan penanganan jika $mahasiswas kosong, seperti menampilkan pesan atau mengarahkan ke halaman lain
            return redirect()->back()->with('error', 'Tidak ada data yang tersedia.');
        }
    
        return view('DownloadListPKLDepartemenLulus', ['mahasiswas' => $mahasiswas]);
    }
    
    public function ListPDFPKLLulus(Request $request, $angkatan, $status) {
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                                $join->on('mahasiswa.nim', '=', 'pkl.nim')
                                    ->where('pkl.status', '=', 'verified');
                            })
                            ->where('mahasiswa.angkatan', $angkatan)
                            ->where(function ($query) use ($status) {
                                $query->where('pkl.status', $status);
                            })
                            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.statusPKL', 'pkl.status')
                            ->get();
    
        if ($mahasiswas->isEmpty()) {
            // Lakukan penanganan jika $mahasiswas kosong, seperti menampilkan pesan atau mengembalikan response kosong
            return response()->json(['error' => 'Tidak ada data yang tersedia.'], 404);
        }
    
        // Mengambil HTML dari view
        $html = View::make('DownloadListPKLDepartemenLulus', ['mahasiswas' => $mahasiswas])->render();
    
        $pdf = new Dompdf();
        $pdf->loadHtml($html);
    
        // (Opsional) Set konfigurasi PDF
        $pdf->setPaper('A4', 'portrait');
    
        // Render PDF (generate)
        $pdf->render();
    
        // Mengembalikan respons dengan file PDF
        return $pdf->stream('list_lulus_pkl.pdf');
    }
    

    public function PreviewListPKLBelum(Request $request, $angkatan, $status){
    
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                                $join->on('mahasiswa.nim', '=', 'pkl.nim')
                                    ->where('pkl.status', '=', 'verified');
                                })
                                ->where('mahasiswa.angkatan', $angkatan)
                                ->where(function ($query) use ($status) {
                                    $query->whereNull('pkl.nim')
                                        ->orWhere(function ($query) use ($status) {
                                            $query->where('pkl.status', '=', $status);
                                        });
                                })
                                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.status')
                                ->get();

        return view('DownloadListPKLDepartemenBelum', ['mahasiswas' => $mahasiswas]);
    }

    public function ListPDFPKLBelum(Request $request, $angkatan, $status) {
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                            $join->on('mahasiswa.nim', '=', 'pkl.nim')
                                ->where('pkl.status', '=', 'verified');
                            })
                            ->where('mahasiswa.angkatan', $angkatan)
                            ->where(function ($query) use ($status) {
                                $query->whereNull('pkl.nim')
                                    ->orWhere(function ($query) use ($status) {
                                        $query->where('pkl.status', '=', $status);
                                    });
                            })
                            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.status')
                            ->get();

        // Mengambil HTML dari view
        $html = View::make('DownloadListPKLDepartemenBelum', ['mahasiswas' => $mahasiswas])->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html);

        // (Opsional) Set konfigurasi PDF
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (generate)
        $pdf->render();

        // Mengembalikan respons dengan file PDF
        return $pdf->stream('list_belum_pkl.pdf');
    }

    public function PreviewListSkripsiLulus(Request $request, $angkatan, $status) {
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
                                $join->on('mahasiswa.nim', '=', 'pkl.nim')
                                    ->where('skripsi.status', '=', 'verified');
                            })
                            ->where('mahasiswa.angkatan', $angkatan)
                            ->where(function ($query) use ($status) {
                                $query->where('skripsi.status', $status);
                            })
                            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.statusSkripsi', 'skripsi.status')
                            ->get();
    
        if ($mahasiswas->isEmpty()) {
            // Lakukan penanganan jika $mahasiswas kosong, seperti menampilkan pesan atau mengarahkan ke halaman lain
            return redirect()->back()->with('error', 'Tidak ada data yang tersedia.');
        }
    
        return view('DownloadListSkripsiDepartemenLulus', ['mahasiswas' => $mahasiswas]);
    }
    
    public function ListPDFSkripsiLulus(Request $request, $angkatan, $status) {
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
                                $join->on('mahasiswa.nim', '=', 'skripsi.nim')
                                    ->where('skripsi.status', '=', 'verified');
                            })
                            ->where('mahasiswa.angkatan', $angkatan)
                            ->where(function ($query) use ($status) {
                                $query->where('skripsi.status', $status);
                            })
                            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.statusSkripsi', 'skripsi.status')
                            ->get();
    
        if ($mahasiswas->isEmpty()) {
            // Lakukan penanganan jika $mahasiswas kosong, seperti menampilkan pesan atau mengembalikan response kosong
            return response()->json(['error' => 'Tidak ada data yang tersedia.'], 404);
        }
    
        // Mengambil HTML dari view
        $html = View::make('DownloadListPKLDepartemenLulus', ['mahasiswas' => $mahasiswas])->render();
    
        $pdf = new Dompdf();
        $pdf->loadHtml($html);
    
        // (Opsional) Set konfigurasi PDF
        $pdf->setPaper('A4', 'portrait');
    
        // Render PDF (generate)
        $pdf->render();
    
        // Mengembalikan respons dengan file PDF
        return $pdf->stream('list_lulus_skripsi.pdf');
    }

    public function PreviewListSkripsiBelum(Request $request, $angkatan, $status){
    
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
                                $join->on('mahasiswa.nim', '=', 'skripsi.nim')
                                    ->where('skripsi.status', '=', 'verified');
                                })
                                ->where('mahasiswa.angkatan', $angkatan)
                                ->where(function ($query) use ($status) {
                                    $query->whereNull('skripsi.nim')
                                        ->orWhere(function ($query) use ($status) {
                                            $query->where('skripsi.status', '=', $status);
                                        });
                                })
                                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status')
                                ->get();

        return view('DownloadListSkripsiDepartemenBelum', ['mahasiswas' => $mahasiswas]);
    }

    public function ListPDFSkripsiBelum(Request $request, $angkatan, $status) {
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
                            $join->on('mahasiswa.nim', '=', 'skripsi.nim')
                                ->where('skripsi.status', '=', 'verified');
                            })
                            ->where('mahasiswa.angkatan', $angkatan)
                            ->where(function ($query) use ($status) {
                                $query->whereNull('skripsi.nim')
                                    ->orWhere(function ($query) use ($status) {
                                        $query->where('skripsi.status', '=', $status);
                                    });
                            })
                            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status')
                            ->get();

        // Mengambil HTML dari view
        $html = View::make('DownloadListSkripsiDepartemenBelum', ['mahasiswas' => $mahasiswas])->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html);

        // (Opsional) Set konfigurasi PDF
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (generate)
        $pdf->render();

        // Mengembalikan respons dengan file PDF
        return $pdf->stream('list_belum_skripsi.pdf');
    }
}