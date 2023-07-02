<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Mahasiswa;

class DashboardDosenController extends Controller
{
    public function index(Dosen $dosen)
    {
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
}
