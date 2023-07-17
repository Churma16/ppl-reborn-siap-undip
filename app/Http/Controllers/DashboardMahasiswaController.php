<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Kabupaten;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    public function index(){
        
        // Data Mahasiswa
        $mahasiswa = Mahasiswa::where('nim', auth()->user()->nip_nim)->first();

        // IPK
        $ipKumulatifNotFormatted =number_format(KHS::where('mahasiswa_nim', $mahasiswa->nim)->where('status_konfirmasi','Dikonfirmasi')->avg('ip_semester'),2);
        $ipk=$ipKumulatifNotFormatted;

        // Semester Aktif
        $semesterAktif = IRS::where('mahasiswa_nim', $mahasiswa->nim)->orderBy('semester_aktif', 'desc')->first();
        if($semesterAktif == null){
            $semesterAktif = [
                'semester_aktif' => '-'
            ];
        }

        // Sks Kumulatif
        $sksk = IRS::where('mahasiswa_nim', $mahasiswa->nim)->where('status_konfirmasi', 'Dikonfirmasi')->sum('jumlah_sks');

        return view('dashboard-mahasiswa.index', [
            'title' => 'Dashboard Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'ipk' => $ipk,
            'semesterAktif' => $semesterAktif['semester_aktif'],
            'sksk' => $sksk,
        ]);
    }

    public function edit(){
        $mahasiswa = Mahasiswa::where('nim', auth()->user()->nip_nim)->first();
        $provinsis = Provinsi::all();
        $kabupatens = Kabupaten::all();
        return view('dashboard-mahasiswa.edit-profile', [
            'title' => 'Edit Profil',
            'mahasiswa' => $mahasiswa,
            'provinsis' => $provinsis,
            'kabupatens' => $kabupatens,
        ]);
    }
}
