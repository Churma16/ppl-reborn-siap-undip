<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [];


    // Accessor
    public function getJumlahDosenAttribute()
    {
        return $this->count();
    }
    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'dosen_nip');
    }
}
