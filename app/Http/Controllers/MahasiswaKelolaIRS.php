<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MahasiswaKelolaIrs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data Mahasiswa
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->nip_nim)->first();

        // IRS
        $irss = IRS::where('mahasiswa_nim', $mahasiswa->nim)->get();

        return view('dashboard-mahasiswa.mahasiswa-kelola-irs.index', [
            'title' => 'Isian Rencana Studi (IRS)',
            'mahasiswa' => $mahasiswa,
            'irss' => $irss
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Data Mahasiswa
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->nip_nim)->first();

        // IRS
        $irss = IRS::where('mahasiswa_nim', $mahasiswa->nim)->get();

        // Sks Kumulatif
        $sksk = IRS::where('mahasiswa_nim', $mahasiswa->nim)->where('status_konfirmasi', 'Dikonfirmasi')->sum('jumlah_sks');

        // Semester Aktif
        $semesterAktif = IRS::where('mahasiswa_nim', $mahasiswa->nim)->orderBy('semester_aktif', 'desc')->first();
        if($semesterAktif == null){
            $semesterAktif = [
                'semester_aktif' => '1'
            ];
        }
        return view('dashboard-mahasiswa.mahasiswa-kelola-irs.create', [
            'title' => 'Unggah IRS',
            'mahasiswa' => $mahasiswa,
            'irss' => $irss,
            'sksk' => $sksk,
            'semesterAktif' => $semesterAktif['semester_aktif'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /// Semester Aktif
        $semesterAktif = IRS::where('mahasiswa_nim', $mahasiswa->nim)->orderBy('semester_aktif', 'desc')->first();
        if($semesterAktif == null){
            $semesterAktif = [
                'semester_aktif' => '1'
            ];
        }

        // Validasi
        $validatedData = $request->validate([
            'file_sks' => 'required|mimes:pdf|max:10000',
        ]);

        // Tambah Data
        $validatedData['mahasiswa_nim'] = Auth::user()->nip_nim;
        $validatedData['status_konfirmasi'] = 'Belum Dikonfirmasi';
        $validatedData['semester_aktif'] = $semesterAktif['semester_aktif'];
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IRS  $iRS
     * @return \Illuminate\Http\Response
     */
    public function show(IRS $iRS)
    {
        return view('dashboard-mahasiswa.mahasiswa-kelola-irs.show', [
            'title' => 'Isian Rencana Studi IRS'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IRS  $iRS
     * @return \Illuminate\Http\Response
     */
    public function edit(IRS $iRS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IRS  $iRS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IRS $iRS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IRS  $iRS
     * @return \Illuminate\Http\Response
     */
    public function destroy(IRS $iRS)
    {
        //
    }
}
