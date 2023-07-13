<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;
    protected $fillable = [];

    public function kabupatens()
    {
        return $this->hasMany(Kabupaten::class, 'provinsi_kode_provinsi');
    }

    public function mahasiswa(){
        return $this->hasMany(Mahasiswa::class,'provinsi_kode_provinsi', 'kode_provinsi');
        // return $this->belongsTo(Mahasiswa::class);
    }
}
