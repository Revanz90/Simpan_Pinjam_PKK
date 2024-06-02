<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Angsuran;
use App\Models\InstallmentFile;
use App\Models\Pinjamans;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InstallmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userID = Auth::id();
        $anggotaID = Anggota::where('id_user', $userID)->first();
        
        if ($user->hasRole('admin') || $user->hasRole('bendahara') || $user->hasRole('ketua')) {
            $installment = Angsuran::all()->sortByDesc('created_at');
        } else {
            $installment = Angsuran::where('author_id', $anggotaID->id_anggota)->get()->sortByDesc('created_at');
        }
        return view('layouts.data_angsuran', ['datas' => $installment]);
    }

    public function store_installment(Request $request, $id)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            
            $credit = Pinjamans::find($id);
            $installment = new Angsuran();
            $installmentfile = new InstallmentFile();

            // Validasi yang wajib diinputkan pada request payloads
            $validated = $request->validate([
                'nominal_angsuran' => 'required',
                'tanggal_transfer_angsuran' => 'required',
                'keterangan_angsuran' => 'required',
                'upload_bukti_angsuran' => 'required',
            ]);

            $userID = Auth::id();
            $anggotaID = Anggota::where('id_user', $userID)->first();

            $currentDate = Carbon::parse($request->input('tanggal_transfer_angsuran'));

            if ($currentDate->greaterThan($credit->due_date)) {
                $installment->nominal_angsuran = $request->input('nominal_angsuran');
                $installment->keterangan = $request->input('keterangan_angsuran');
                $installment->tanggal_transfer = $request->input('tanggal_transfer_angsuran');
                $installment->author_id = $anggotaID->id_anggota;
                $installment->author_name = $anggotaID->nama_anggota;
                $installment->credit_id = $id;
                $installment->save();

                // Fungsi untuk mengambil tanggal
                $toDate = Carbon::parse($credit->due_date);
                $fromDate = Carbon::parse($currentDate);

                //Hitung Denda * telat
                $countdayslate = $toDate->diffInDays($fromDate);
                $denda = $credit->penalty * $countdayslate;

                //Hitung nominal angsuran - denda
                $hitung_denda = $request->input('nominal_angsuran') - $denda;

                //Simpan nominal denda
                $installment->nominal_denda = $denda;
                $installment->total_terbayar = $hitung_denda;
                $installment->save();

                //Hitung yang sudah terbayar
                $credit->total_terbayar = $credit->total_terbayar + $hitung_denda;
                $credit->save();

                // Melakukan pengecekan jika inputan memiliki File
                if ($request->hasFile('upload_bukti_angsuran')) {
                    $directory = 'files';
                    $fileName = $request->file('upload_bukti_angsuran');

                    // Menyimpan data pada storage local
                    $pathFile = Storage::disk('public')->put($directory, $fileName);

                    // Menyimpan File pada database File Surat Masuk
                    $installmentfile->files = $pathFile;
                    $installmentfile->id_installments = $installment->id;
                    $installmentfile->save();
                }

            } else {
                $installment->nominal_angsuran = $request->input('nominal_angsuran');
                $installment->tanggal_transfer = $request->input('tanggal_transfer_angsuran');
                $installment->total_terbayar = $request->input('nominal_angsuran');
                $installment->keterangan = $request->input('keterangan_angsuran');
                $installment->author_id = $anggotaID->id_anggota;
                $installment->author_name = $anggotaID->nama_anggota;
                
                $installment->credit_id = $id;
                $installment->save();

                $hutang_terbayar = $credit->total_terbayar + $installment->nominal_pinjaman = $request->input('nominal_angsuran');
                $credit->total_terbayar = $hutang_terbayar;
                $credit->save();

                // Melakukan pengecekan jika inputan memiliki File
                if ($request->hasFile('upload_bukti_angsuran')) {
                    $directory = 'files';
                    $fileName = $request->file('upload_bukti_angsuran');

                    // Menyimpan data pada storage local
                    $pathFile = Storage::disk('public')->put($directory, $fileName);

                    // Menyimpan File pada database File Data Pinjaman
                    $installmentfile->files = $pathFile;
                    $installmentfile->id_installments = $installment->id;
                    $installmentfile->save();
                }
            }
            
            // Commit the database transaction if everything is successful
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil menambahkan Angsuran');
        } catch (\Throwable $th) {
            // An error occurred, rollback the database transaction
            DB::rollback();
            
            return redirect()->back()->with('error', 'Gagal menambahkan Angsuran');
        }
    }

    public function updatedataangsuran($id)
    {
        $data = Angsuran::find($id);
        $data->status = 'disimpan';
        $data->save();
    }

    public function delete($id)
    {
        $installment = Angsuran::findOrFail($id);
        $installment->delete();
        // dd($saving);
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
