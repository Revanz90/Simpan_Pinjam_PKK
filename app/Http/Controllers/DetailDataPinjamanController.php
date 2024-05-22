<?php

namespace App\Http\Controllers;

use App\Models\CreditFile;
use App\Models\Pinjamans;
use App\Models\ReviewCredit;
use App\Models\ReviewCreditFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DetailDataPinjamanController extends Controller
{

    public function index($id)
    {
        $data = Pinjamans::find($id);
        $file = CreditFile::where('id_credits', $data->id)->first();

        $getTotalTerbayar = $data->total_terbayar;
        $getTotalPinjaman = $data->nominal_pinjaman;

        if ($getTotalTerbayar == $getTotalPinjaman) {
            $data->status_credit = 'lunas';
            $data->save();
        }

        return view('layouts.detail_datapinjaman', ['data' => $data, 'file' => $file]);
    }

    public function store_review(Request $request, $id)
    {
        $buttonValue = $request->input('c');

        if ($buttonValue == 'diterima') {
            try {
                // Begin a database transaction
                DB::beginTransaction();

                $credit = Pinjamans::find($id);
                $reviewcredit = new ReviewCredit();
                $reviewcreditfile = new ReviewCreditFile();

                $validated = $request->validate([
                    // 'no_nota' => 'required',
                    // 'keterangan_review_pinajaman' => 'required',
                    'upload_bukti_transfer_review' => 'required',
                ]);

                $credit->status_credit = 'aktif';
                $credit->status_ketua = 'diterima';
                $credit->loan_interest = 0.05;
                $credit->penalty = 5000;
                $credit->nominal_pinjaman = $credit->nominal_pinjaman + ($credit->nominal_pinjaman * $credit->loan_interest);
                // Hitung total pembayaran setelah bunga ditambahkan
                $total_pembayaran = $credit->nominal_pinjaman;
                // Hitung jumlah cicilan per bulan
                $jumlah_cicilan_per_bulan = $total_pembayaran / 6;
                $credit->jumlah_cicilan_per_bulan = $jumlah_cicilan_per_bulan;
                $credit->save();

                $reviewcredit->no_nota = 'R01';
                $reviewcredit->keterangan = 'Rosa Request';
                $reviewcredit->credit_id = $id;
                $reviewcredit->author_id = Auth::id();
                $reviewcredit->save();

                if ($request->hasFile('upload_bukti_transfer_review')) {
                    $fileName = $request->upload_bukti_transfer_review->getClientOriginalName();

                    // Menyimpan data pada storage local
                    Storage::putFileAs('public/files', $request->upload_bukti_transfer_review, $fileName);
                    // Menyimpan File pada database File Data Pinjaman
                    $reviewcreditfile->files = $fileName;
                    $reviewcreditfile->review_credit_id = $reviewcredit->id;
                    $reviewcreditfile->save();
                }

                // Commit the database transaction if everything is successful
                DB::commit();

                return redirect()->back()->with('success', 'Pinjaman Ini Diterima');
            } catch (\Throwable $th) {
                // An error occurred, rollback the database transaction
                DB::rollback();

                return redirect()->back()->with('error', 'Pinjaman Ini Ditolak');
            }
        }

        if ($buttonValue == 'ditolak') {
            try {
                // Begin a database transaction
                DB::beginTransaction();

                $credit = Pinjamans::find($id);
                $reviewcredit = new ReviewCredit();
                $reviewcreditfile = new ReviewCreditFile();

                $validated = $request->validate([
                    // 'no_nota' => 'required',
                    // 'keterangan_review_pinajaman' => 'required',
                    'upload_bukti_transfer_review' => 'required',
                ]);

                $credit->status_credit = 'ditolak';
                $credit->status_ketua = 'ditolak';
                $credit->loan_interest = 0;
                $credit->penalty = 0;
                $credit->save();

                $reviewcredit->no_nota = 'R01';
                $reviewcredit->keterangan = 'Rosa Request';
                $reviewcredit->credit_id = $id;
                $reviewcredit->author_id = Auth::id();
                $reviewcredit->save();

                if ($request->hasFile('upload_bukti_transfer_review')) {
                    $fileName = $request->upload_bukti_transfer_review->getClientOriginalName();

                    // Menyimpan data pada storage local
                    Storage::putFileAs('public/files', $request->upload_bukti_transfer_review, $fileName);
                    // Menyimpan File pada database File Data Pinjaman
                    $reviewcreditfile->files = $fileName;
                    $reviewcreditfile->review_credit_id = $reviewcredit->id;
                    $reviewcreditfile->save();
                }

                // Commit the database transaction if everything is successful
                DB::commit();

                return redirect()->back()->with('error', 'Pinjaman ini Ditolak');
            } catch (\Throwable $th) {
                // An error occurred, rollback the database transaction
                DB::rollback();

                return redirect()->back()->with('error', 'Pinjaman ini Ditolak');
            }
        }

    }

    public function ubahpinjamindex($id)
    {
        $credit = Pinjamans::find($id);
        $creditfile = CreditFile::where('id_credits', $credit->id)->first();
        return view('layouts.edit_data_pinjaman', ['data' => $credit, 'creditfile' => $creditfile]); 
    }

    public function updatepinjaman(Request $request){
        try {
            // Begin a database transaction
            DB::beginTransaction();

            $validated = $request->validate([
                'nominal_pinjaman' => 'required',
                'tanggal_pinjaman' => 'required',
                'keterangan' => 'required',
                'upload_bukti' => 'required',
            ]);

            $pinjaman = Pinjamans::findOrFail($request->pinjaman_id);
            $filepinjaman = CreditFile::findOrFail($request->filepinjaman_id);

            $pinjaman->nominal_pinjaman = $request->input('nominal_pinjaman');
            $pinjaman->tanggal_pinjaman = $request->input('tanggal_pinjaman');
            $pinjaman->keterangan = $request->input('keterangan');
            $pinjaman->save();

            // Melakukan pengecekan jika inputan memiliki File
            if ($request->hasFile('upload_bukti')) {
                $directory = 'files';
                $fileName = $request->file('upload_bukti');

                // Menyimpan data pada storage local
                $pathFile = Storage::disk('public')->put($directory, $fileName);

                // Menyimpan File pada database File Data Pinjaman
                $filepinjaman->files = $pathFile;
                $filepinjaman->id_credits = $pinjaman->id;
                $filepinjaman->save();
            }

            // Commit the database transaction if everything is successful
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil merubah data simpanan');
        } catch (\Throwable $th) {
            // An error occurred, rollback the database transaction
            DB::rollback();
            
            return redirect()->back()->with('error', 'Gagal merubah data simpanan');
        }
    }
}
