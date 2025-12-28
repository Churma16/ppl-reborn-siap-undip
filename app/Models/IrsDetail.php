<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrsDetail extends Model
{
    use HasFactory;

    protected $table = 'irs_details';

    // Detail ini milik satu IRS
    public function irs()
    {
        return $this->belongsTo(Irs::class, 'irs_id');
    }

    // Detail ini merujuk ke satu Mata Kuliah
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }
}
