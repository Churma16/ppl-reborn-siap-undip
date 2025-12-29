<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\Semester;
use App\Models\Skripsi;

class DashboardDosenController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard dosen.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Mengambil data dosen berdasarkan NIP pengguna yang sedang login
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        // Menghitung jumlah mahasiswa perwalian PKL yang belum lulus
        $muridPerwalianPkl = Mahasiswa::has('pkl')
            ->milikDosen($dosen)
            ->whereHas('pkl', function ($query) {
                $query->where('status_lulus', 'Belum Lulus');
            })
            ->count();

        // Menghitung jumlah mahasiswa perwalian skripsi yang belum lulus
        $muridPerwalianSkripsi = Mahasiswa::has('skripsi')
            ->milikDosen($dosen)
            ->whereHas('skripsi', function ($query) {
                $query->where('status_skripsi', 'Belum Lulus');
            })
            ->count();

        // $muridPerwalianAktif = Mahasiswa::milikDosen($dosen)
        //     // ->where('status_mahasiswa', 'Aktif')
        //     ->count();

        // // Ambil semua data mahasiswa perwalian
        // $muridPerwalian = Mahasiswa::milikDosen($dosen)
        //     // ->where('status_mahasiswa', 'Aktif')
        //     ->pluck('nim')->toArray();

        // // ambil id semester yang aktif
        // $semesterAktif = Semester::where('is_active',"1")->pluck('id')->toArray();

        // $irsPerwalianAktif = IRS::whereIn('semester_id',$semesterAktif)->whereIn('mahasiswa_nim',$muridPerwalian)->pluck('mahasiswa_nim')->toArray();
        // $muridPerwalianAktifSemesterTerbaru = Mahasiswa::whereIn('nim',$irsPerwalianAktif)->count();
        // dd($muridPerwalianAktifSemesterTerbaru);

        $jumlahPerwalianAktifSmtLatest = Mahasiswa::milikDosen($dosen)
            ->whereHas('irs', function ($query) {
                // Filter IRS yang semesternya aktif
                $query->whereHas('semester', function ($q) {
                    $q->where('is_active', '1');
                });
            })
            ->count();

        // $jumlahPerwalianSmtSebelumnya = Mahasiswa::milikDosen($dosen);
        // Ambil semua data mahasiswa perwalian
        $muridPerwalian = Mahasiswa::milikDosen($dosen)
            // ->where('status_mahasiswa', 'Aktif')
            ->pluck('nim')->toArray();

        // ambil id semester yang aktif
        $semesterAktif = Semester::where('is_active', '1')->pluck('id')->toArray();

        // ambil id 1 semester sebelumnya
        $semesterSebelumnya = Semester::where('id', '<', max($semesterAktif))->orderBy('id', 'desc')->pluck('id')->first();

        // $irsPerwalianAktif = IRS::where('semester_id', $semesterSebelumnya)->whereIn('mahasiswa_nim', $muridPerwalian)->pluck('mahasiswa_nim')->toArray();
        // $muridPerwalianAktifSemesterSebelumnya = Mahasiswa::whereIn('nim', $irsPerwalianAktif)->count();

        $muridPerwalianAktifSemesterSebelumnya = Mahasiswa::milikDosen($dosen)
            ->whereRelation('irs.semester', 'id', $semesterSebelumnya)->count();
        // dd($muridPerwalianAktifSemesterSebelumnya);

        //bawah ga kepake belajar aja
        // $idSemester = 4;
        // $mahasiswaSuram = Mahasiswa::milikDosen($dosen)
        //     ->whereHas('irs', fn ($q) => $q
        //     ->where('semester_id', $idSemester)
        //     ->where('jumlah_sks', '>', '22')
        //     )

        //     ->whereHas('khs', fn ($q) => $q
        //     ->where('semester_id', $idSemester)
        //     ->where('ip_semester', '<', 2.00)
        //     )
        //     ->get();

        $perwalianDiff = sprintf('%+d', $jumlahPerwalianAktifSmtLatest - $muridPerwalianAktifSemesterSebelumnya);

        $perwalianTidakAktifSmtNow = Mahasiswa::milikDosen($dosen)
            ->tidakAktifSmtIni()
            ->count();

        $perwalianTidakAktifSmtSebelumnya = Mahasiswa::milikDosen($dosen)
            ->tidakAktifDiSmt($semesterSebelumnya)
            ->count();

        $perwalianTidakAktifDiff = $perwalianTidakAktifSmtNow - $perwalianTidakAktifSmtSebelumnya;
        $perwalianTidakAktifDiff = sprintf('%+d', $perwalianTidakAktifDiff);

        $verifikasiKhsCount = KHS::whereIn('mahasiswa_nim', $dosen->getMahasiswaBimbinganAttribute())
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->count();

        // $perwalianPklAktif = mahasiswa::milikDosen($dosen)
        // ->whereRelation('irs', 'status_konfirmasi', 'Dikonfirmasi')
        // ->whereRelation('irs', 'semester_id', $semesterAktif)
        // ->whereRelation('pkl', 'semester_id', $semesterAktif)
        // ->whereRelation('pkl', 'status_lulus', 'Belum Lulus')
        // ->get();

        $perwalianPklAktifNow = mahasiswa::milikDosen($dosen)
            ->aktifSmtIni()
            ->PklAktifSmtIni()
            ->count();

        $perwalianPklAktifSebelumnya = mahasiswa::milikDosen($dosen)
            ->whereHas(
                'irs',
                fn($q) => $q
                    ->where('semester_id', $semesterSebelumnya)
                    ->where('status_konfirmasi', 'Dikonfirmasi')
            )
            ->whereHas(
                'pkl',
                fn($q) => $q
                    ->where('semester_id', $semesterSebelumnya)
                    ->where('status_konfirmasi', 'Dikonfirmasi')
            )
            ->count();

        // dd($perwalianPklAktifSebelumnya);

        $perwalianPklDiff = $perwalianPklAktifNow - $perwalianPklAktifSebelumnya;
        $perwalianPklDiff = sprintf('%+d', $perwalianPklDiff);

        $perwalianSkripsiAktifNow = mahasiswa::milikDosen($dosen)
            ->aktifSmtIni()
            ->whereHas(
                'skripsi',
                fn($q) => $q
                    ->where('semester_id', $semesterAktif)
                    ->where('status_skripsi', 'Belum Lulus')
            )
            ->count();

        $perwalianSkripsiAktifSebelumnya = mahasiswa::milikDosen($dosen)
            ->aktifDiSmt($semesterSebelumnya)
            ->whereHas(
                'skripsi',
                fn($q) => $q
                    ->where('semester_id', $semesterSebelumnya)
                    ->where('status_skripsi', 'Belum Lulus')
            )
            ->count();

        $perwalianSkripsiDiff = $perwalianSkripsiAktifNow - $perwalianSkripsiAktifSebelumnya;
        $perwalianSkripsiDiff = sprintf('%+d', $perwalianSkripsiDiff);

        // dd($perwalianSkripsiAktifSebelumnya);

        $sidangTerdekat = Mahasiswa::milikDosen($dosen)
            ->aktifSmtIni()
            ->whereHas(
                'skripsi',
                fn($q) => $q
                    ->whereNotNull('tanggal_sidang')
                    ->where('semester_id', $semesterAktif)
                    ->where('status_konfirmasi', 'Dikonfirmasi')
                    ->where('status_skripsi', 'Belum Lulus')
            )
            ->with([
                'skripsi' => fn($q) => $q
                    ->whereNotNull('tanggal_sidang')
                    ->where('semester_id', $semesterAktif)
                    ->where('status_konfirmasi', 'Dikonfirmasi')
                    ->where('status_skripsi', 'Belum Lulus'),
            ])
            ->get();

        $permintaanKhsTerbaru = KHS::with('mahasiswa')->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->whereIn('mahasiswa_nim', $dosen->mahasiswa_bimbingan)
            ->get()
            ->map(function ($item) {
                $item->type = 'KHS';
                return $item;
            });

        $permintaanIrsTerbaru = IRS::with('mahasiswa')->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->whereIn('mahasiswa_nim', $dosen->mahasiswa_bimbingan)
            ->get()
            ->map(function ($item) {
                $item->type = 'IRS';
                return $item;
            });

        $permintaanPklTerbaru = PKL::with('mahasiswa')
            ->belumDikonfirmasi()
            ->whereIn('mahasiswa_nim', $dosen->mahasiswa_bimbingan)
            ->get()
            ->map(function ($item) {
                $item->type = 'PKL';
                return $item;
            });

        $permintaanSkripsiTerbaru = Skripsi::with('mahasiswa')->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->whereIn('mahasiswa_nim', $dosen->mahasiswa_bimbingan)
            ->get()
            ->map(function ($item) {
                $item->type = 'Skripsi';
                return $item;
            });

        $permintaanTerbaru = collect()
            ->merge($permintaanKhsTerbaru)
            ->merge($permintaanIrsTerbaru)
            ->merge($permintaanPklTerbaru)
            ->merge($permintaanSkripsiTerbaru)
            ->sortBy('created_at');
        // dd($permintaanTerbaru);

        $mhsSkripsiMangkrak = Mahasiswa::milikDosen($dosen)
            ->belumBimbinganSkripsi2Minggu()
            ->with('skripsiTerakhir')
            // ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($mhs) {
                // Hitung selisih hari untuk ditampilkan
                $mhs->hari_mangkrak = now()->diffInDays($mhs->skripsiTerakhir->created_at);
                if ($mhs->hari_mangkrak < 15) {
                    $mhs->status_mangkrak = 'warning';
                    $mhs->warna_status = 'warning';
                } else {
                    $mhs->status_mangkrak = 'Kritis';
                    $mhs->warna_status = 'danger';
                }
                return $mhs;
            });

        // $mhs
        // dd($permintaanTerbaru);
        $mhsSkripsiMangkrak = $mhsSkripsiMangkrak->sortByDesc('hari_mangkrak');
        // dd($mhsSkripsiMangkrak);
        return view('dashboard-dosen.index', [
            'title' => 'Dashboard Dosen',
            'dosen' => $dosen,
            'muridPerwalianPkl' => $muridPerwalianPkl,
            'muridPerwalianSkripsi' => $muridPerwalianSkripsi,
            // 'muridPerwalianAktif' => $muridPerwalianAktif,
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

        ]);
    }

    public function verifikasiPkl()
    {
        // Mengambil data dosen berdasarkan NIP pengguna yang sedang login
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        // Mengambil data mahasiswa perwalian dosen
        $mahasiswas = Mahasiswa::milikDosen($dosen)->get();

        // Mendapatkan daftar nim mahasiswa perwalian dosen
        $mahasiswa_perwalian = $dosen->getMahasiswaBimbinganAttribute();

        // Mengambil data PKL mahasiswa perwalian yang belum dikonfirmasi
        $pkls = PKL::whereIn('mahasiswa_nim', $mahasiswa_perwalian)
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->get();

        return view('dashboard-dosen.verifikasi-pkl-mahasiswa', [
            'title' => 'Verifikasi PKL',
            'mahasiswas' => $mahasiswas,
            'dosen' => $dosen,
            'pkls' => $pkls,
        ]);
    }

    public function verifikasiPklKeputusan($action, PKL $pkl)
    {
        // Jika aksi adalah 'terima', maka ubah status konfirmasi pkl menjadi 'Dikonfirmasi'
        if ($action === 'terima') {
            $pkl->update([
                'status_konfirmasi' => 'Dikonfirmasi',
            ]);
        }
        // Jika aksi adalah 'tolak', maka ubah status konfirmasi pkl menjadi 'Ditolak'
        elseif ($action === 'tolak') {
            $pkl->update([
                'status_konfirmasi' => 'Ditolak',
            ]);
        }

        return redirect()->back();
    }

    public function verifikasiSkripsi()
    {
        // Mengambil data dosen berdasarkan NIP pengguna yang sedang login
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        // Mengambil data mahasiswa perwalian dosen
        $mahasiswas = Mahasiswa::milikDosen($dosen)->get();

        // Mendapatkan daftar nim mahasiswa perwalian dosen
        $mahasiswa_perwalian = $dosen->getMahasiswaBimbinganAttribute();

        // Mengambil data Skripsi mahasiswa perwalian yang belum dikonfirmasi
        $skripsis = Skripsi::whereIn('mahasiswa_nim', $mahasiswa_perwalian)
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->get();

        return view('dashboard-dosen.verifikasi-skripsi-mahasiswa', [
            'title' => 'Verifikasi Skripsi',
            'mahasiswas' => $mahasiswas,
            'dosen' => $dosen,
            'skripsis' => $skripsis,
        ]);
    }

    public function verifikasiSkripsiKeputusan($action, Skripsi $skripsi)
    {
        // Jika aksi adalah 'terima', maka ubah status konfirmasi skripsi menjadi 'Dikonfirmasi'
        if ($action === 'terima') {
            $skripsi->update([
                'status_konfirmasi' => 'Dikonfirmasi',
            ]);
        }
        // Jika aksi adalah 'tolak', maka ubah status konfirmasi skripsi menjadi 'Ditolak'
        elseif ($action === 'tolak') {
            $skripsi->update([
                'status_konfirmasi' => 'Ditolak',
            ]);
        }

        return redirect()->back();
    }

    public function getValidationTable()
    {
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        $permintaanKhsTerbaru = KHS::with('mahasiswa')
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->whereIn('mahasiswa_nim', $dosen->mahasiswa_bimbingan)
            ->get()
            ->map(function ($item) {
                $item->type = 'KHS';
                return $item;
            });

        $permintaanIrsTerbaru = IRS::with('mahasiswa')
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->whereIn('mahasiswa_nim', $dosen->mahasiswa_bimbingan)
            ->get()
            ->map(function ($item) {
                $item->type = 'IRS';
                return $item;
            });

        $permintaanPklTerbaru = PKL::with('mahasiswa')
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->whereIn('mahasiswa_nim', $dosen->mahasiswa_bimbingan)
            ->get()
            ->map(function ($item) {
                $item->type = 'PKL';
                return $item;
            });

        $permintaanSkripsiTerbaru = Skripsi::with('mahasiswa')
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->whereIn('mahasiswa_nim', $dosen->mahasiswa_bimbingan)
            ->get()
            ->map(function ($item) {
                $item->type = 'Skripsi';
                return $item;
            });

        // Merge all collections
        $permintaanTerbarus = collect()
            ->merge($permintaanKhsTerbaru)
            ->merge($permintaanIrsTerbaru)
            ->merge($permintaanPklTerbaru)
            ->merge($permintaanSkripsiTerbaru)
            ->sortBy('created_at');
        // -----------------------------------------------------
        // dd($permintaanTerbarus);
        // 3. Return the Partial View
        return view('dashboard-dosen.partials.validation_rows', compact('permintaanTerbarus'))->render();
    }

    public function verifyDashboardRequest($id, $action, $type)
    {

        $type = strtolower($type);

        $model = null;

        // return response()->json(['message' => $type], 200);
        switch ($type) {
            case 'khs':
                $model = KHS::find($id);
                break;
            case 'irs':
                $model = IRS::find($id);
                break;
            case 'pkl':
                $model = PKL::find($id);
                break;
            case 'skripsi':
                $model = Skripsi::find($id);
                break;
        }

        if (!$model) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        if ($action == 'approve') {
            $model->update(['status_konfirmasi' => 'Dikonfirmasi']);
            // return response()->json(['message' => $model], 200);
        } elseif ($action == 'reject') {
            $model->update(['status_konfirmasi' => 'Ditolak']);
        }

        return response()->json(['message' => 'Dosen dashboard request verified.'], 200);
    }
}
