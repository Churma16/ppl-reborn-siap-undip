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
        $validatedData = $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:mahasiswas,email,' . $mahasiswa->nim . ',nim',
            'angkatan' => 'required|numeric',
            'jalur_masuk' => 'required',
            'dosen_kode_wali' => 'required',
        ]);

        $mahasiswa->update($validatedData);

        return redirect()->back()->with('success', 'Data mahasiswa ' . $mahasiswa->nama . ' berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        // Update KHS status to 'Tidak Aktif'
        if ($mahasiswa->khs()->count() === 0) {
            $mahasiswa->khs()->create([
                'semester' => 1,
                'status_mahasiswa' => 'Tidak Aktif',
                'ip_semester' => 0.00,
                'ip_kumulatif' => 0.00,
                'sks_kumulatif' => 0,
                'file_khs' => '',
                'status_konfirmasi' => 'Dikonfirmasi'
            ]);
        } else {
            $mahasiswa->khs()->update(['status_mahasiswa' => 'Tidak Aktif']);
        }

        // Update IRS status to 'Tidak Aktif'
        if ($mahasiswa->irs()->count() === 0) {
            $semesterAktif = \App\Models\Semester::where('is_active', \App\Enums\SemesterStatusAktif::AKTIF)->first();
            $mahasiswa->irs()->create([
                'semester_id' => $semesterAktif ? $semesterAktif->id : 1,
                'semester_aktif' => 1,
                'status_mahasiswa' => 'Tidak Aktif',
                'jumlah_sks' => 0,
                'file_irs' => '',
                'status_konfirmasi' => \App\Enums\KhsStatusKonfirmasi::Dikonfirmasi->value
            ]);
        } else {
            $mahasiswa->irs()->update(['status_mahasiswa' => 'Tidak Aktif']);
        }

        return redirect()->back()->with('success', 'Status mahasiswa ' . $mahasiswa->nama . ' berhasil diubah menjadi Tidak Aktif.');
    }
}
