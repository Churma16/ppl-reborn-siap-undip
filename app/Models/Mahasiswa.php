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
    /**
     * Accessor untuk mengambil jumlah total mahasiswa.
     *
     * @return int
     */
    public function getJumlahMahasiswaAttribute()
    {
        return $this->count();
    }

    /**
     * Accessor untuk mengambil jumlah total SKS yang diambil oleh mahasiswa.
     *
     * @return int
     */
    public function getJumlahSksAttribute()
    {
        return $this->irs()->sum('jumlah_sks');
    }

    /**
     * Accessor untuk mengambil semester aktif terakhir dari mahasiswa.
     *
     * @return string
     */
    public function getSemesterAktifAttribute()
    {
        return $this->irs()->max('semester_aktif');
    }

    /**
     * Accessor untuk mengambil IP kumulatif terakhir dari mahasiswa.
     *
     * @return float
     */
    public function getIpKumulatifAttribute()
    {
        $max_semester = $this->khs()->max('semester');

        $ip_kumulatif = $this->khs()
            ->where('semester', $max_semester)
            ->value('ip_kumulatif');

        return $ip_kumulatif;
    }

    /**
     * Accessor untuk mengambil jumlah mahasiswa yang telah mengambil PKL dan yang belum mengambil PKL.
     *
     * @return array
     */
    public function getJumlahStatusPklAttribute()
    {
        $sudah_ambil = Mahasiswa::has('pkl')->count();
        $belum_ambil = Mahasiswa::doesntHave('pkl')->count();

        return [
            'sudah_ambil' => $sudah_ambil,
            'belum_ambil' => $belum_ambil,
        ];
    }

    /**
     * Accessor untuk mengambil jumlah mahasiswa yang telah mengambil skripsi dan yang belum mengambil skripsi.
     *
     * @return array
     */
    public function getJumlahStatusSkripsiAttribute()
    {
        $sudah_ambil = Mahasiswa::has('skripsi')->count();
        $belum_ambil = Mahasiswa::doesntHave('skripsi')->count();

        return [
            'sudah_ambil' => $sudah_ambil,
            'belum_ambil' => $belum_ambil,
        ];
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
        return $this->hasOne(Skripsi::class);
    }

    public function khs()
    {
        return $this->hasMany(KHS::class);
    }
}
