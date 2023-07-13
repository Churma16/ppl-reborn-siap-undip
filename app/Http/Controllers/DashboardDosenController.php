<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\IRS;

use Illuminate\Support\Facades\Auth;

class DashboardDosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        $muridPerwalianPkl = mahasiswa::has('pkl')->where('dosen_kode_wali', $dosen->kode_wali)->whereHas('pkl', function ($query) {
            $query->where('status_lulus', 'Belum Lulus');
        })->count();

        $muridPerwalianSkripsi = mahasiswa::has('skripsi')->where('dosen_kode_wali', $dosen->kode_wali)->whereHas('skripsi', function ($query) {
            $query->where('status_skripsi', 'Belum Lulus');
        })->count();

        // $muridPerwalianAktif =


        return view('dashboard-dosen.index', [
            'title' => 'Dashboard Dosen',
            'dosen' => $dosen,
            'muridPerwalianPkl' => $muridPerwalianPkl,
            'muridPerwalianSkripsi' => $muridPerwalianSkripsi,
        ]);
    }

    public function verifikasiIrs()
    {
        // Get Data Dosen
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        // Get Data Mahasiswa Perwalian
        $mahasiswas = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)->get();

        $mahasiswa_perwalian = $dosen->getMahasiswaBimbinganAttribute();

        // Get Data IRS Mahasiswa Perwalian
        $irss = IRS::whereIn('mahasiswa_nim', $mahasiswa_perwalian)->where('status_konfirmasi', 'Belum Dikonfirmasi')->get();



        return view('dashboard-dosen.verifikasi-irs-mahasiswa', [
            'title' => 'Verifikasi IRS',
            'mahasiswas' => $mahasiswas,
            'dosen' => $dosen,
            'irss' => $irss,
        ]);
    }

    public function verifikasiIrsKeputusan($action, IRS $irs)
    {
        if ($action === 'terima') {
            $irs->update([
                'status_konfirmasi' => 'Sudah Dikonfirmasi',
            ]);
        } elseif ($action === 'tolak') {
            $irs->update([
                'status_konfirmasi' => 'Ditolak',
            ]);
        }

        return redirect()->back();
    }
}
