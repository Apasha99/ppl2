<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rules\Exists;

class IRS extends Model
{
    use HasFactory;

    protected $table = 'irs';

    protected $fillable = ['semester_aktif', 'jumlah_sks', 'scanIRS', 'status'];

    public static function rules($nim)
    {
        return [
            'semester_aktif' => [
                'required',
                'integer',
                'between:1,14',
            ],
            'scanIRS' => [  // Changed 'scanIRS' to 'scan_irs'
                'required',
                'file',
                'mimes:pdf',
            ],
            'jumlah_sks' => [
                'required',
                'integer',
                'max:24',
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

    public function pkl()
    {
        return $this->belongsTo(PKL::class, 'nim', 'nim');
    }

}


