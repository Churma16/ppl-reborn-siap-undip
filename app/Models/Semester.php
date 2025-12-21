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
}
