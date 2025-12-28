<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\KHS;
use App\Models\Pkl;
use App\Models\Dosen;
use App\Models\Skripsi;
use App\Models\Semester;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Departemen\MahasiswaPKLExport;
use App\Exports\Departemen\MahasiswaSkripsiExport;

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
        $semesterLalu = Semester::where('id', '<', $semesterAktif->id)
            ->orderBy('id', 'desc')
            ->first();


        if ($semesterLalu) {
            $rerataMhsSemesterLalu = round(KHS::where('semester_id', $semesterLalu->id)
                ->avg('ip_semester'), 2);
        } else {
            $rerataMhsSemesterLalu = 0;
        }

        $calonWisudaCount = Skripsi::where('status_skripsi', 'Lulus')
            ->where('semester_id', $semesterAktif->id)
            ->count();

        if ($semesterLalu) {
            $calonWisudaBeforeCount = Skripsi::where('status_skripsi', 'Lulus')
                ->where('semester_id', $semesterLalu->id)
                ->count() ?? 0;
        } else {
            $calonWisudaBeforeCount = 0;
        }
        // dd($calonWisudaBeforeCount);
        $calonWisudaDiff =  $calonWisudaCount - $calonWisudaBeforeCount;
        $calonWisudaDiff = sprintf('%+d', $calonWisudaDiff);
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
            'title' => 'Dashboard Departemen',
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
            'calonWisudaBeforeCount' => $calonWisudaBeforeCount,
            'calonWisudaDiff' => $calonWisudaDiff,
            
        ]);
    }

    /**
     * Menampilkan data mahasiswa departemen.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dataMahasiswa()
    {
        $mahasiswas = Mahasiswa::with('pklTerakhir', 'skripsiTerakhir', 'khsTerakhir', 'irsAktif')->get();
        $angkatan = Mahasiswa::select('angkatan')->distinct()->get();
        $dosens = Dosen::get(['kode_wali', 'nama']);


        // dd($mahasiswa->pklTerakhir);
        return view('dashboard-departemen.data-mahasiswa', [
            'title' => 'Data Mahasiswa',
            'mahasiswas' => $mahasiswas,
            'angkatans' => $angkatan,
            'dosens' => $dosens,
        ]);
    }

    /**
     * Menampilkan data mahasiswa yang sedang PKL.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dataMahasiswaPkl()
    {
        // $mahasiswas = Mahasiswa::all()->filter(function ($mahasiswa) {
        //     return $mahasiswa->semester_aktif >= 6;
        // });
        $batasAngkatan = Carbon::now()->year - 21;
        $mahasiswas = Mahasiswa::with('pklTerakhir', 'pkl')
            ->whereHas('pkl')
            // ->where('angkatan', '>=', $batasAngkatan)
            ->orderBy('angkatan', 'desc')
            ->get();

        $dosens = Dosen::get(['kode_wali', 'nama']);
        // dd($mahasiswas);
        $angkatans = Mahasiswa::select('angkatan')->distinct()->pluck('angkatan');

        return view('dashboard-departemen.data-mahasiswa-pkl', [
            'mahasiswas' => $mahasiswas,
            'angkatans' => $angkatans,
            'dosens' => $dosens,
            'title' => 'Data Mahasiswa PKL',
        ]);
    }

    /**
     * Menampilkan data mahasiswa yang sedang skripsi.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dataMahasiswaSkripsi()
    {
        $mahasiswas = Mahasiswa::with('skripsiTerakhir', 'skripsi')->whereHas('skripsi')
            ->get();

        $dosens = Dosen::get(['kode_wali', 'nama']);
        $angkatans = Mahasiswa::select('angkatan')->distinct()->pluck('angkatan');
        return view('dashboard-departemen.data-mahasiswa-skripsi', [
            'title' => 'Data Mahasiswa Skripsi',
            'mahasiswas' => $mahasiswas,
            'angkatans' => $angkatans,
            'dosens' => $dosens,

        ]);
    }

    public function exportPklExcel(Request $request)
    {
        $request->validate([
            'angkatan' => 'nullable|integer',
            'dosen_kode_wali' => 'nullable|string',
            'status_lulus' => 'nullable|string',
        ]);

        $query = Mahasiswa::with('pklTerakhir')->whereHas('pkl');

        $query
            ->when($request->filled('angkatan'), function ($q) use ($request) {
                return $q->where('angkatan', $request->angkatan);
            })
            ->when($request->filled('dosen_kode_wali'), function ($q) use ($request) {
                return $q->where('dosen_kode_wali', $request->dosen_kode_wali);
            })
            ->when($request->filled('status_lulus'), function ($q) use ($request) {
                return $q->whereHas('pklTerakhir', function ($sub) use ($request) {
                    $sub->where('status_lulus', $request->status_lulus);
                });
            });

        $mahasiswas = $query->orderBy('angkatan', 'desc')->get();

        $filters = [
            $request->angkatan,
            $request->dosen_kode_wali,
            $request->status_lulus,
            Carbon::now()->format('Ymd_His')
        ];

        $fileNameSuffix = collect($filters)->filter()->implode('_');

        return Excel::download(
            new MahasiswaPKLExport($mahasiswas),
            "Data_Mahasiswa_PKL_{$fileNameSuffix}.xlsx"
        );
    }


    public function exportSkripsiExcel(Request $request)
    {
        $request->validate([
            'angkatan' => 'nullable|integer',
            'dosen_kode_wali' => 'nullable|string',
            'status_lulus' => 'nullable|string',
        ]);

        $query = Mahasiswa::with('skripsiTerakhir')->whereHas('skripsi');

        $query
            ->when($request->filled('angkatan'), function ($q) use ($request) {
                return $q->where('angkatan', $request->angkatan);
            })
            ->when($request->filled('dosen_kode_wali'), function ($q) use ($request) {
                return $q->where('dosen_kode_wali', $request->dosen_kode_wali);
            })
            ->when($request->filled('status_lulus'), function ($q) use ($request) {
                return $q->whereHas('skripsiTerakhir', function ($sub) use ($request) {
                    $sub->where('status_skripsi', $request->status_lulus);
                });
            });

        $mahasiswas = $query->orderBy('angkatan', 'desc')->get();

        // 3. Penamaan File (Seperti saran sebelumnya)
        $filters = [
            $request->angkatan,
            $request->dosen_kode_wali,
            $request->status_lulus,
            Carbon::now()->format('Ymd_His')
        ];

        $fileNameSuffix = collect($filters)->filter()->implode('_');

        return Excel::download(
            new MahasiswaSkripsiExport($mahasiswas),
            "Data_Mahasiswa_Skripsi_{$fileNameSuffix}.xlsx"
        );
    }
}
