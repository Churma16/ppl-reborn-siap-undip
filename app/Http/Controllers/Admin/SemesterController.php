<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;

use App\Models\Skripsi;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Enums\SemesterStatusAktif;
use App\Http\Controllers\Controller;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semesters = Semester::with('irs')->get();

        // dd($semesters);
        // $statusSemesterAktif = SemesterStatusAktif::cases();

        // dd($statusSemesterAktif);
        return view('dashboard-admin.kelola-semester.index', [
            'title' => 'Data Semester',
            'semesters' => $semesters,
            // 'statusSemesterAktif' => $statusSemesterAktif,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard-admin.kelola-semester.create', [
            'title' => 'Tambah Semester Baru',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'nama_semester' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        // dd($validatedData);

        $tanggal_mulai = Carbon::parse($request->input('tanggal_mulai'));
        $bulan_mulai = Carbon::parse($tanggal_mulai)->month;
        $tahun_mulai = Carbon::parse($tanggal_mulai)->year;
        if ($bulan_mulai >= 8 && $bulan_mulai <= 12) {
            $kode_semester = $tahun_mulai . '/' . $tahun_mulai + 1 . '1';
        } else {
            $kode_semester = $tahun_mulai - 1 . '/' . $tahun_mulai . '2';
        }


        $validatedData['kode_semester'] = $kode_semester;

        Semester::create($validatedData);

        return redirect()->back()->with('success', 'Data Semester berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Semester $semester)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Semester $semester)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Semester $semester)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Semester $semester)
    {
        $relatedTables = [
            'KHS'     => KHS::class,
            'IRS'     => IRS::class,
            'Skripsi' => Skripsi::class,
            'PKL'     => PKL::class
        ];

        // Loop through them automatically
        foreach ($relatedTables as $name => $model) {
            if ($model::where('semester_id', $semester->id)->exists()) {
                return redirect('/dashboard-admin/semester')
                    ->with('error', "Semester cannot be deleted because it has related $name records!");
            }
        }

        // If no relations found, proceed with delete...
        $semester->delete();

        return redirect('/dashboard-admin/semester')->with('success', 'Semester has been deleted!');
    }
}
