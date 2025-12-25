<?php

namespace App\Http\Controllers;

use App\Enums\IrsStatusKonfirmasi;
use App\Models\IRS;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        // $status_irs = $irss?->status_konfirmasi ?? IrsStatusKonfirmasi::Belum_Ambil;

        return view('dashboard-mahasiswa.mahasiswa-kelola-irs.index', [
            'title' => 'Isian Rencana Studi (IRS)',
            'mahasiswa' => $mahasiswa,
            'irss' => $irss,
            // 'status_irs' => $status_irs,

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
                'semester_aktif' => '0',
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'file_sks' => 'required|mimes:pdf|max:10000',
            'jumlah_sks' => 'required|numeric|min:1|max:24',
        ]);
        // Mendapatkan semester aktif terakhir
        $semesterAktif = IRS::where('mahasiswa_nim', Auth::user()->nip_nim)->orderBy('semester_aktif', 'desc')->first();
        if ($semesterAktif == null) {
            $semesterAktif = [
                'semester_aktif' => '0',
            ];
        }

        // Mendapatkan periode semester terbaru
        $latestSemester = Semester::latest()->value('id');

        // Validasi data input

        // dd($latestSemester);
        // Mengunggah file SKS
        if ($request->file('file_sks')) {
            $validatedData['file_sks'] = $request->file('file_sks')->store('file-sks');
        }

        // Menambahkan data IRS
        $validatedData['mahasiswa_nim'] = Auth::user()->nip_nim;
        $validatedData['status_konfirmasi'] = 'Belum Dikonfirmasi';
        $validatedData['semester_aktif'] = $semesterAktif['semester_aktif'] + 1;
        $validatedData['semester_id'] = $latestSemester;

        IRS::create($validatedData);

        return redirect('/dashboard-mahasiswa/irs')->with('success', 'IRS berhasil diunggah!');
    }

    /**
     * Menampilkan halaman detail IRS.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(IRS $iRS)
    {
        return view('dashboard-mahasiswa.mahasiswa-kelola-irs.show', [
            'title' => 'Isian Rencana Studi IRS',
        ]);
    }

    /**
     * Menampilkan halaman edit IRS.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(IRS $iRS)
    {
        //
    }

    /**
     * Memperbarui data IRS.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IRS $irs)
    {
        $validatedData = $request->validate([
            'file_sks' => 'required|mimes:pdf|max:10000',
            'jumlah_sks' => 'required|numeric|min:1|max:24',
        ]);

        // Mengunggah file SKS
        if ($request->file('file_sks')) {
            Storage::delete($irs->file_sks);
            $validatedData['file_sks'] = $request->file('file_sks')->store('file-sks');
        }

        // Memperbarui data IRS
        $validatedData['status_konfirmasi'] = 'Belum Dikonfirmasi';
        $irs->update($validatedData);

        return redirect('/dashboard-mahasiswa/irs')->with('success', 'IRS berhasil diajukan ulang!');
    }

    /**
     * Menghapus data IRS.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(IRS $iRS)
    {
        //
    }
}
