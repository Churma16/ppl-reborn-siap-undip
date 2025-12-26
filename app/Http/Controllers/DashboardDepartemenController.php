<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\KHS;
use App\Models\Pkl;
use App\Models\Semester;
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

        $semesterAktif = Semester::semesterAktif()->first();
        $rerataMhsSemesterLalu = round(KHS::where('semester_id',  $semesterAktif->id)
            ->avg('ip_semester'), 2);

        $calonWisudaCount = Skripsi::where('status_skripsi', 'Lulus')
            ->where('semester_id', $semesterAktif->id)
            ->count();
        // dd($calonWisudaCount);

        $mhsKritis = Mahasiswa::whereRelation('irs', 'status_mahasiswa', 'Aktif')
            ->whereHas('khsTerakhir', function ($q) {
                $q->where('semester', '>', 2)
                    ->where('ip_kumulatif', '<', 2.00);
            })
            ->count();

        $listMhsKritis = Mahasiswa::whereRelation('irs', 'status_mahasiswa', 'Aktif')
            ->whereHas(
                'khsTerakhir',
                fn($q) =>
                $q->where('semester', '>', 2)
                    ->where('ip_kumulatif', '<', 2.00)
            )
            ->with('khsTerakhir')
            ->limit(15)
            ->get();

        $listMhsKritis = $listMhsKritis->sortBy('khsTerakhir.ip_kumulatif');
        // dd($listMhsKritis);
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
        // Combine PKL queries
        $pklLulusSmtAktif = PKL::where('semester_id', $semesterAktif->id)
            ->where('status_lulus', 'Lulus')->count();

        $pklProgress = PKL::where('status_lulus', 'Belum Lulus')->distinct()->count();
        $pklBelumAmbil = Mahasiswa::whereHas(
            'khsTerakhir',
            fn($q) =>
            $q->where('sks_kumulatif', '>=', 105)
        )
            ->whereDoesntHave('pkl')
            ->count();
        // Combine Skripsi queries
        $skripsiLulusSmtAktif = Skripsi::where('semester_id', $semesterAktif->id)
            ->where('status_skripsi', 'Lulus')
            ->count();

        $skripsiProgress = Skripsi::where('status_skripsi', 'Belum Lulus')->distinct()->count();

        $skripsiBelumAmbil = Mahasiswa::whereHas(
            'khsTerakhir',
            fn($q) =>
            $q->where('sks_kumulatif', '>=', 144)
        )
            ->whereDoesntHave('skripsi')
            ->count();

        // dd($skripsiBelumAmbil);
        $statusPklCount = [
            'lulus' => $pklLulusSmtAktif,
            'progress' => $pklProgress,
            'belum_ambil' => $pklBelumAmbil,
        ];

        $statusSkripsiCount = [
            'lulus' => $skripsiLulusSmtAktif,
            'progress' => $skripsiProgress,
            'belum_ambil' => $skripsiBelumAmbil,
        ];

        $bebanDoswal = Mahasiswa::with('dosen:kode_wali,nama')
            ->whereRelation('irs', function ($q) use ($semesterAktif) {
                $q->where('semester_id', $semesterAktif->id)
                    ->where('status_mahasiswa', 'Aktif');
            })
            ->get()
            ->pluck('dosen.nama')
            ->countBy();

        $bebanDoswal = $bebanDoswal->sortDesc();

        $totalMahasiswaBlmLulus = Mahasiswa::whereDoesntHave(
            'skripsi',
            fn($q) =>
            $q->where('status_skripsi', 'Lulus')
        )
            ->count();

        $totalDosen = Dosen::count();

        if ($totalDosen > 0) {
            $rasio = round($jumlahMhsAktif / $totalDosen,);
            $rasioDosenMahasiswa = "1 : " . $rasio;
        } else {
            $rasioDosenMahasiswa = "N/A";
        }

        $rasioColor = $rasio > 30 ? 'text-danger' : 'text-success';
        // dd($bebanDoswal->keys());
        return view('dashboard-departemen.index', [
            'mahasiswa' => $mahasiswa,
            'dosen' => $dosen,
            'pkl' => $pkl,
            'skripsi' => $skripsi,
            'jumlahMhsAktif' => $jumlahMhsAktif,
            'rerataMhsSemesterLalu' => $rerataMhsSemesterLalu,
            'calonWisudaCount' => $calonWisudaCount,
            'mhsKritis' => $mhsKritis,
            'listMhsKritis' => $listMhsKritis,
            'statusPklCount' => $statusPklCount,
            'statusSkripsiCount' => $statusSkripsiCount,
            'bebanDoswal' => $bebanDoswal,
            // 'totalMahasiswaBlmLulus' => $totalMahasiswaBlmLulus,
            // 'totalDosen' => $totalDosen,
            'rasioDosenMahasiswa' => $rasioDosenMahasiswa,
            'rasioColor' => $rasioColor,
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
