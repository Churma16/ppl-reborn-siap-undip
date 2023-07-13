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

    public function getMahasiswaBimbinganAttribute()
    {
        return Mahasiswa::where('dosen_kode_wali', $this->kode_wali)->pluck('nim');
    }

    // Relasi
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'dosen_kode_wali', 'kode_wali');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
