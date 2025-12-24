<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BioController extends Controller
{
    public function index()
    {
        // Nanti kita ambil data user dari database di sini
        return view('bio.index');
    }
}
