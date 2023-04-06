<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_nip');
    }

    public function irs()
    {
        return $this->hasMany(Irs::class, 'irs_id');
    }
}
