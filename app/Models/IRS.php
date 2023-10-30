<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IRS extends Model
{
    use HasFactory;
    protected $table = 'irs';
    protected $fillable = [
        'semester_aktif',
        'scanIRS',
        'jumlah_sks',
    ];
}
