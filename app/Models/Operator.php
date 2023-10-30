<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Operator extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;
    protected $table = 'operator';
    protected $primaryKey = 'nip';
    protected $fillable = [
        'nama',
        'username',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'username', 'username');
    // }
}
