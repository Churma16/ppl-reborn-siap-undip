<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::with('pklTerakhir', 'skripsiTerakhir', 'khsTerakhir', 'irsAktif')->get();
        $angkatan = Mahasiswa::select('angkatan')->distinct()->get();
        $dosens = Dosen::get(['kode_wali', 'nama']);


        // dd($mahasiswa->pklTerakhir);
        return view('dashboard-admin.data-mahasiswa', [
            'mahasiswas' => $mahasiswas,
            'angkatans' => $angkatan,
            'dosens' => $dosens,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'nim' => 'required|numeric|unique:mahasiswas',
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

        return redirect()->back()->with('success', 'Data ' . $validatedData['nama'] . ' berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->update([
            'status_aktif' => 0, // atau 'Undur Diri'
            'tanggal_keluar' => now()
        ]);

        return redirect()->back()->with('success', 'Status mahasiswa diubah menjadi Non-Aktif.');
    }
}
