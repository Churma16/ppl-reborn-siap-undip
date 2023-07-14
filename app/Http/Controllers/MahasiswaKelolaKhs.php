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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data Mahasiswa
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->nip_nim)->first();

        // IRS
        $khss = KHS::where('mahasiswa_nim', $mahasiswa->nim)->orderBy('semester', 'asc')->get();

        return view('dashboard-mahasiswa.mahasiswa-kelola-khs.index', [
            'title' => 'Kartu Hasil Studi (KHS)',
            'mahasiswa' => $mahasiswa,
            'khss' => $khss
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

        // KHS
        $khss = KHS::where('mahasiswa_nim', $mahasiswa->nim)->get();

        // Sks Kumulatif
        $sksk = IRS::where('mahasiswa_nim', $mahasiswa->nim)->where('status_konfirmasi', 'Dikonfirmasi')->sum('jumlah_sks');

        // Semester Aktif
        $semesterAktif = IRS::where('mahasiswa_nim', $mahasiswa->nim)->orderBy('semester_aktif', 'desc')->first();

        //IP Kumulatif
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /// Semester Aktif
        $semesterAktif = IRS::where('mahasiswa_nim', Auth::user()->nip_nim)->orderBy('semester_aktif', 'desc')->first();
        if ($semesterAktif == null) {
            $semesterAktif = [
                'semester_aktif' => '0'
            ];
        }

        // Sks Kumulatif
        $sksk = IRS::where('mahasiswa_nim', Auth::user()->nip_nim)->where('status_konfirmasi', 'Dikonfirmasi')->sum('jumlah_sks');


        // Jumlah IPK
        $jumlahIpk = KHS::where('mahasiswa_nim', Auth::user()->nip_nim)->where('status_konfirmasi', 'Dikonfirmasi')->sum('ip_semester');

        // Validasi
        $validatedData = $request->validate([
            'file_khs' => 'required|mimes:pdf|max:10000',
            'ip_semester' => 'required|numeric|min:0.00|max:4.00',
        ]);

        // Upload File
        if ($request->file('file_sks')) {
            $validatedData['file_sks'] = $request->file('file_khs')->store('file-khs');
        }

        // Ip Kumulatif
        $ipKumulatif =( $jumlahIpk + $validatedData['ip_semester']) / (($semesterAktif['semester_aktif']) + 1);
        // Tambah Data
        $validatedData['sks_kumulatif'] = $sksk;
        $validatedData['ip_kumulatif'] = number_format($ipKumulatif,2);
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
