<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IRS extends Model
{
    use HasFactory;
    protected $fillable = [];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'irs_id');
    }
}
