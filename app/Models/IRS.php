<?php

namespace App\Models;

use App\Enums\KhsStatusKonfirmasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IRS extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status_konfirmasi' => KhsStatusKonfirmasi::class,
    ];

    public function mahasiswa()
    {
        // return $this->belongsTo(Mahasiswa::class, 'irs_id');
        return $this->belongsTo(Mahasiswa::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
