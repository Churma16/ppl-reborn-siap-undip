<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_kode_provinsi');
    }

}
