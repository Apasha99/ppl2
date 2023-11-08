<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Exists;

class PKL extends Model
{
    use HasFactory;

    protected $table = 'pkl';

    protected $fillable = ['semester_aktif', 'nilai','statusPKL','scanPKL', 'status'];

    public static function rules($nim)
    {
        return [
            'semester_aktif' => [
                'required',
                'integer',
                'between:6,14',
            ],
            'scanPKL' => [  // Changed 'scanIRS' to 'scan_irs'
                'nullable',
                'file',
                'mimes:pdf',
            ],
            'nim' => [
                'required',
                'exists:mahasiswa,nim',
                new Exists('mahasiswa', 'nim', function ($query) use ($nim) {
                    $query->where('nim', $nim);
                }),
            ]
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


