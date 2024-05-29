<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\SavingFile;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SavingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userID = Auth::id();
        $anggotaID = Anggota::where('id_user', $userID)->first();

        if ($user->hasRole('admin') || $user->hasRole('bendahara') || $user->hasRole('ketua')) {
            $saving = Simpanan::all()->sortByDesc('created_at');
        } else {
            $saving = Simpanan::where('author_id', $anggotaID->id_anggota)->get()->sortByDesc('created_at');
        }
        return view('layouts.data_simpanan', ['datas' => $saving]);
    }

    public function store(Request $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();

            $saving = new Simpanan();
            $fileSaving = new SavingFile();

            // Validasi yang wajib diinputkan pada request payloads
            $validated = $request->validate([
                'nominal' => 'required',
                'tanggal_transfer' => 'required',
                'keterangan' => 'required',
                'upload_bukti' => 'required',
            ]);

            // Get id anggota
            $userID = Auth::id();
            $anggotaID = Anggota::where('id_user', $userID)->first();

            $saving = Simpanan::create([
                'nominal_uang' => $request->input('nominal'),
                'keterangan'=> $request->input('keterangan'),
                'tanggal_transfer'=> $request->input('tanggal_transfer'),
                'author_id' => $anggotaID->id_anggota,
                'author_name' => $anggotaID->nama_anggota,
            ]);

            // Melakukan pengecekan jika inputan memiliki File
            if ($request->hasFile('upload_bukti')) {
                $directory = 'files';
                $fileName = $request->file('upload_bukti');

                // Menyimpan data pada storage local
                $pathFile = Storage::disk('public')->put($directory, $fileName);

                // Menyimpan File pada database File Data Simpanan
                SavingFile::create([
                    'files' => $pathFile,
                    'id_savings' => $saving->id
                ]);
            }

            // Commit the database transaction
            DB::commit();
            
            return redirect()->back()->with('success', 'Berhasil menambahkan Simpanan');
        } catch (\Throwable $th) {
            // An error occurred, rollback the database transaction
            DB::rollback();

            return redirect()->back()->with('error', 'Gagal menambahkan Simpanan');
        }
    }

    public function updatedatasimpanan($id)
    {
        $data = Simpanan::find($id);
        $data->status = 'disimpan';
        $data->save();
    }

    public function delete($id)
    {
        $saving = Simpanan::findOrFail($id);
        $saving->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
