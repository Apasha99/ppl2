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

    protected $fillable = [
        'semester_aktif',
        'scanIRS',
        'jumlah_sks',
        'nim',
        'nip',
    ];

    public static function rules($semester, $nim)
    {
        return [
            'semester_aktif' => [
                'required',
                'integer',
                'between:1,14',
            ],
            'scanIRS' => [
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
                'exists:dosen_wali,nip',
            ],
        ];
    }
}
