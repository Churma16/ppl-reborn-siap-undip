<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\SkripsiStatusKonfirmasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skripsi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'status_konfirmasi' => SkripsiStatusKonfirmasi::class,
    ];
    /**
     * The function `getJumlahKelulusanAttribute` counts the number of PKL records with the status "lulus"
     * and "belum lulus" and returns the counts as an associative array.
     *
     * @return an associative array with two keys: 'lulus' and 'belum_lulus'. The value of 'lulus' is the
     * count of PKL records where the 'status_skripsi' is 'lulus', and the value of 'belum_lulus' is the
     * count of PKL records where the 'status_skripsi' is 'belum lulus'.
     */
    public function getJumlahKelulusanAttribute()
    {
        // Count the number of PKL records where status_lulus is "lulus"
        $lulus_count = $this->whereIn('status_skripsi', ['lulus'])->count();

        // Count the number of PKL records where status_lulus is "belum lulus"
        $belum_lulus_count = $this->whereIn('status_skripsi', ['belum lulus'])->count();

        // Return the counts as an associative array
        return ['lulus' => $lulus_count, 'belum_lulus' => $belum_lulus_count];
    }

    /**
     * The function "getTanggalMulaiFormattedAttribute" formats a given date in the "d M Y" format.
     *
     * @return The formatted date in the format "d M Y" is being returned.
     */
    public function getTanggalMulaiFormattedAttribute()
    {
        $date = Carbon::parse($this->tanggal_mulai);
        return $date->format('d M Y');
    }

    /**
     * The function "getTanggalSelesaiFormattedAttribute" formats a given date in the "d M Y" format.
     *
     * @return The formatted date in the format "d M Y" is being returned.
     */
    public function getTanggalSelesaiFormattedAttribute()
    {
        $date = Carbon::parse($this->tanggal_sidang);
        return $date->format('d M Y');
    }
    public function getStatusColorAttribute()
    {
        if (is_null($this->status_lulus)) {
            return 'secondary';
        }

        return $this->status_lulus == 'Lulus' ? 'success' : 'warning';
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
