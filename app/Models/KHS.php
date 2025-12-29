<?php

namespace App\Models;

use App\Enums\KhsStatusKonfirmasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [

        'status_konfirmasi',

    ];
    // Casts
    protected $casts = [
        'status_konfirmasi' => KhsStatusKonfirmasi::class,
    ];

    public function scopeBelumDikonfirmasi($query)
    {
        return $query->where('status_konfirmasi', KhsStatusKonfirmasi::Belum_Dikonfirmasi);
    }

    public function scopeMilikDosen($query, $kode_wali)
    {
        return $query->whereHas('mahasiswa', function ($q) use ($kode_wali) {
            $q->where('dosen_kode_wali', $kode_wali);
        });
    }
    // Accessor

    // Relasi
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
