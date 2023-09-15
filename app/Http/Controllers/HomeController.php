<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = "ISURVERY";

        return view('pages.home', compact(['title']));
    }
}
