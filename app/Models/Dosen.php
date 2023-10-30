<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Dosen extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'dosen_wali';
    protected $fillable = [
        'username',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}

