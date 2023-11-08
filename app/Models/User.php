<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'foto',
        'role_id',
        'cekProfil'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getImageURL(){
        if($this->foto){
            return url("storage/" . $this->foto);
        }
        return "https://api.dicebear.com/6.x/fun-emoji/svg?seed=($this=>name)";
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'iduser', 'id');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'iduser', 'id');
    }

    public function operator()
    {
        return $this->hasOne(Operator::class, 'iduser', 'id');
    }

    public function departemen()
    {
        return $this->hasOne(Departemen::class, 'iduser', 'id');
    }

}
