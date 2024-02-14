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

    // public function store(Request $request)
    // {
    //     try {
    //         $loannote = new ReviewCredit();

    //         $validated = $request->validate([
    //             'no_nota' => 'required',
    //             'keterangan_review_pinjaman' => 'required',
    //             'upload_bukti_transfer_review' => 'required',
    //         ]);

    //         $loannote->no_nota = $request->input('no_nota');
    //         $loannote->keterangan = $request->input('keterangan_review_pinjaman');
    //         $loannote->author_id = Auth::id();
    //         $loannote->save();

    //         return redirect()->back()->with('success', 'Pinjaman Ini Diterima');
    //     } catch (\Throwable $th) {
    //         return redirect()->back()->with('error', 'Pinjaman Ini Ditolak');
    //     }
    // }
}
