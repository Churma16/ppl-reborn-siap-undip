<?php

namespace App\Models;

use App\Enums\SemesterStatusAktif;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => SemesterStatusAktif::class,
    ];

    // Relasi
    public function irs()
    {
        return $this->hasMany(Irs::class, 'semester_id', 'id');
    }
    public function khs()
    {
        return $this->hasMany(KHS::class, 'semester_id', 'id');
    }
    public function skripsi()
    {
        return $this->hasMany(Skripsi::class, 'semester_id', 'id');
    }
    public function pkl()
    {
        return $this->hasMany(PKL::class, 'semester_id', 'id');
    }

    public function scopeSemesterAktif($query)
    {
        return $query->where('is_active', SemesterStatusAktif::AKTIF);
    }
}
