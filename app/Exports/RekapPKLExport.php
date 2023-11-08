<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use PDF;
use App\Models\Dosen;

class RekapPKLExport implements FromCollection
{
    protected $nip;

    public function __construct($nip)
    {
        $this->nip = $nip;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                    ->join('mahasiswa', 'mahasiswa.nip', '=', 'dosen_wali.nip')
                    ->join('pkl', 'pkl.nim', '=', 'mahasiswa.nim')
                    ->where('dosen_wali.nip', $this->nip)
                    ->where('pkl.nip', $this->nip) 
                    ->select('mahasiswa.angkatan')
                    ->selectRaw('SUM(CASE WHEN pkl.statusPKL = "lulus" THEN 1 ELSE 0 END) as luluspkl')
                    ->selectRaw('SUM(CASE WHEN pkl.statusPKL = "tidak lulus" THEN 1 ELSE 0 END) as tdkluluspkl')
                    ->groupBy('mahasiswa.angkatan')
                    ->get(); // Ambil data rekapitulasi

        return $data;
    }

    public function exportToPDF() {
        $data = $this->collection();
                
        //$pdf = PDF::loadView('rekap-pdf', compact('data'));
     
        //return $pdf->download('rekap-pkl.pdf');
    }
}
