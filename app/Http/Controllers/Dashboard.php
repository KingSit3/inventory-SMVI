<?php

namespace App\Http\Controllers;

use PDF;

class Dashboard extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}
