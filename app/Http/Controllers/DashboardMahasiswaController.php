<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    public function index(){

        // Data Mahasiswa
        $mahasiswa = Mahasiswa::where('nim', auth()->user()->nip_nim)->first();

        // IPK
        $ipk=KHS::where('mahasiswa_nim', $mahasiswa->nim)->avg('ip_semester');

        // Semester Aktif
        $semesterAktif = IRS::where('mahasiswa_nim', $mahasiswa->nim)->orderBy('semester_aktif', 'desc')->first();

        // Sks Kumulatif
        $sksk = IRS::where('mahasiswa_nim', $mahasiswa->nim)->sum('jumlah_sks');

        return view('dashboard-mahasiswa.index', [
            'title' => 'Dashboard Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'ipk' => $ipk,
            'semesterAktif' => $semesterAktif['semester_aktif'],
            'sksk' => $sksk
        ]);
    }
}
