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
    /**
     * Menampilkan halaman utama dashboard mahasiswa.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Mendapatkan data mahasiswa berdasarkan NIM pengguna yang sedang login
        $mahasiswa = Mahasiswa::where('nim', auth()->user()->nip_nim)->first();

        // Menghitung IPK kumulatif
        $ipKumulatifNotFormatted = number_format(KHS::where('mahasiswa_nim', $mahasiswa->nim)
            ->where('status_konfirmasi', 'Dikonfirmasi')
            ->avg('ip_semester'), 2);
        $ipk = $ipKumulatifNotFormatted;

        // Mendapatkan semester aktif terakhir
        $semesterAktif = IRS::where('mahasiswa_nim', $mahasiswa->nim)
            ->orderBy('semester_aktif', 'desc')
            ->first();
        if ($semesterAktif == null) {
            $semesterAktif = [
                'semester_aktif' => '-'
            ];
        }

        // Menghitung SKS kumulatif
        $sksk = IRS::where('mahasiswa_nim', $mahasiswa->nim)
            ->where('status_konfirmasi', 'Dikonfirmasi')
            ->sum('jumlah_sks');

        return view('dashboard-mahasiswa.index', [
            'title' => 'Dashboard Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'ipk' => $ipk,
            'semesterAktif' => $semesterAktif['semester_aktif'],
            'sksk' => $sksk,
        ]);
    }

    /**
     * Menampilkan halaman edit profil mahasiswa.
     *
     * @return \Illuminate\Contracts\View\View
     */
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

    /**
     * Mengambil data kabupaten berdasarkan kode provinsi.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchKabupaten($id)
    {
        $kabupatens = Kabupaten::where('provinsi_kode_provinsi', $id)->get(['kode_kabupaten', 'nama']);
        return response()->json($kabupatens);
    }

    /**
     * Memperbarui profil mahasiswa.
     *
     * @param Mahasiswa $mahasiswa
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Mahasiswa $mahasiswa, Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'no_hp' => 'required|numeric',
            'email' => 'required|email',
            'alamat' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
        ]);

        // Mengganti nama kolom dalam array $validatedData
        $validatedData['kabupaten_kode_kabupaten'] = $validatedData['kabupaten'];
        unset($validatedData['kabupaten']);

        $validatedData['provinsi_kode_provinsi'] = $validatedData['provinsi'];
        unset($validatedData['provinsi']);

        // Memperbarui data mahasiswa
        Mahasiswa::where('nim', auth()->user()->nip_nim)->update($validatedData);
        return redirect('/dashboard-mahasiswa')->with('success', 'New post has been added!');
    }
}
