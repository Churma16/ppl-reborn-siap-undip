<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mataKuliah = MataKuliah::all();

        return view('dashboard-admin.mata-kuliah.index', [
            'title' => 'Data Mata Kuliah',
            'mataKuliah' => $mataKuliah
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
            'kode' => 'required|unique:mata_kuliahs,kode|max:10',
            'nama' => 'required|max:100',
            'sks' => 'required|integer|min:1|max:6',
            'sifat' => 'required|in:Wajib,Pilihan',
            'semester_ambil' => 'required|integer|min:1|max:8',
        ]);
        // dd($request->all());

        MataKuliah::create($validatedData);
        return redirect()->back()->with('success', 'Data Mata Kuliah berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MataKuliah  $mataKuliah
     * @return \Illuminate\Http\Response
     */
    public function show(MataKuliah $mataKuliah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MataKuliah  $mataKuliah
     * @return \Illuminate\Http\Response
     */
    public function edit(MataKuliah $mataKuliah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MataKuliah  $mataKuliah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MataKuliah $mataKuliah)
    {

        if ($request->kode != $mataKuliah->kode) {
            $uniqueRule = 'unique:mata_kuliahs,kode';
        } else {
            $uniqueRule = '';
        }

        $validatedData = $request->validate([
            'kode' => 'required|' . $uniqueRule . '|max:10',
            'nama' => 'required|max:100',
            'sks' => 'required|integer|min:1|max:6',
            'sifat' => 'required|in:Wajib,Pilihan',
            'semester_ambil' => 'required|integer|min:1|max:8',
        ]);

        $mataKuliah->update($validatedData);
        return redirect()->back()->with('success', 'Data Mata Kuliah berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MataKuliah  $mataKuliah
     * @return \Illuminate\Http\Response
     */
    public function destroy(MataKuliah $mataKuliah)
    {


        $mataKuliah->delete();
        return redirect()->back()->with('success', 'Data Mata Kuliah berhasil dihapus!');
    }
}
