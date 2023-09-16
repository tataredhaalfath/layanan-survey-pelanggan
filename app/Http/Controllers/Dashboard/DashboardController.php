<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "DASHBOARD LAYANAN SURVEY PELANGGAN";

        return view('pages.dashboard.index', compact('title'));
    }
}
