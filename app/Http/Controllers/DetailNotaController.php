<?php

namespace App\Http\Controllers;

use App\Models\ReviewCredit;
use App\Models\ReviewCreditFile;

class DetailNotaController extends Controller
{
    public function index($id)
    {
        $data = ReviewCredit::find($id);
        $file = ReviewCreditFile::where('review_credit_id', $data->id)->first();
        return view('layouts.detail_nota', ['data' => $data, 'file' => $file]);
    }
}
