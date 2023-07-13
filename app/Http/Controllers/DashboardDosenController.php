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
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();
        // dd($dosen);
        $mahasiswas = Mahasiswa::where('dosen_kode_wali', $dosen->kode_wali)->get();

        


        return view('dashboard-dosen.verifikasi-irs-mahasiswa', [
            'title' => 'Verifikasi IRS',
            'mahasiswas' => $mahasiswas,
        ]);
    }
}
