<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;
use App\Models\User;


class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [];


    // Accessor
    public function getJumlahDosenAttribute()
    {
        return $this->count();
    }

    // Relasi
    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'dosen_nip');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
    

}
