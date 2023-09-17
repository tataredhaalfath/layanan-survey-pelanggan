<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SurveyDetailController extends Controller
{
    public function index()
    {
        $title = "Detail Survey Pelanggan";

        return view('pages.dashboard.surveyDetail', compact('title'));
    }
}
