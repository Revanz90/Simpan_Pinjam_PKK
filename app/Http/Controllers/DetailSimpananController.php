<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailSimpananController extends Controller
{
    public function index()
    {
        return view('layouts.detail_simpanan');
    }
}
