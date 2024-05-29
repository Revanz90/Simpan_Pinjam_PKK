<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\CreditFile;
use App\Models\Pinjamans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class CreditController extends Controller
{
    use HasRoles;

    public function index()
    {
        $user = Auth::user();
        $userID = Auth::id();
        $anggotaID = Anggota::where('id_user', $userID)->first();

        if ($user->hasRole('admin') || $user->hasRole('bendahara') || $user->hasRole('ketua')) {
            $credit = Pinjamans::all()->sortByDesc('created_at');
        } else {
            $credit = Pinjamans::where('author_id', $anggotaID->id_anggota)->get()->sortByDesc('created_at');
        }
        return view('layouts.data_pinjaman', ['datas' => $credit]);

    }

    public function store(Request $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            
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

            $userID = Auth::id();
            $anggotaID = Anggota::where('id_user', $userID)->first();

            $credit = Pinjamans::create([
                'nominal_pinjaman' => $request->input('nominal'),
                'tanggal_pinjaman' => $request->input('tanggal_transaksi'),
                'keterangan' => $request->input('keterangan'),
                'author_id' => $anggotaID->id_anggota,
                'author_name' => $anggotaID->nama_anggota,
            ]);

            // Melakukan pengecekan jika inputan memiliki File
            if ($request->hasFile('upload_bukti')) {
                $directory = 'files';
                $fileName = $request->file('upload_bukti');

                // Menyimpan data pada storage local
                $pathFile = Storage::disk('public')->put($directory, $fileName);

                // Menyimpan File pada database File Data Pinjaman
                CreditFile::create([
                    'files' => $pathFile,
                    'id_credits' => $credit->id
                ]);
            }

            // Commit the database transaction
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil menambahkan Pinjaman');
        } catch (\Throwable $th) {
            // An error occurred, rollback the database transaction
            DB::rollback();
            
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
