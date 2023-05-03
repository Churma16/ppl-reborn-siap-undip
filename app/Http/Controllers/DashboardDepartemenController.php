<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;

use Illuminate\Http\Request;

class DashboardDepartemenController extends Controller
{
    public function index()
    {
        // $mahasiswa = Mahasiswa::all(1);
        // $count = $mahasiswa->getMahasiswaPklCountAttribute();


        $mahasiswa = new Mahasiswa();
        $dosen= new Dosen();

        // dd($count);
        return view('dashboard-departemen.index',[
            'mahasiswa' => $mahasiswa,
            'dosen' => $dosen,
        ]);
    }
}
