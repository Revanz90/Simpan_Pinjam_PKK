<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataAnggotaController extends Controller
{
    public function index()
    {
        $member = Anggota::all()->sortByDesc('');
        return view('layouts.data_anggota', ['datas' => $member]);
    }

    public function store(Request $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();

            $validated = $request->validate([
                'nama_anggota' => 'required',
                'id_anggota' => 'required',
                'alamat_anggota' => 'required',
                'email_anggota' => 'required',
                'password_anggota' => 'required',
                'jenis_kelamin' => 'required',
            ]);

            // Create the user
            $user = User::create([
                'name' => $request->nama_anggota,
                'email' => $request->email_anggota,
                'password' => bcrypt($request->password_anggota),
            ]);

            // Sync roles for the user
            $user->assignRole('anggota');
            
            // Anggota::create([
            //     'nama_anggota' => $request->nama_anggota,
            //     'id_anggota' => $request->id_anggota,
            //     'alamat_anggota' => $request->alamat_anggota,
            //     'jenis_kelamin' => $request->jenis_kelamin,
            //     'id_user' =>$user->id
            // ]);
            $member = new Anggota();

            $member->nama_anggota = $request->input('nama_anggota');
            $member->id_anggota = $request->input('id_anggota');
            $member->alamat_anggota = $request->input('alamat_anggota');
            $member->jenis_kelamin = $request->input('jenis_kelamin');
            $member->id_user = $user->id;
            $member->save();

            // Commit the database transaction if everything is successful
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil menambahkan anggota');
        } catch (\Throwable $th) {
            dd($th);

            // An error occurred, rollback the database transaction
            DB::rollback();
            
            return redirect()->back()->with('error', 'Gagal menambahkan anggota');
        }
    }

    public function delete($id)
    {
        $member = Anggota::findOrFail($id);
        $member->delete();
        // dd($saving);
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
