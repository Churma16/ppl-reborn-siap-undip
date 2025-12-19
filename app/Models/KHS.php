<?php

namespace App\Models;

use App\Enums\KhsStatusKonfirmasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{

    use HasFactory;
    protected $guarded = ['id'];

    // Casts
    protected $casts =[
        'status_konfirmasi' => KhsStatusKonfirmasi::class
    ];
    
    // Accessor


    // Relasi
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
