<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $primaryKey = 'nim';

    protected $fillable = [];

    // Accessor
    public function getJumlahMahasiswaAttribute()
    {
        return $this->count();
    }

    public function getJumlahSksAttribute()
    {
        return $this->irs()->sum('jumlah_sks');
    }

    public function getSemesterAktifAttribute()
    {
        return $this->irs()->max('semester_aktif');
    }

    public function getIpKumulatifAttribute()
    {
        $max_semester = $this->khs()->max('semester');

        $ip_kumulatif = $this->khs()
            ->where('semester', $max_semester)
            ->value('ip_kumulatif');

        return $ip_kumulatif;
    }


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

    public function khs()
    {
        return $this->hasMany(KHS::class);
    }
}
