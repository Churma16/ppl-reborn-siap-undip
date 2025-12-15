<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PKL extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * This function counts the number of PKL records with the status "lulus" and "belum lulus" and returns
     * the counts as an associative array.
     * 
     * @return an associative array with two keys: 'lulus' and 'belum_lulus'. The value of 'lulus' is the
     * count of PKL records where the status_lulus is "lulus", and the value of 'belum_lulus' is the count
     * of PKL records where the status_lulus is "belum lulus".
     */
    public function getJumlahKelulusanAttribute()
    {
        // Count the number of PKL records where status_lulus is "lulus"
        $lulus_count = $this->whereIn('status_lulus', ['lulus'])->count();

        // Count the number of PKL records where status_lulus is "belum lulus"
        $belum_lulus_count = $this->whereIn('status_lulus', ['belum lulus'])->count();

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
        $date = Carbon::parse($this->tanggal_selesai);
        return $date->format('d M Y');
    }

    /**
     * The function "getTanggalDiunggahAttribute" returns the formatted date of the "created_at" attribute
     * in the format "dd M Y".
     * 
     * @return the formatted date of the "created_at" attribute in the format "d M Y" (e.g. 01 Jan 2022).
     */
    public function getTanggalDiunggahAtrribute()
    {
        $date = Carbon::parse($this->created_at);
        return $date->format('d M Y');
    }
}
