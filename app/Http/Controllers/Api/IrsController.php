<?php

namespace App\Http\Controllers\api;

use App\Enums\IrsStatusKonfirmasi;
use App\Enums\SemesterStatusAktif;
use App\Http\Controllers\Controller;
use App\Http\Resources\IrsResource;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\Semester;
use Illuminate\Http\Request;

class IrsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jumlah_sks' => 'required|numeric|min:1',
            'file_sks' => 'required|mimes:pdf|max:10000',
        ]);

        $validated['semester_aktif'] = KHS::where('mahasiswa_nim', auth()->id())
                ->latest()
                ->value('semester') + 1 ;


        $validated['mahasiswa_nim'] = auth()->id();

        $validated['semester_id'] = Semester::where('is_active', SemesterStatusAktif::AKTIF->value)->value('id');

        $validated['status_konfirmasi'] = IrsStatusKonfirmasi::Belum_Dikonfirmasi->value;

        $validated['jumlah_sks'] = $request->jumlah_sks;

        $file = $request->file('file_sks');
        $fileName = $file->hashName();
        $path = $file->storeAs('public/uploads/users', $fileName);
        $dbPath = str_replace('public/', '', $path);
        $validated['file_sks'] = $dbPath;

        return response()->json([
            'message' =>'Irs Berhasil diunggah',
            'data' => new IrsResource($validated),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(IRS $iRS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IRS $iRS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(IRS $iRS)
    {
        //
    }
}
