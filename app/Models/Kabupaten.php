<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;
    protected $fillable = [];
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_kode_provinsi');
    }

    public function mahasiswa(){
        return $this->hasMany(Mahasiswa::class,'Kabupaten_kode_Kabupaten', 'kode_Kabupaten');
        // return $this->belongsTo(Mahasiswa::class);
    }
}
