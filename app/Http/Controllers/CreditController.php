<?php

namespace App\Http\Controllers;

use App\Models\CreditFile;
use App\Models\Pinjamans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class CreditController extends Controller
{
    use HasRoles;

    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('admin') || $user->hasRole('bendahara')) {
            $credit = Pinjamans::all()->sortByDesc('created_at');
        } else {
            $credit = Pinjamans::where('author_id', $user->id)->get()->sortByDesc('created_at');
        }
        return view('layouts.data_pinjaman', ['datas' => $credit]);

    }

    public function store(Request $request)
    {
        try {
            // Cek apakah pengguna telah memiliki pinjaman yang belum lunas
            $existingLoan = Pinjamans::where('author_id', Auth::id())->where('status_credit', '!=', 'lunas')->first();
            if ($existingLoan) {
                return redirect()->back()->with('error', 'Anda memiliki pinjaman yang belum lunas, tolong lunasi pinjaman sebelumnya untuk melakukan pinjaman baru!');
            }

            $credit = new Pinjamans();
            $fileCredit = new CreditFile();

            $validated = $request->validate([
                'nominal' => 'required',
                'tanggal_transaksi' => 'required',
                'keterangan' => 'required',
                'upload_bukti' => 'required',
            ]);

            $credit->nominal_pinjaman = $request->input('nominal');
            $credit->tanggal_pinjaman = $request->input('tanggal_transaksi');
            $credit->keterangan = $request->input('keterangan');
            $credit->author_id = Auth::id();
            $credit->author_name = Auth::user()->name;
            $credit->save();

            // Melakukan pengecekan jika inputan memiliki File
            if ($request->hasFile('upload_bukti')) {
                $fileName = $request->upload_bukti->getClientOriginalName();

                // Menyimpan data pada storage local
                Storage::putFileAs('public/files', $request->upload_bukti, $fileName);
                // Menyimpan File pada database File Data Pinjaman
                $fileCredit->files = $fileName;
                $fileCredit->id_credits = $credit->id;
                $fileCredit->save();
            }

            return redirect()->back()->with('success', 'Berhasil menambahkan Pinjaman');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menambahkan Pinjaman');
        }
    }

    public function delete($id)
    {
        $credit = Pinjamans::findOrFail($id);
        $credit->delete();
        // dd($saving);
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
