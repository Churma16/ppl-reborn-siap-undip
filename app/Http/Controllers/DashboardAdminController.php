<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {

        return view('dashboard-admin.index', [
            'title' => 'Dashboard Admin'
        ]);
    }

    public function tambahMahasiswaBaru()
    {
        $provinsis = Provinsi::all();
        $kabupaten = Kabupaten::all();
        $dosens = Dosen::all();

        return view('dashboard-admin.tambah-mahasiswa-baru', [
            'title' => 'Tambah Mahasiswa Baru',
            'provinsis' => $provinsis,
            'kabupaten' => $kabupaten,
            'dosens' => $dosens
        ]);
    }

    public function createMahasiswa(Request $request)
    {

        $validatedData = $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'email' => 'required|unique:mahasiswas',
            'angkatan' => 'required',
            'jalur_masuk' => 'required',
            'dosen_kode_wali' => 'required',
        ]);

        $akunBaru = [
            'nip_nim' => $validatedData['nim'],
            'username' => $validatedData['nim'],
            'password' => bcrypt($validatedData['nim']), 
            'role' => '4',
        ];

        Mahasiswa::create($validatedData);
        User::create($akunBaru);

        return redirect('/dashboard-admin')->with('success', 'New post has been added!');
    }
}
