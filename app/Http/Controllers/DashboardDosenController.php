<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;

class DashboardDosenController extends Controller
{
    public function index(Dosen $dosen)
    {

        return view('dashboard-dosen.index', [
            'title' => 'Dashboard Dosen',
        ]);
    }
}
