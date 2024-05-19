<?php

namespace App\Http\Controllers;

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
        if ($user->hasRole('admin') || $user->hasRole('bendahara') || $user->hasRole('ketua')) {
            $saving = Simpanan::all()->sortByDesc('created_at');
        } else {
            $saving = Simpanan::where('author_id', $user->id)->get()->sortByDesc('created_at');
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

            $saving->nominal_uang = $request->input('nominal');
            $saving->tanggal_transfer = $request->input('tanggal_transfer');
            $saving->keterangan = $request->input('keterangan');
            $saving->author_id = Auth::id();
            $saving->author_name = Auth::user()->name;
            $saving->save();

            // Melakukan pengecekan jika inputan memiliki File
            if ($request->hasFile('upload_bukti')) {
                $directory = 'files';
                $fileName = $request->file('upload_bukti');

                // Menyimpan data pada storage local
                $pathFile = Storage::disk('public')->put($directory, $fileName);

                // Menyimpan File pada database File Data Simpanan
                $fileSaving->files = $pathFile;
                $fileSaving->id_savings = $saving->id;
                $fileSaving->save();
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
