<?php

namespace App\Http\Controllers;

use App\Models\Skripsi;
use App\Models\Mahasiswa;
use App\Models\PKL;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MahasiswaKelolaSkripsi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->nip_nim)->first();

        $skripsis = Skripsi::where('mahasiswa_nim', Auth::user()->nip_nim)->orderBy('progress_ke', 'asc')->get();

        return view('dashboard-mahasiswa.mahasiswa-kelola-skripsi.index', [
            'title' => 'Kelola Skripsi',
            'mahasiswa' => $mahasiswa,
            'skripsis' => $skripsis
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::where('nim', Auth::user()->nip_nim)->first();

        $progressKe = Skripsi::where('mahasiswa_nim', Auth::user()->nip_nim)->where('status_konfirmasi', 'Dikonfirmasi')->count();
        return view('dashboard-mahasiswa.mahasiswa-kelola-skripsi.create', [
            'title' => 'Unggah Skripsi',
            'mahasiswa' => $mahasiswa,
            'progressKe' => $progressKe + 1
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

        $skripsi = Skripsi::where('mahasiswa_nim', Auth::user()->nip_nim)->first();

        $validatedData = request()->validate([
            'judul' => 'required',
            'file_skripsi' => 'required|mimes:pdf|max:10000',
            'progress_ke' => 'required',
            'rincian_progress' => 'required|max:50',
        ]);

        if (request('file_skripsi')) {
            $validatedData['file_skripsi'] = $request->file('file_skripsi')->store('file_skripsi');
        }

        // Tambah Data
        $validatedData['mahasiswa_nim'] = Auth::user()->nip_nim;
        $validatedData['status_konfirmasi'] = 'Belum Dikonfirmasi';
        $validatedData['status_skripsi'] = 'Belum Lulus';
        if ($skripsi) {
            $validatedData['tanggal_mulai'] = $skripsi->tanggal_mulai;
        } else {
            $validatedData['tanggal_mulai'] = Carbon::now()->format('Y-m-d');
        }

        // dd($validatedData);
        Skripsi::create($validatedData);
        return redirect('/dashboard-mahasiswa/kelola-skripsi')->with('success', 'PKL berhasil diunggah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Skripsi  $skripsi
     * @return \Illuminate\Http\Response
     */
    public function show(Skripsi $skripsi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Skripsi  $skripsi
     * @return \Illuminate\Http\Response
     */
    public function edit(Skripsi $skripsi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Skripsi  $skripsi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skripsi $skripsi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skripsi  $skripsi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skripsi $skripsi)
    {
        //
    }
}
