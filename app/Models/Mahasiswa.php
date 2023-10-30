<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'mahasiswa';
    protected $fillable = [
        'nama',
        'nim',
        'angkatan',
        'status',
        'nip',
        'alamat',
        'kabkota',
        'provinsi',
        'username',
        'noHandphone'
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'iduser', 'id');
    // }

    // public function dosen_wali()
    // {
    //     return $this->belongsTo(Dosen::class, 'nip', 'nip');
    // }
}

