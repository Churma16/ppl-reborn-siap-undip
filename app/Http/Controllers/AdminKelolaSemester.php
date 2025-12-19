<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminKelolaSemester extends Controller
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

        return view('dashboard-admin.kelola-semester.index', [
            'title' => 'Data Semester',
            'semesters' => $semesters,
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
        $tanggal_mulai = Carbon::parse($request->input('tanggal_mulai'));
        $bulan_mulai = Carbon::parse($tanggal_mulai)->month;
        $tahun_mulai = Carbon::parse($tanggal_mulai)->year;

        if ($bulan_mulai >= 8 && $bulan_mulai <= 12) {
            $kode_semester = $tahun_mulai.'/'.$tahun_mulai + 1 .'1';
        } else {
            $kode_semester = $tahun_mulai - 1 .'/'.$tahun_mulai.'2';
        }

        $validatedData = $request->validate([
            'nama_semester' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'status_semester' => 'required',
        ]);

        $validatedData['kode_semester'] = $kode_semester;

        Semester::create($validatedData);

        return redirect('/dashboard-admin')->with('success', 'New semester has been added!');
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
        Semester::destroy($semester->id);

        return redirect('/dashboard-admin/semester')->with('success', 'Semester has been deleted!');
    }
}
