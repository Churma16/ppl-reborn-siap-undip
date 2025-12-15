<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\Skripsi;

use Illuminate\Support\Facades\Auth;

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

        return view('dashboard-dosen.index', [
            'title' => 'Dashboard Dosen',
            'dosen' => $dosen,
            'muridPerwalianPkl' => $muridPerwalianPkl,
            'muridPerwalianSkripsi' => $muridPerwalianSkripsi,
            'muridPerwalianAktif' => $muridPerwalianAktif,
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
     * @param string $action
     * @param IRS $irs
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
     *
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
     *
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
     *
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
