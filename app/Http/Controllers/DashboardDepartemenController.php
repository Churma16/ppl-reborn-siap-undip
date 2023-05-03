<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Pkl;
use App\Models\Skripsi;

use Illuminate\Http\Request;

class DashboardDepartemenController extends Controller
{
    public function index()
    {
        // $mahasiswa = Mahasiswa::all(1);
        // $count = $mahasiswa->getMahasiswaPklCountAttribute();


        $mahasiswa = new Mahasiswa();
        $dosen= new Dosen();
        $pkl = new Pkl();
        $skripsi = new Skripsi();

        // dd($count);
        return view('dashboard-departemen.index',[
            'mahasiswa' => $mahasiswa,
            'dosen' => $dosen,
            'pkl' => $pkl,
            'skripsi' => $skripsi,
        ]);
    }

    public function dataMahasiswa()
    {
        $mahasiswa = Mahasiswa::all();
        return view('dashboard-departemen.data-mahasiswa',[
            'mahasiswas' => $mahasiswa,
        ]);
    }
}
