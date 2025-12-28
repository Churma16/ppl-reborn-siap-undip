<?php

namespace App\Models;

use App\Models\IRS;
use App\Enums\IrsStatusKonfirmasi;
use App\Enums\SemesterStatusAktif;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'nim';

    protected $guarded = ['id'];


    // Scope

    public function scopeMilikDosen($query, Dosen $dosen)
    {
        return $query->where('dosen_kode_wali', $dosen->kode_wali);
    }

    public function scopeAktifSmtIni($q)
    {
        return $q->whereHas('irs', function ($q) {
            $q->whereHas('semester', fn($s) => $s->where('is_active', '1'))
                ->where('status_konfirmasi', 'Dikonfirmasi');
        });
    }

    public function scopeTidakAktifSmtIni($q)
    {
        return $q->whereDoesntHave('irs', function ($q) {
            $q->whereHas('semester', fn($s) => $s->where('is_active', '1'));
        })->belumLulus();
    }

    public function scopeTidakAktifDiSmt($q, $idSemester)
    {
        return $q->whereHas('irs', function ($q) use ($idSemester) {
            $q->where('semester_id', $idSemester);
        })->belumLulus();
    }

    public function scopeSudahLulus($q)
    {
        return $q->whereHas('khs', function ($q) {
            $q->where('status_mahasiswa', 'Lulus');
        });
    }

    public function scopeBelumLulus($q)
    {
        return $q->whereDoesntHave('khs', function ($q) {
            $q->where('status_mahasiswa', 'Lulus');
        });
    }

    public function scopePklAktifSmtIni($q)
    {
        return $q->whereHas('pkl', function ($q) {
            $q->where('status_lulus', 'Belum Lulus')
                ->whereHas('semester', fn($s) => $s->where('is_active', '1'));
        });
    }

    public function scopeAktifDiSmt($q, $idSemester)
    {
        return $q->whereHas(
            'irs',
            fn($q) => $q
                ->where('semester_id', $idSemester)
                ->where('status_konfirmasi', 'Dikonfirmasi')
        );
    }

    public function scopeBelumBimbinganSkripsi2Minggu($q)
    {
        return $q->whereHas(
            'skripsiTerakhir',
            fn($q) => $q
                ->where('status_skripsi', 'Belum Lulus')
                ->where(
                    fn($q) => $q
                        ->whereDate('created_at', '<', now()->subday(14))
                )
        );
    }

    // Accessor
    /**
     * Accessor untuk mengambil jumlah total mahasiswa.
     *
     * @return int
     */
    public function getJumlahMahasiswaAttribute()
    {
        return $this->count();
    }

    /**
     * Accessor untuk mengambil jumlah total SKS yang diambil oleh mahasiswa.
     *
     * @return int
     */
    public function getJumlahSksAttribute()
    {
        return $this->irs()->sum('jumlah_sks');
    }

    /**
     * Accessor untuk mengambil semester aktif terakhir dari mahasiswa.
     *
     * @return string
     */
    public function getSemesterAktifAttribute()
    {
        return $this->irs()->max('semester_aktif');
    }

    /**
     * Accessor untuk mengambil IP kumulatif terakhir dari mahasiswa.
     *
     * @return float
     */
    public function getIpKumulatifAttribute()
    {
        $max_semester = $this->khs()->max('semester');

        $ip_kumulatif = $this->khs()
            ->where('semester', $max_semester)
            ->value('ip_kumulatif');

        return $ip_kumulatif;
    }

    /**
     * Accessor untuk mengambil jumlah mahasiswa yang telah mengambil PKL dan yang belum mengambil PKL.
     *
     * @return array
     */
    public function getJumlahStatusPklAttribute()
    {
        $sudah_ambil = Mahasiswa::has('pkl')->count();
        $belum_ambil = Mahasiswa::doesntHave('pkl')->count();

        return [
            'sudah_ambil' => $sudah_ambil,
            'belum_ambil' => $belum_ambil,
        ];
    }

    /**
     * Accessor untuk mengambil jumlah mahasiswa yang telah mengambil skripsi dan yang belum mengambil skripsi.
     *
     * @return array
     */
    public function getJumlahStatusSkripsiAttribute()
    {
        $sudah_ambil = Mahasiswa::has('skripsi')->count();
        $belum_ambil = Mahasiswa::doesntHave('skripsi')->count();

        return [
            'sudah_ambil' => $sudah_ambil,
            'belum_ambil' => $belum_ambil,
        ];
    }

    public function irsAktif()
    {
        return $this->hasOne(IRS::class, 'mahasiswa_nim', 'nim')
            ->whereRelation('semester', 'is_active', SemesterStatusAktif::AKTIF->value)
            ->where('status_konfirmasi', IrsStatusKonfirmasi::Dikonfirmasi->value)
            ->latest('semester_aktif');
    }

    public function getStatusAkademikAttribute()
    {
        $irsTerakhir = $this->irsAktif;

        if (! $irsTerakhir || ! ($irsTerakhir->status_konfirmasi == 'Dikonfirmasi')) {
            return 'Tidak Aktif';
        }

        return  'Aktif';
    }

    public function getIrsTerendahAttribute()
    {
        return $this->irs()->min('jumlah_sks');
    }

    public function getStatusAktifAttribute()
    {
        return $this->khs()->where('semester', $this->khs()->max('semester'))->value('status_mahasiswa');
    }


    // Relasi
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_kode_wali', 'kode_wali');
    }

    public function irs()
    {
        return $this->hasMany(Irs::class);
    }

    public function pkl()
    {
        return $this->hasMany(Pkl::class);
    }

    public function skripsi()
    {
        return $this->hasMany(Skripsi::class);
    }

    public function khs()
    {
        return $this->hasMany(KHS::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_kode_provinsi', 'kode_provinsi');
        // return $this->hasOne(Provinsi::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_kode_kabupaten', 'kode_kabupaten');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nim', 'nip_nim');
    }

    public function khsTerakhir()
    {
        return $this->hasOne(KHS::class, 'mahasiswa_nim', 'nim')->latestOfMany('semester');
    }

    public function skripsiTerakhir()
    {
        return $this->hasOne(Skripsi::class, 'mahasiswa_nim', 'nim')->latestOfMany('progress_ke');
    }

    public function pklTerakhir()
    {
        return $this->hasOne(PKL::class, 'mahasiswa_nim', 'nim')->latestOfMany('progress_ke');
    }

}
