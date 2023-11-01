<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Exists;

class KHS extends Model
{
    use HasFactory;

    protected $table = 'khs';

    protected $fillable = ['semester_aktif', 'jumlah_sks','jumlah_sks_kumulatif', 'ip_semester','ip_kumulatif','scanKHS', 'status'];

    public static function rules($nim)
    {
        return [
            'ip_semester'=>['required'],
            'ip_semester'=>['required'],
            'semester_aktif' => [
                'required',
                'integer',
                'between:1,14',
            ],
            'scanKHS' => [  // Changed 'scanIRS' to 'scan_irs'
                'required',
                'file',
                'mimes:pdf',
            ],
            'jumlah_sks' => [
                'required',
                'integer','min:18',
                'max:24',
            ],
            'jumlah_sks_kumulatif' => [
                'required',
                'integer','min:18',
                'max:144',
            ],
            'nim' => [
                'required',
                'exists:mahasiswa,nim',
                new Exists('mahasiswa', 'nim', function ($query) use ($nim) {
                    $query->where('nim', $nim);
                }),
            ],
            'nip' => [
                'required',
                'exists:mahasiswa,nip',
                new Exists('mahasiswa', 'nip', function ($query) use ($nim) {
                    $query->where('nim', $nim);
                }),
            ],
        ];
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function dosenWali()
    {
        return $this->belongsTo(Dosen::class, 'dosen_wali', 'nip');
    }

}


