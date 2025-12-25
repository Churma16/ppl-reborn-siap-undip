<?php

namespace App\Http\Controllers;

use App\Enums\SemesterStatusAktif;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MahasiswaKelolaPkl extends Controller
{
    /**
     * Menampilkan daftar PKL mahasiswa.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mendapatkan data mahasiswa berdasarkan NIM pengguna yang sedang login
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->nip_nim)->first();

        // Mendapatkan PKL mahasiswa
        $pkls = PKL::where('mahasiswa_nim', Auth::user()->nip_nim)->orderBy('progress_ke', 'asc')->get();

        return view('dashboard-mahasiswa.mahasiswa-kelola-pkl.index', [
            'title' => 'Kelola PKL',
            'mahasiswa' => $mahasiswa,
            'pkls' => $pkls,
        ]);
    }

    /**
     * Menampilkan halaman form unggah PKL.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Mendapatkan data mahasiswa berdasarkan NIM pengguna yang sedang login
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->nip_nim)->first();

        // Mendapatkan progress ke dalam PKL
        $progressKe = PKL::where('mahasiswa_nim', Auth::user()->nip_nim)->where('status_konfirmasi', 'Dikonfirmasi')->count();

        return view('dashboard-mahasiswa.mahasiswa-kelola-pkl.create', [
            'title' => 'Unggah PKL',
            'mahasiswa' => $mahasiswa,
            'progressKe' => $progressKe + 1,
        ]);
    }

    /**
     * Menyimpan data PKL yang diunggah.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Mendapatkan data PKL mahasiswa
        $pkl = PKL::where('mahasiswa_nim', Auth::user()->nip_nim)->first();

        // Validasi data input
        $validatedData = $request->validate([
            'rincian_progress' => 'required|max:50',
            'file_pkl' => 'required|mimes:pdf|max:2048',
            'progress_ke' => 'required|numeric',
            'nama_perusahaan' => 'required|max:50',
        ]);

        $latestSemester = Semester::where('is_active', SemesterStatusAktif::AKTIF)->latest()->value('id');
        // Mengunggah file PKL
        if ($request->file('file_pkl')) {
            $validatedData['file_pkl'] = $request->file('file_pkl')->store('file-pkl');
        }

        // Tambah Data
        $validatedData['status_lulus'] = 'Belum Lulus';

        if ($request->progress_ke == 1) {
            $validatedData['tanggal_mulai'] = Carbon::now()->format('Y-m-d');
        } else {
            $validatedData['nama_perusahaan'] = $pkl->nama_perusahaan;
            $validatedData['tanggal_mulai'] = $pkl->tanggal_mulai;
        }
        $validatedData['status_konfirmasi'] = 'Belum Dikonfirmasi';
        $validatedData['mahasiswa_nim'] = Auth::user()->nip_nim;
        $validatedData['semester_id'] = $latestSemester;

        PKL::create($validatedData);

        return redirect('/dashboard-mahasiswa/kelola-pkl')->with('success', 'PKL berhasil diunggah!');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PKL $pKL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PKL $pKL)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PKL $pKL)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PKL $pKL)
    {
        //
    }
}
