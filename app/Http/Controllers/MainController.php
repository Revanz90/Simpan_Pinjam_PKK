<?php

namespace App\Http\Controllers;

use Spatie\FlareClient\View;

class MainController extends Controller
{
    public function index()
    {
        return View('layouts.main');
    }
}
