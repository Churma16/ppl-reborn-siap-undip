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
            ->where('dosen_kode_wali', $dosen->kode_wali)
            ->whereHas('pkl', function ($query) {
                $query->where('status_lulus', 'Belum Lulus');
            })
            ->count();

        // Menghitung jumlah mahasiswa perwalian skripsi yang belum lulus
        $muridPerwalianSkripsi = Mahasiswa::has('skripsi')
            ->where('dosen_kode_wali', $dosen->kode_wali)
            ->whereHas('skripsi', function ($query) {
                $query->where('status_skripsi', 'Belum Lulus');
            })
            ->count();

        $muridPerwalianAktif = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
            // ->where('status_mahasiswa', 'Aktif')
            ->count();

        // // Ambil semua data mahasiswa perwalian
        // $muridPerwalian = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
        //     // ->where('status_mahasiswa', 'Aktif')
        //     ->pluck('nim')->toArray();

        // // ambil id semester yang aktif
        // $semesterAktif = Semester::where('is_active',"1")->pluck('id')->toArray();

        // $irsPerwalianAktif = IRS::whereIn('semester_id',$semesterAktif)->whereIn('mahasiswa_nim',$muridPerwalian)->pluck('mahasiswa_nim')->toArray();
        // $muridPerwalianAktifSemesterTerbaru = Mahasiswa::whereIn('nim',$irsPerwalianAktif)->count();
        // dd($muridPerwalianAktifSemesterTerbaru);

        $jumlahPerwalianAktifSmtLatest = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
        ->whereHas('irs', function ($query) {
            // Filter IRS yang semesternya aktif
            $query->whereHas('semester', function ($q) {
                $q->where('is_active', '1');
            });
        })
        ->count();

        // $jumlahPerwalianSmtSebelumnya = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali);
        // Ambil semua data mahasiswa perwalian
        $muridPerwalian = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
            // ->where('status_mahasiswa', 'Aktif')
            ->pluck('nim')->toArray();

        // ambil id semester yang aktif
        $semesterAktif = Semester::where('is_active', '1')->pluck('id')->toArray();

        // ambil id 1 semester sebelumnya
        $semesterSebelumnya = Semester::where('id', '<', max($semesterAktif))->orderBy('id', 'desc')->pluck('id')->first();

        // $irsPerwalianAktif = IRS::where('semester_id', $semesterSebelumnya)->whereIn('mahasiswa_nim', $muridPerwalian)->pluck('mahasiswa_nim')->toArray();
        // $muridPerwalianAktifSemesterSebelumnya = Mahasiswa::whereIn('nim', $irsPerwalianAktif)->count();

        $muridPerwalianAktifSemesterSebelumnya = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
        ->whereRelation('irs.semester', 'id', $semesterSebelumnya)->count();
        // dd($muridPerwalianAktifSemesterSebelumnya);

        //bawah ga kepake belajar aja
        // $idSemester = 4;
        // $mahasiswaSuram = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
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

        $perwalianTidakAktifSmtNow = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
        ->whereDoesntHave('irs', fn ($q) => $q
        ->where('semester_id', $semesterAktif))
        ->count();

        $perwalianTidakAktifSmtSebelumnya = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
        ->whereDoesntHave('irs', fn ($q) => $q
        ->where('semester_id', $semesterSebelumnya))
        ->count();

        $perwalianTidakAktifDiff = $perwalianTidakAktifSmtNow - $perwalianTidakAktifSmtSebelumnya;
        $perwalianTidakAktifDiff = sprintf('%+d', $perwalianTidakAktifDiff);

        $verifikasiKhsCount = KHS::whereIn('mahasiswa_nim', $dosen->getMahasiswaBimbinganAttribute())
        ->where('status_konfirmasi', 'Belum Dikonfirmasi')
        ->count();

        // $perwalianPklAktif = mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
        // ->whereRelation('irs', 'status_konfirmasi', 'Dikonfirmasi')
        // ->whereRelation('irs', 'semester_id', $semesterAktif)
        // ->whereRelation('pkl', 'semester_id', $semesterAktif)
        // ->whereRelation('pkl', 'status_lulus', 'Belum Lulus')
        // ->get();

        $perwalianPklAktifNow = mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
        ->whereHas('irs', fn ($q) => $q
            ->where('semester_id', $semesterAktif)
            ->where('status_konfirmasi', 'Dikonfirmasi')
        )
        ->whereHas('pkl', fn ($q) => $q
            ->where('semester_id', $semesterAktif)
            ->where('status_lulus', 'Belum Lulus')
        )
        ->count();

        $perwalianPklAktifSebelumnya = mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
        ->whereHas('irs', fn ($q) => $q
            ->where('semester_id', $semesterSebelumnya)
            ->where('status_konfirmasi', 'Dikonfirmasi')
        )
        ->whereHas('pkl', fn ($q) => $q
            ->where('semester_id', $semesterSebelumnya)
            ->where('status_konfirmasi', 'Dikonfirmasi')
        )
        ->count();

        // dd($perwalianPklAktifSebelumnya);

        $perwalianPklDiff = $perwalianPklAktifNow - $perwalianPklAktifSebelumnya;
        $perwalianPklDiff = sprintf('%+d', $perwalianPklDiff);

        $perwalianSkripsiAktifNow = mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
        ->whereHas('irs', fn ($q) => $q
            ->where('semester_id', $semesterAktif)
            ->where('status_konfirmasi', 'Dikonfirmasi')
        )
        ->whereHas('skripsi', fn ($q) => $q
            ->where('semester_id', $semesterAktif)
            ->where('status_skripsi', 'Belum Lulus')
        )
        ->count();

        $perwalianSkripsiAktifSebelumnya = mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
        ->whereHas('irs', fn ($q) => $q
            ->where('semester_id', $semesterSebelumnya)
            ->where('status_konfirmasi', 'Dikonfirmasi')
        )
        ->whereHas('skripsi', fn ($q) => $q
            ->where('semester_id', $semesterSebelumnya)
            ->where('status_konfirmasi', 'Dikonfirmasi')
        )
        ->count();

        $perwalianSkripsiDiff = $perwalianSkripsiAktifNow - $perwalianSkripsiAktifSebelumnya;
        $perwalianSkripsiDiff = sprintf('%+d', $perwalianSkripsiDiff);

        // dd($perwalianSkripsiAktifSebelumnya);

        $sidangTerdekat = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)
        ->whereHas('irs', fn ($q) => $q
            ->where('semester_id', $semesterAktif)
            ->where('status_konfirmasi', 'Dikonfirmasi')
        )
        ->whereHas('skripsi', fn ($q) => $q
            ->whereNotNull('tanggal_sidang')
            ->where('semester_id', $semesterAktif)
            ->where('status_konfirmasi', 'Dikonfirmasi')
            ->where('status_skripsi', 'Belum Lulus')
        )
        ->with(['skripsi' => fn ($q) => $q
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

        $permintaanPklTerbaru = PKL::with('mahasiswa')->where('status_konfirmasi', 'Belum Dikonfirmasi')
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
            ->sortByDesc('created_at');

        return view('dashboard-dosen.index', [
            'title' => 'Dashboard Dosen',
            'dosen' => $dosen,
            'muridPerwalianPkl' => $muridPerwalianPkl,
            'muridPerwalianSkripsi' => $muridPerwalianSkripsi,
            'muridPerwalianAktif' => $muridPerwalianAktif,
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

        ]);
    }

    /**
     * Menampilkan halaman verifikasi IRS mahasiswa perwalian.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function verifikasiIrs()
    {
        // Mengambil data dosen berdasarkan NIP pengguna yang sedang login
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        // Mengambil data mahasiswa perwalian dosen
        $mahasiswas = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)->get();

        // Mendapatkan daftar nim mahasiswa perwalian dosen
        $mahasiswa_perwalian = $dosen->getMahasiswaBimbinganAttribute();

        // Mengambil data IRS mahasiswa perwalian yang belum dikonfirmasi
        $irss = IRS::whereIn('mahasiswa_nim', $mahasiswa_perwalian)
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->get();

        return view('dashboard-dosen.verifikasi-irs-mahasiswa', [
            'title' => 'Verifikasi IRS',
            'mahasiswas' => $mahasiswas,
            'dosen' => $dosen,
            'irss' => $irss,
        ]);
    }

    /**
     * Verifikasi keputusan IRS mahasiswa perwalian.
     *
     * @param  string  $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifikasiIrsKeputusan($action, IRS $irs)
    {
        // Jika aksi adalah 'terima', maka ubah status konfirmasi IRS menjadi 'Dikonfirmasi'
        if ($action === 'terima') {
            $irs->update([
                'status_konfirmasi' => 'Dikonfirmasi',
            ]);
        }
        // Jika aksi adalah 'tolak', maka ubah status konfirmasi IRS menjadi 'Ditolak'
        elseif ($action === 'tolak') {
            $irs->update([
                'status_konfirmasi' => 'Ditolak',
            ]);
        }

        return redirect()->back();
    }

    /**
     * Menampilkan halaman verifikasi KHS mahasiswa perwalian.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function verifikasiKhs()
    {
        // Mengambil data dosen berdasarkan NIP pengguna yang sedang login
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        // Mengambil data mahasiswa perwalian dosen
        $mahasiswas = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)->get();

        // Mendapatkan daftar nim mahasiswa perwalian dosen
        $mahasiswa_perwalian = $dosen->getMahasiswaBimbinganAttribute();

        // Mengambil data KHS mahasiswa perwalian yang belum dikonfirmasi
        $khss = KHS::whereIn('mahasiswa_nim', $mahasiswa_perwalian)
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->get();

        return view('dashboard-dosen.verifikasi-khs-mahasiswa', [
            'title' => 'Verifikasi KHS',
            'mahasiswas' => $mahasiswas,
            'dosen' => $dosen,
            'khss' => $khss,
        ]);
    }

    /**
     * The function verifikasiKhsKeputusan takes an action and a KHS object as parameters, and updates the
     * status of the KHS confirmation based on the action.
     *
     * @param action The action parameter is a string that represents the action to be performed. It can
     * have two possible values: 'terima' or 'tolak'.
     * @param KHS khs The parameter `` is an instance of the `KHS` class.
     * @return a redirect back to the previous page.
     */
    public function verifikasiKhsKeputusan($action, KHS $khs)
    {
        // Jika aksi adalah 'terima', maka ubah status konfirmasi khs menjadi 'Dikonfirmasi'
        if ($action === 'terima') {
            $khs->update([
                'status_konfirmasi' => 'Dikonfirmasi',
            ]);
        }
        // Jika aksi adalah 'tolak', maka ubah status konfirmasi khs menjadi 'Ditolak'
        elseif ($action === 'tolak') {
            $khs->update([
                'status_konfirmasi' => 'Ditolak',
            ]);
        }

        return redirect()->back();
    }

    /**
     * The function "verifikasiPkl" retrieves data of PKL (Praktek Kerja Lapangan) from the database and
     * displays it on the view for a specific logged-in user.
     *
     * @return a view called 'dashboard-dosen.verifikasi-pkl-mahasiswa' with the following data:
     */
    public function verifikasiPkl()
    {
        // Mengambil data dosen berdasarkan NIP pengguna yang sedang login
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        // Mengambil data mahasiswa perwalian dosen
        $mahasiswas = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)->get();

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

    /**
     * The function verifikasiPklKeputusan takes an action and a PKL object as parameters, and updates the
     * status_konfirmasi attribute of the PKL object based on the action parameter.
     *
     * @param action The parameter "action" is a string that represents the action to be performed on the
     * PKL (Praktek Kerja Lapangan) object. It can have two possible values: "terima" (accept) or "tolak"
     * (reject).
     * @param PKL pkl The parameter `` is an instance of the `PKL` class.
     * @return a redirect back to the previous page.
     */
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

    /**
     * The function "verifikasiSkripsi" retrieves data of a logged-in user's supervisor, their supervised
     * students, and the unconfirmed theses of those students, and returns a view with the retrieved data.
     *
     * @return a view called 'dashboard-dosen.verifikasi-skripsi-mahasiswa' with the following data:
     */
    public function verifikasiSkripsi()
    {
        // Mengambil data dosen berdasarkan NIP pengguna yang sedang login
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        // Mengambil data mahasiswa perwalian dosen
        $mahasiswas = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)->get();

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

    /**
     * The function verifikasiSkripsiKeputusan takes an action and a Skripsi object as parameters, and
     * updates the status_konfirmasi of the Skripsi object based on the action.
     *
     * @param action The action parameter is a string that represents the action to be taken on the skripsi
     * (thesis). It can have two possible values: 'terima' (accept) or 'tolak' (reject).
     * @param Skripsi skripsi The parameter `` is an instance of the `Skripsi` class. It represents
     * a skripsi (thesis) object that needs to be verified.
     * @return a redirect back to the previous page.
     */
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
}
