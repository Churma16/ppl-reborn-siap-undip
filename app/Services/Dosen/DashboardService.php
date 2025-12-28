<?php

namespace App\Services\Dosen;

use App\Models\Dosen;
use App\Models\Semester;
use App\Models\Mahasiswa;

class DashboardService
{
    /**
     * Get dashboard data for lecturer
     */

    protected $dosen;

    public function __construct(Dosen $dosen)
    {
        $this->dosen = $dosen;
    }

    public function DashboardData()
    {
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();
        $semesterAktif = Semester::where('is_active', '1')->pluck('id')->toArray();
        $semesterSebelumnya = Semester::where('id', '<', max($semesterAktif))->orderBy('id', 'desc')->pluck('id')->first();

        $kodeWali = $dosen->kode_wali;

        return [
            'title' => 'Dashboard Dosen',
            'dosen' => $dosen,
            'dosen' => $dosen,
            'muridPerwalianPkl' => $muridPerwalianPkl,
            'muridPerwalianSkripsi' => $muridPerwalianSkripsi,
            'jumlahPerwalianAktifSmtLatest' => $jumlahPerwalianAktifSmtLatest,
            'muridPerwalianAktifSemesterSebelumnya' => $muridPerwalianAktifSemesterSebelumnya,
            'perwalianDiff' => $perwalianDiff,
            'perwalianTidakAktifDiff' => $perwalianTidakAktifDiff,
            'perwalianTidakAktifSmtNow' => $perwalianTidakAktifSmtNow,
            'verifikasiKhsCount' => $verifikasiKhsCount,
            'perwalianPklDiff' => $perwalianPklDiff,
            'perwalianPklAktifNow' => $perwalianPklAktifNow,
            'perwalianSkripsiDiff' => $perwalianSkripsiDiff,
            'perwalianSkripsiAktifNow' => $perwalianSkripsiAktifNow,
            'sidangTerdekats' => $sidangTerdekat,
            'permintaanTerbarus' => $permintaanTerbaru,
            'permintaanKhsTerbaru' => $permintaanKhsTerbaru,
            'permintaanIrsTerbaru' => $permintaanIrsTerbaru,
            'permintaanPklTerbaru' => $permintaanPklTerbaru,
            'permintaanSkripsiTerbaru' => $permintaanSkripsiTerbaru,
            'mhsSkripsiMangkraks' => $mhsSkripsiMangkrak,

        ];
    }

    public function getMuridPerwalianPkl()
    {
        $muridPerwalianPkl = Mahasiswa::has('pkl')
            ->milikDosen($this->dosen)
            ->whereHas('pkl', function ($query) {
                $query->where('status_lulus', 'Belum Lulus');
            })
            ->count();

        return $muridPerwalianPkl;
    }

    public function getMuridPerwalianSkripsi()
    {
        $muridPerwalianSkripsi = Mahasiswa::has('skripsi')
            ->milikDosen($this->dosen)
            ->whereHas('skripsi', function ($query) {
                $query->where('status_skripsi', 'Belum Lulus');
            })
            ->count();

        return $muridPerwalianSkripsi;
    }

    public function getJumlahPerwalianAktifSmtLatest()
    {
        $jumlahPerwalianAktifSmtLatest = Mahasiswa::milikDosen($this->dosen)
            ->aktifSmtIni()
            ->count();

        return $jumlahPerwalianAktifSmtLatest;
    }

    public function getMuridPerwalianAktifSemesterSebelumnya($semesterSebelumnya)
    {
        $muridPerwalianAktifSemesterSebelumnya = Mahasiswa::milikDosen($this->dosen)
            ->whereRelation('irs.semester', 'id', $semesterSebelumnya)
            ->count();

        return $muridPerwalianAktifSemesterSebelumnya;
    }

    public function getPerwalianDiff($semesterSebelumnya)
    {
        $saatIni = $this->getJumlahPerwalianAktifSmtLatest();
        $lalu    = $this->getMuridPerwalianAktifSemesterSebelumnya($semesterSebelumnya);

        return sprintf('%+d', $saatIni - $lalu);
    }

    public function getPerwalianTidakAktifSmtNow($semesterAktif)
    {
        $perwalianTidakAktifSmtNow = Mahasiswa::where('dosen_kode_wali', $this->dosen)
            ->whereDoesntHave('irs', fn($q) => $q
                ->where('semester_id', $semesterAktif))
            ->count();

        return $perwalianTidakAktifSmtNow;
    }
}
