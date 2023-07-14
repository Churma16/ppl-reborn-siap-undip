<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    
    use HasFactory;
    protected $guarded = ['id'];

    // Accessor


    // Relasi
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
