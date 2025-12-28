<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\IRS;
use App\Models\PKL;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Skripsi;
use App\Models\Provinsi;
use App\Models\Semester;
use App\Models\Kabupaten;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Enums\IrsStatusKonfirmasi;
use App\Enums\SemesterStatusAktif;

class DashboardAdminController extends Controller
{
    /**
     * The index function returns a view with the title "Dashboard Admin".
     *
     * @return a view called 'dashboard-admin.index' with a title of 'Dashboard Admin'.
     */
    public function index()
    {
        $semesterAktif = Semester::where('is_active', SemesterStatusAktif::AKTIF)->first();
        $semesterAktif->tanggal_mulai = Carbon::parse($semesterAktif->tanggal_mulai)->format('d-M-Y');
        $semesterAktif->tanggal_selesai = Carbon::parse($semesterAktif->tanggal_selesai)->format('d-M-Y');
        $mahasiswaAktif = Mahasiswa::whereRelation('irs', 'semester_id', $semesterAktif->id)->count();

        $mahasiswaNonAktif = Mahasiswa::whereDoesntHave('irs', function ($q) use ($semesterAktif) {
            $q->where('semester_id', $semesterAktif->id);
        })
            ->whereDoesntHave('skripsi', function ($q) {
                $q->where('status_skripsi', 'Lulus');
            })
            ->count();

        $totalDosen = Dosen::count();

        $kolomKosong = ['foto_mahasiswa', 'alamat', 'no_hp', 'provinsi_kode_provinsi', 'kabupaten_kode_kabupaten'];

        $mahasiswaDataTdkLengkap = Mahasiswa::where(function ($q) use ($kolomKosong) {
            foreach ($kolomKosong as $kolom) {
                $q->orWhereNull($kolom)
                    ->orWhere($kolom, '=', '');
            }
        })->get();

        $mahasiswaDataTdkLengkap->transform(function ($mahasiswa) use ($kolomKosong) {
            $listKosong = [];

            foreach ($kolomKosong as $kolom) {
                // Cek apakah NULL atau String Kosong
                if (is_null($mahasiswa->$kolom) || $mahasiswa->$kolom === '') {
                    // Ubah format nama kolom jadi lebih cantik (opsional)
                    // misal: 'no_hp' jadi 'No Hp'
                    $namaCantik = ucwords(str_replace('_', ' ', $kolom));
                    $listKosong[] = $namaCantik;
                }
            }

            // 3. Tambahkan ke atribut baru di object mahasiswa tersebut
            // Hasilnya akan berupa array, misal: ['Alamat', 'No Hp']
            $mahasiswa->data_kosong = $listKosong;
            return $mahasiswa;
        });
        // dd($mahasiswaDataTdkLengkap);
        $mahasiswaDataTdkLengkapCount = $mahasiswaDataTdkLengkap->count();

        $angkatanAktif = Mahasiswa::where(function ($q) {
            $q->whereRelation('skripsi', 'status_skripsi', 'Belum Lulus')
                ->orWhereDoesntHave('skripsi');
        })
            ->distinct()
            ->orderBy('angkatan', 'asc')
            ->pluck('angkatan');

        $belumMengisiIrs = Mahasiswa::whereDoesntHave('irs', function ($q) use ($semesterAktif) {
            $q->where('semester_id', $semesterAktif->id);
        })
            ->pluck('angkatan')
            ->countBy();

        $menungguVerifikasiIrs = Mahasiswa::whereRelation('irs', function ($q) use ($semesterAktif) {
            $q->where('semester_id', $semesterAktif->id)
                ->where('status_konfirmasi', IrsStatusKonfirmasi::Belum_Dikonfirmasi);
        })
            ->pluck('angkatan')
            ->countBy();

        $sudahDikonfirmasiIrs = Mahasiswa::whereRelation('irs', function ($q) use ($semesterAktif) {
            $q->where('semester_id', $semesterAktif->id)
                ->where('status_konfirmasi', IrsStatusKonfirmasi::Dikonfirmasi);
        })
            ->pluck('angkatan')
            ->countBy();

        foreach ($angkatanAktif as $angkatan) {
            if (!isset($belumMengisiIrs[$angkatan])) {
                $belumMengisiIrs[$angkatan] = 0;
            }
            if (!isset($menungguVerifikasiIrs[$angkatan])) {
                $menungguVerifikasiIrs[$angkatan] = 0;
            }
            if (!isset($sudahDikonfirmasiIrs[$angkatan])) {
                $sudahDikonfirmasiIrs[$angkatan] = 0;
            }
        }

        $belumMengisiIrs = $belumMengisiIrs->sortKeys();
        $menungguVerifikasiIrs = $menungguVerifikasiIrs->sortKeys();
        $sudahDikonfirmasiIrs = $sudahDikonfirmasiIrs->sortKeys();


        $statusMahasiswa = ['Aktif', 'Cuti', 'Non-Aktif'];

        $mahasiswaCuti =  Mahasiswa::whereRelation('irs', function ($q) use ($semesterAktif) {
            $q->where('semester_id', $semesterAktif->id)
                ->where('status_mahasiswa', 'Cuti');
        })->count();

        // Combine PKL queries
        $pklLulusSmtAktif = PKL::where('semester_id', $semesterAktif->id)
            ->where('status_lulus', 'Lulus')->count();

        $pklProgress = PKL::where('status_lulus', 'Belum Lulus')->distinct()->count();

        // Combine Skripsi queries
        $skripsiLulusSmtAktif = Skripsi::where('semester_id', $semesterAktif->id)
            ->where('status_skripsi', 'Lulus')->count();

        $skripsiProgress = Skripsi::where('status_skripsi', 'Belum Lulus')->distinct()->count();



        $statusPklCount = [
            'lulus' => $pklLulusSmtAktif,
            'progress' => $pklProgress
        ];

        $statusSkripsiCount = [
            'lulus' => $skripsiLulusSmtAktif,
            'progress' => $skripsiProgress
        ];

        return view('dashboard-admin.index', [
            'title' => 'Dashboard Admin',
            'semesterAktif' => $semesterAktif,
            'mahasiswaAktif' => $mahasiswaAktif,
            'mahasiswaNonAktif' => $mahasiswaNonAktif,
            'mahasiswaCuti' => $mahasiswaCuti,
            'totalDosen' => $totalDosen,
            'mahasiswaDataTdkLengkaps' => $mahasiswaDataTdkLengkap,
            'mahasiswaDataTdkLengkapCount' => $mahasiswaDataTdkLengkapCount,
            'angkatanAktif' => $angkatanAktif,
            'belumMengisiIrs' => $belumMengisiIrs,
            'menungguVerifikasiIrs' => $menungguVerifikasiIrs,
            'sudahDikonfirmasiIrs' => $sudahDikonfirmasiIrs,
            'statusMahasiswa' => $statusMahasiswa,
            'statusPklCount' => $statusPklCount,
            'statusSkripsiCount' => $statusSkripsiCount

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
        // dd($dosens);
        return view('dashboard-admin.tambah-mahasiswa-baru', [
            'title' => 'Tambah Mahasiswa Baru',
            'provinsis' => $provinsis,
            'kabupaten' => $kabupaten,
            'dosens' => $dosens,
        ]);
    }

    /**
     * The function creates a new Mahasiswa (student) record and associated user account in a database.
     *
     * @param Request request The  parameter is an instance of the Request class, which represents
     * an HTTP request. It contains all the data and information about the incoming request, such as the
     * request method, headers, and request payload.
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
        $dosens = Dosen::get(['kode_wali', 'nama']);
        // dd($dosens);
        return view('dashboard-admin.data-mahasiswa', [
            'mahasiswas' => $mahasiswa,
            'angkatans' => $angkatan,
            'dosens' => $dosens,
        ]);
    }

    public function createSemester(Request $request) {}
}
