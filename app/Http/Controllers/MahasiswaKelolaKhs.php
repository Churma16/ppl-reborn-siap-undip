<?php

namespace App\Http\Controllers;

use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\IRS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MahasiswaKelolaKhs extends Controller
{
    /**
     * Menampilkan daftar KHS mahasiswa.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mendapatkan data mahasiswa berdasarkan NIM pengguna yang sedang login
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->nip_nim)->first();

        // Mendapatkan KHS mahasiswa
        $khss = KHS::where('mahasiswa_nim', $mahasiswa->nim)->orderBy('semester', 'asc')->get();

        return view('dashboard-mahasiswa.mahasiswa-kelola-khs.index', [
            'title' => 'Kartu Hasil Studi (KHS)',
            'mahasiswa' => $mahasiswa,
            'khss' => $khss
        ]);
    }

    /**
     * Menampilkan halaman form unggah KHS.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Mendapatkan data mahasiswa berdasarkan NIM pengguna yang sedang login
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->nip_nim)->first();

        // Mendapatkan KHS mahasiswa
        $khss = KHS::where('mahasiswa_nim', $mahasiswa->nim)->get();

        // Mendapatkan SKS kumulatif
        $sksk = IRS::where('mahasiswa_nim', $mahasiswa->nim)->where('status_konfirmasi', 'Dikonfirmasi')->sum('jumlah_sks');

        // Mendapatkan semester aktif terakhir
        $semesterAktif = IRS::where('mahasiswa_nim', $mahasiswa->nim)->orderBy('semester_aktif', 'desc')->first();

        // Mendapatkan IP Kumulatif
        $ipk = KHS::where('mahasiswa_nim', $mahasiswa->nim)->where('status_konfirmasi', 'Dikonfirmasi')->avg('ip_semester');
        if ($semesterAktif == null) {
            $semesterAktif = [
                'semester_aktif' => '0'
            ];
        }

        return view('dashboard-mahasiswa.mahasiswa-kelola-khs.create', [
            'title' => 'Unggah KHS',
            'mahasiswa' => $mahasiswa,
            'khss' => $khss,
            'sksk' => $sksk,
            'semesterAktif' => $semesterAktif['semester_aktif'],
            'ipk' => $ipk
        ]);
    }

    /**
     * Menyimpan data KHS yang diunggah.
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

        // Mendapatkan SKS kumulatif
        $sksk = IRS::where('mahasiswa_nim', Auth::user()->nip_nim)->where('status_konfirmasi', 'Dikonfirmasi')->sum('jumlah_sks');

        // Mendapatkan jumlah IPK
        $jumlahIpk = KHS::where('mahasiswa_nim', Auth::user()->nip_nim)->where('status_konfirmasi', 'Dikonfirmasi')->sum('ip_semester');

        // Validasi data input
        $validatedData = $request->validate([
            'file_khs' => 'required|mimes:pdf|max:10000',
            'ip_semester' => 'required|numeric|min:0.00|max:4.00',
        ]);

        // Mengunggah file KHS
        if ($request->file('file_khs')) {
            $validatedData['file_khs'] = $request->file('file_khs')->store('file-khs');
        }

        // Menghitung IP Kumulatif
        $ipKumulatif = ($jumlahIpk + $validatedData['ip_semester']) / (($semesterAktif['semester_aktif']) + 1);

        // Menambahkan data KHS
        $validatedData['sks_kumulatif'] = $sksk;
        $validatedData['ip_kumulatif'] = number_format($ipKumulatif, 2);
        $validatedData['status_mahasiswa'] = 'Aktif';
        $validatedData['mahasiswa_nim'] = Auth::user()->nip_nim;
        $validatedData['status_konfirmasi'] = 'Belum Dikonfirmasi';
        $validatedData['semester'] = $semesterAktif['semester_aktif'];

        KHS::create($validatedData);
        return redirect('/dashboard-mahasiswa/kelola-khs')->with('success', 'KHS berhasil diunggah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KHS  $kHS
     * @return \Illuminate\Http\Response
     */
    public function show(KHS $kHS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KHS  $kHS
     * @return \Illuminate\Http\Response
     */
    public function edit(KHS $kHS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KHS  $kHS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KHS $kHS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KHS  $kHS
     * @return \Illuminate\Http\Response
     */
    public function destroy(KHS $kHS)
    {
        //
    }
}
