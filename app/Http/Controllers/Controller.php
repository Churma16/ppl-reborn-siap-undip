<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function getTableData(Request $request)
    {
        $angkatan = $request->input('angkatan');

        $mahasiswas = Mahasiswa::where('angkatan', $angkatan)->get();

        $view = view('your.table.view', compact('mahasiswas'))->render();

        return response()->json($view);
    }
}
