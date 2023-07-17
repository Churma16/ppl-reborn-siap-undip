<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\IRS;
use App\Models\KHS;
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

        return view('dashboard-dosen.index', [
            'title' => 'Dashboard Dosen',
            'dosen' => $dosen,
            'muridPerwalianPkl' => $muridPerwalianPkl,
            'muridPerwalianSkripsi' => $muridPerwalianSkripsi,
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
}
