<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class, 'dosen_nip');
    }
}
