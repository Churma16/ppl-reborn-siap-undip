<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Pkl;
use App\Models\Skripsi;

use Illuminate\Http\Request;

class DashboardDepartemenController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard departemen.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $mahasiswa = new Mahasiswa();
        $dosen = new Dosen();
        $pkl = new Pkl();
        $skripsi = new Skripsi();

        // $mahasiswas = Mahasiswa::all();


        // $statusAktif = [];
        // foreach ($mahasiswas as $m) {
        //     $statusAktif[] = $m->getStatusAktifAttribute();
        // }

        // $jumlahMhsAktif = 0;
        // foreach ($statusAktif as $s) {
        //     if ($s == 'Aktif') {
        //         $jumlahMhsAktif++;
        //     }
        // }
        
        // Retrieve all Mahasiswa records
        $mahasiswas = Mahasiswa::all();

        // Filter the collection to include only Mahasiswa with status 'Aktif'
        $filteredMahasiswas = $mahasiswas->filter(function ($m) {
            return $m->getStatusAktifAttribute() === 'Aktif';
        });

        // Count the number of Mahasiswa with status 'Aktif'
        $jumlahMhsAktif = $filteredMahasiswas->count();


        return view('dashboard-departemen.index', [
            'mahasiswa' => $mahasiswa,
            'dosen' => $dosen,
            'pkl' => $pkl,
            'skripsi' => $skripsi,
            'jumlahMhsAktif' => $jumlahMhsAktif,
        ]);
    }

    /**
     * Menampilkan data mahasiswa departemen.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dataMahasiswa()
    {
        $mahasiswa = Mahasiswa::all();
        $angkatan = Mahasiswa::select('angkatan')->distinct()->get();

        return view('dashboard-departemen.data-mahasiswa', [
            'mahasiswas' => $mahasiswa,
            'angkatans' => $angkatan,
        ]);
    }

    /**
     * Menampilkan data mahasiswa yang sedang PKL.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dataMahasiswaPkl()
    {
        $mahasiswas = Mahasiswa::all()->filter(function ($mahasiswa) {
            return $mahasiswa->semester_aktif >= 6;
        });

        $angkatan = Mahasiswa::select('angkatan')->distinct()->get();

        return view('dashboard-departemen.data-mahasiswa-pkl', [
            'mahasiswas' => $mahasiswas,
            'angkatans' => $angkatan,
        ]);
    }

    /**
     * Menampilkan data mahasiswa yang sedang skripsi.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dataMahasiswaSkripsi()
    {
        $mahasiswas = Mahasiswa::all()->filter(function ($mahasiswa) {
            return $mahasiswa->semester_aktif >= 7;
        });

        $angkatan = Mahasiswa::select('angkatan')->distinct()->get();

        return view('dashboard-departemen.data-mahasiswa-skripsi', [
            'mahasiswas' => $mahasiswas,
            'angkatans' => $angkatan,
        ]);
    }
}
