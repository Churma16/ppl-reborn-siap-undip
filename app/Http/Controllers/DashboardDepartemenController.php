<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardDepartemenController extends Controller
{
    public function index()
    {
        
        return view('dashboard-departemen.index');
    }
}
