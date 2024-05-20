<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\InstallmentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DetailDataAngsuranController extends Controller
{
    public function index($id)
    {
        $data = Angsuran::find($id);
        $file = InstallmentFile::where('id_installments', $data->id)->first();
        return view('layouts.detail_dataangsuran', ['data' => $data, 'file' => $file]);
    }

    public function indexUbahAngsuran($id)
    {
        $data = Angsuran::find($id);
        $file = InstallmentFile::where('id_installments', $data->id)->first();
        return view('layouts.edit_data_angsuran', ['data' => $data, 'file' => $file]);
    }

    public function updateAngsuran(Request $request) 
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();

            $validated = $request->validate([
                'nominal_angsuran' => 'required',
                'tanggal_transfer' => 'required',
                'keterangan' => 'required',
                'upload_bukti' => 'required'
            ]);

            $angsuran = Angsuran::findOrFail($request->angsuran_id);
            $angsuranfile = InstallmentFile::findOrFail($request->angsuran_file_id);

            $angsuran->nominal_angsuran = $request->nominal_angsuran;
            $angsuran->keterangan = $request->keterangan;
            $angsuran->tanggal_transfer = $request->tanggal_transfer;
            $angsuran->save();

            // Melakukan pengecekan jika inputan memiliki File
            if ($request->hasFile('upload_bukti')) {
                $directory = 'files';
                $fileName = $request->file('upload_bukti');

                // Menyimpan data pada storage local
                $pathFile = Storage::disk('public')->put($directory, $fileName);

                // Menyimpan File pada database File Data Angsuran
                $angsuranfile->files = $pathFile;
                $angsuranfile->id_installments = $angsuran->id;
                $angsuranfile->save();
            }

            // Commit the database transaction if everything is successful
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil merubah data angsuran');
        } catch (\Throwable $th) {
            // An error occurred, rollback the database transaction
            DB::rollback();
            
            return redirect()->back()->with('error', 'Gagal merubah data angsuran');
        }
    }
}
