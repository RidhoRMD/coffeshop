<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaristaController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.barista.index');
    }
}