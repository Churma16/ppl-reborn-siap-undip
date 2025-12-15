<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Provinsi;
use App\Models\Semester;
use App\Models\Kabupaten;
use Carbon\Carbon;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    /**
     * The index function returns a view with the title "Dashboard Admin".
     *
     * @return a view called 'dashboard-admin.index' with a title of 'Dashboard Admin'.
     */
    public function index()
    {

        return view('dashboard-admin.index', [
            'title' => 'Dashboard Admin'
        ]);
    }

    /**
     * The function `tambahMahasiswaBaru()` returns a view with data for adding a new student, including a
     * title, a list of provinces, a list of districts, and a list of professors.
     *
     * @return a view called 'dashboard-admin.tambah-mahasiswa-baru' with the following data:
     */
    public function tambahMahasiswaBaru()
    {
        $provinsis = Provinsi::all();
        $kabupaten = Kabupaten::all();
        $dosens = Dosen::all();

        return view('dashboard-admin.tambah-mahasiswa-baru', [
            'title' => 'Tambah Mahasiswa Baru',
            'provinsis' => $provinsis,
            'kabupaten' => $kabupaten,
            'dosens' => $dosens
        ]);
    }

    /**
     * The function creates a new Mahasiswa (student) record and associated user account in a database.
    *
    * @param Request request The  parameter is an instance of the Request class, which represents
     * an HTTP request. It contains all the data and information about the incoming request, such as the
     * request method, headers, and request payload.
     *
     * @return a redirect response to the '/dashboard-admin' route with a success flash message.
     */
    public function createMahasiswa(Request $request)
    {

        $validatedData = $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas',
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

        return redirect('/dashboard-admin')->with('success', 'New post has been added!');
    }

    /**
     * The function "dataMahasiswa" retrieves data from the "Mahasiswa" and "Dosen" models and passes them
     * to the "data-mahasiswa" view.
     *
     * @return a view called 'dashboard-admin.data-mahasiswa' with three variables: 'mahasiswas',
     * 'angkatans', and 'dosens'.
    */
    public function dataMahasiswa()
    {
        $mahasiswa = Mahasiswa::all();
        $angkatan = Mahasiswa::select('angkatan')->distinct()->get();
        $dosens = Dosen::get('kode_wali', 'nama');
        return view('dashboard-admin.data-mahasiswa', [
            'mahasiswas' => $mahasiswa,
            'angkatans' => $angkatan,
            'dosens' => $dosens,
        ]);
    }


    public function createSemester(Request $request)
    {

    }
}

