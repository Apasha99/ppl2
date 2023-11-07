<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class MahasiswaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Mahasiswa::join('generate_akun','mahasiswa.nim','=','generate_akun.nim')
                        ->join('dosen_wali','mahasiswa.nip','=','dosen_wali.nip')
                        ->select('mahasiswa.nama as Nama',"generate_akun.nim as NIM ",'mahasiswa.angkatan','mahasiswa.status','mahasiswa.nip','dosen_wali.nama as Nama Dosen Wali',"generate_akun.username","generate_akun.password")->get();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ['Nama', 'NIM', 'Angkatan', 'Status', 'NIP', 'Nama Dosen Wali', 'Username', 'Password'];
    }

}
