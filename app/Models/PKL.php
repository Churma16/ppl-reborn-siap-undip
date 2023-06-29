<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PKL extends Model
{
    use HasFactory;
    protected $fillable = [];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function getJumlahKelulusanAttribute()
    {
        // Count the number of PKL records where status_lulus is "lulus"
        $lulus_count = $this->whereIn('status_lulus', ['lulus'])->count();

        // Count the number of PKL records where status_lulus is "belum lulus"
        $belum_lulus_count = $this->whereIn('status_lulus', ['belum lulus'])->count();

        // Return the counts as an associative array
        return ['lulus' => $lulus_count, 'belum_lulus' => $belum_lulus_count];
    }

    public function getTanggalMulaiFormattedAttribute()
    {
        $date = Carbon::parse($this->tanggal_mulai);
        return $date->format('d-m-y');
    }

    public function getTanggalSelesaiFormattedAttribute()
    {
        $date = Carbon::parse($this->tanggal_selesai);
        return $date->format('d-m-y');
    }
}
