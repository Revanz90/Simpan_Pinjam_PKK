<?php

namespace App\Http\Controllers;

use App\Models\SavingFile;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DetailDataSimpananController extends Controller
{
    public function index($id)
    {
        $data = Simpanan::find($id);
        $file = SavingFile::where('id_savings', $data->id)->first();
        return view('layouts.detail_datasimpanan', ['data' => $data, 'file' => $file]);
    }

    public function indexubah($id)
    {
        $data = Simpanan::find($id);
        $file = SavingFile::where('id_savings', $data->id)->first();
        return view('layouts.edit_data_simpanan', ['data' => $data, 'file' => $file]);
    }

    public function updatesimpanan(Request $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();

            $validated = $request->validate([
                'nominal_simpanan' => 'required',
                'tanggal_transfer' => 'required',
                'keterangan' => 'required',
                'upload_bukti' => 'required'
            ]);

            $simpanan = Simpanan::findOrFail($request->simpanan_id);
            $simpananfile = SavingFile::findOrFail($request->simpanan_file_id);

            $simpanan->nominal_uang = $request->nominal_simpanan;
            $simpanan->keterangan = $request->keterangan;
            $simpanan->tanggal_transfer = $request->tanggal_transfer;
            $simpanan->save();

            // Melakukan pengecekan jika inputan memiliki File
            if ($request->hasFile('upload_bukti')) {
                $directory = 'files';
                $fileName = $request->file('upload_bukti');

                // Menyimpan data pada storage local
                $pathFile = Storage::disk('public')->put($directory, $fileName);

                // Menyimpan File pada database File Data Simpanan
                $simpananfile->files = $pathFile;
                $simpananfile->id_savings = $simpanan->id;
                $simpananfile->save();
            }

            // Commit the database transaction if everything is successful
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil merubah data simpanan');
        } catch (\Throwable $th) {
            dd($th);
            // An error occurred, rollback the database transaction
            DB::rollback();
            
            return redirect()->back()->with('error', 'Gagal merubah data simpanan');
        }
    }
}
