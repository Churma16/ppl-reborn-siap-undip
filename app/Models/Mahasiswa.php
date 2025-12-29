<?php

namespace App\Models;

use App\Models\IRS;
use App\Enums\IrsStatusKonfirmasi;
use App\Enums\SemesterStatusAktif;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $primaryKey = 'nim';
    protected $guarded = ['id'];

    // =========================================================================
    // RELATIONS
    // =========================================================================

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_kode_wali', 'kode_wali');
    }

    public function irs(): HasMany
    {
        return $this->hasMany(IRS::class, 'mahasiswa_nim', 'nim');
    }

    public function irsAktif(): HasOne
    {
        return $this->hasOne(IRS::class, 'mahasiswa_nim', 'nim')
            ->whereRelation('semester', 'is_active', SemesterStatusAktif::AKTIF->value)
            ->where('status_konfirmasi', IrsStatusKonfirmasi::Dikonfirmasi->value)
            ->latest('semester_aktif');
    }

    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_kode_kabupaten', 'kode_kabupaten');
    }

    public function khs(): HasMany
    {
        return $this->hasMany(KHS::class, 'mahasiswa_nim', 'nim');
    }

    public function khsTerakhir(): HasOne
    {
        return $this->hasOne(KHS::class, 'mahasiswa_nim', 'nim')->latestOfMany('semester');
    }

    public function pkl(): HasMany
    {
        return $this->hasMany(PKL::class, 'mahasiswa_nim', 'nim');
    }

    public function pklTerakhir(): HasOne
    {
        return $this->hasOne(PKL::class, 'mahasiswa_nim', 'nim')->latestOfMany('progress_ke');
    }

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_kode_provinsi', 'kode_provinsi');
    }

    public function skripsi(): HasMany
    {
        return $this->hasMany(Skripsi::class, 'mahasiswa_nim', 'nim');
    }

    public function skripsiTerakhir(): HasOne
    {
        return $this->hasOne(Skripsi::class, 'mahasiswa_nim', 'nim')->latestOfMany('progress_ke');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nim', 'nip_nim');
    }

    // =========================================================================
    // SCOPES
    // =========================================================================

    public function scopeAktifDiSmt($q, $idSemester)
    {
        return $q->whereHas(
            'irs',
            fn($q) => $q
                ->where('semester_id', $idSemester)
                ->where('status_konfirmasi', 'Dikonfirmasi')
        );
    }

    public function scopeAktifSmtIni($q)
    {
        return $q->whereHas(
            'irs',
            fn($q) => $q
                ->whereHas('semester', fn($s) => $s->where('is_active', '1'))
                ->where('status_konfirmasi', 'Dikonfirmasi')
        );
    }

    public function scopeBelumBimbinganSkripsi2Minggu($q)
    {
        return $q->whereHas(
            'skripsiTerakhir',
            fn($q) => $q
                ->where('status_skripsi', 'Belum Lulus')
                ->whereDate('created_at', '<', now()->subday(14))
        );
    }

    public function scopeBelumLulus($q)
    {
        return $q->whereDoesntHave('khs', fn($q) => $q->where('status_mahasiswa', 'Lulus'));
    }

    public function scopeMilikDosen($query, Dosen $dosen)
    {
        return $query->where('dosen_kode_wali', $dosen->kode_wali);
    }

    public function scopePklAktifSmtIni($q)
    {
        return $q->whereHas(
            'pkl',
            fn($q) => $q
                ->where('status_lulus', 'Belum Lulus')
                ->whereHas('semester', fn($s) => $s->where('is_active', '1'))
        );
    }

    public function scopeSudahLulus($q)
    {
        return $q->whereHas('khs', fn($q) => $q->where('status_mahasiswa', 'Lulus'));
    }

    public function scopeTidakAktifDiSmt($q, $idSemester)
    {
        return $q->whereHas('irs', fn($q) => $q->where('semester_id', $idSemester))
            ->belumLulus();
    }

    public function scopeTidakAktifSmtIni($q)
    {
        return $q->whereDoesntHave(
            'irs',
            fn($q) => $q
                ->whereHas('semester', fn($s) => $s->where('is_active', '1'))
        )->belumLulus();
    }

    // =========================================================================
    // ACCESSORS
    // =========================================================================

    public function getIpKumulatifAttribute()
    {
        $max_semester = $this->khs()->max('semester');
        return $this->khs()->where('semester', $max_semester)->value('ip_kumulatif');
    }

    public function getIrsTerendahAttribute()
    {
        return $this->irs()->min('jumlah_sks');
    }

    public function getJumlahMahasiswaAttribute()
    {
        return $this->count();
    }

    public function getJumlahSksAttribute()
    {
        return $this->irs()->sum('jumlah_sks');
    }

    public function getJumlahStatusPklAttribute(): array
    {
        return [
            'sudah_ambil' => self::has('pkl')->count(),
            'belum_ambil' => self::doesntHave('pkl')->count(),
        ];
    }

    public function getJumlahStatusSkripsiAttribute(): array
    {
        return [
            'sudah_ambil' => self::has('skripsi')->count(),
            'belum_ambil' => self::doesntHave('skripsi')->count(),
        ];
    }

    public function getSemesterAktifAttribute()
    {
        return $this->irs()->max('semester_aktif');
    }

    public function getStatusAkademikAttribute(): string
    {
        if ($this->khsTerakhir && $this->khsTerakhir->status_mahasiswa == 'Lulus') {
            return 'Lulus';
        }

        if (!$this->irsAktif || $this->irsAktif->status_konfirmasi == 'Belum Dikonfirmasi') {
            return 'Tidak Aktif';
        }

        return 'Aktif';
    }

    public function getStatusAktifAttribute()
    {
        return $this->khs()
            ->where('semester', $this->khs()->max('semester'))
            ->value('status_mahasiswa');
    }
}
