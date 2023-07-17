<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MahasiswaKelolaIrs extends Controller
{
    /**
     * Menampilkan daftar IRS mahasiswa.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mendapatkan data mahasiswa berdasarkan NIM pengguna yang sedang login
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->nip_nim)->first();

        // Mendapatkan IRS mahasiswa
        $irss = IRS::where('mahasiswa_nim', $mahasiswa->nim)->get();

        return view('dashboard-mahasiswa.mahasiswa-kelola-irs.index', [
            'title' => 'Isian Rencana Studi (IRS)',
            'mahasiswa' => $mahasiswa,
            'irss' => $irss
        ]);
    }

    /**
     * Menampilkan halaman form unggah IRS.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Mendapatkan data mahasiswa berdasarkan NIM pengguna yang sedang login
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->nip_nim)->first();

        // Mendapatkan IRS mahasiswa
        $irss = IRS::where('mahasiswa_nim', $mahasiswa->nim)->get();

        // Mendapatkan SKS kumulatif
        $sksk = IRS::where('mahasiswa_nim', $mahasiswa->nim)->where('status_konfirmasi', 'Dikonfirmasi')->sum('jumlah_sks');

        // Mendapatkan semester aktif terakhir
        $semesterAktif = IRS::where('mahasiswa_nim', $mahasiswa->nim)->orderBy('semester_aktif', 'desc')->first();
        if ($semesterAktif == null) {
            $semesterAktif = [
                'semester_aktif' => '0'
            ];
        }

        return view('dashboard-mahasiswa.mahasiswa-kelola-irs.create', [
            'title' => 'Unggah IRS',
            'mahasiswa' => $mahasiswa,
            'irss' => $irss,
            'sksk' => $sksk,
            'semesterAktif' => $semesterAktif['semester_aktif'] + 1,
        ]);
    }

    /**
     * Menyimpan data IRS yang diunggah.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Mendapatkan semester aktif terakhir
        $semesterAktif = IRS::where('mahasiswa_nim', Auth::user()->nip_nim)->orderBy('semester_aktif', 'desc')->first();
        if ($semesterAktif == null) {
            $semesterAktif = [
                'semester_aktif' => '0'
            ];
        }

        // Validasi data input
        $validatedData = $request->validate([
            'file_sks' => 'required|mimes:pdf|max:10000',
            'jumlah_sks' => 'required|numeric|min:1|max:24',
        ]);

        // Mengunggah file SKS
        if ($request->file('file_sks')) {
            $validatedData['file_sks'] = $request->file('file_sks')->store('file-sks');
        }

        // Menambahkan data IRS
        $validatedData['mahasiswa_nim'] = Auth::user()->nip_nim;
        $validatedData['status_konfirmasi'] = 'Belum Dikonfirmasi';
        $validatedData['semester_aktif'] = $semesterAktif['semester_aktif'] + 1;

        IRS::create($validatedData);
        return redirect('/dashboard-mahasiswa/kelola-irs')->with('success', 'IRS berhasil diunggah!');
    }

    /**
     * Menampilkan halaman detail IRS.
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
     * Menampilkan halaman edit IRS.
     *
     * @param  \App\Models\IRS  $iRS
     * @return \Illuminate\Http\Response
     */
    public function edit(IRS $iRS)
    {
        //
    }

    /**
     * Memperbarui data IRS.
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
     * Menghapus data IRS.
     *
     * @param  \App\Models\IRS  $iRS
     * @return \Illuminate\Http\Response
     */
    public function destroy(IRS $iRS)
    {
        //
    }
}
