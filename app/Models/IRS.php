<?php

namespace App\Models;

use App\Enums\KhsStatusKonfirmasi;
use App\Enums\SemesterStatusAktif;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IRS extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status_konfirmasi' => KhsStatusKonfirmasi::class,
    ];

    public function ScopeBelumDikonfirmasi($query)
    {
        return $query->where('status_konfirmasi', KhsStatusKonfirmasi::Belum_Dikonfirmasi);
    }

    public function scopeMilikDosen($query, $kode_dosen)
    {
        return $query->whereHas('mahasiswa', function ($q) use ($kode_dosen) {
            $q->where('dosen_kode_wali', $kode_dosen);
        });
    }

    public function mahasiswa()
    {
        // return $this->belongsTo(Mahasiswa::class, 'irs_id');
        return $this->belongsTo(Mahasiswa::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function details()
    {
        return $this->hasMany(IrsDetail::class, 'irs_id');
    }
}
