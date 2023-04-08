<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $primaryKey = 'nim';

    protected $fillable = [];


    public function getMahasiswaPklCountAttribute()
    {
        return $this->pkl()->where('status_lulus', 'belum lulus')->count();
    }
    

    // Relasi
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function irs()
    {
        return $this->hasMany(Irs::class);
    }

    public function pkl()
    {
        return $this->hasOne(Pkl::class);
    }

    public function skripsi()
    {
        return $this->hasOne(Pkl::class);
    }
}
