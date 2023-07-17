<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Kabupaten;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\Provinsi;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    public function index()
    {

        // Data Mahasiswa
        $mahasiswa = Mahasiswa::where('nim', auth()->user()->nip_nim)->first();

        // IPK
        $ipKumulatifNotFormatted = number_format(KHS::where('mahasiswa_nim', $mahasiswa->nim)->where('status_konfirmasi', 'Dikonfirmasi')->avg('ip_semester'), 2);
        $ipk = $ipKumulatifNotFormatted;

        // Semester Aktif
        $semesterAktif = IRS::where('mahasiswa_nim', $mahasiswa->nim)->orderBy('semester_aktif', 'desc')->first();
        if ($semesterAktif == null) {
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

    public function edit()
    {
        $mahasiswa = Mahasiswa::where('nim', auth()->user()->nip_nim)->first();
        $provinsis = Provinsi::all();
        $kabupaten = Kabupaten::all();
        return view('dashboard-mahasiswa.edit-profile', [
            'title' => 'Edit Profil',
            'mahasiswa' => $mahasiswa,
            'provinsis' => $provinsis,
            'kabupaten' => $kabupaten,
        ]);
    }

    public function fetchKabupaten($id)
    {
        $kabupatens = Kabupaten::where('provinsi_kode_provinsi', $id)->get(['kode_kabupaten', 'nama']);
        return response()->json($kabupatens);
    }

    public function update(Mahasiswa $mahasiswa, Request $request)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'no_hp' => 'required|numeric',
            'email' => 'required|email',
            'alamat' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
        ]);

        $validatedData['kabupaten_kode_kabupaten'] = $validatedData['kabupaten'];
        unset($validatedData['kabupaten']);

        $validatedData['provinsi_kode_provinsi'] = $validatedData['provinsi'];
        unset($validatedData['provinsi']);

        Mahasiswa::where('nim', auth()->user()->nip_nim)->update($validatedData);
        return redirect('/dashboard-mahasiswa')->with('success', 'New post has been added!');

    }
}
