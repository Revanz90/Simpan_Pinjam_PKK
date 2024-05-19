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

    public function detailAnggota($id)
    {
        $member = Anggota::find($id);
        $users = User::find($member->id_user);
        return view('layouts.detail_dataanggota', ['member' => $member, 'user' => $users]);
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
            // An error occurred, rollback the database transaction
            DB::rollback();
            
            return redirect()->back()->with('error', 'Gagal menambahkan anggota');
        }
    }

    public function update(Request $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();

            $validated = $request->validate([
                'nama_anggota' => 'required',
                'id_anggota' => 'required',
                'alamat_anggota' => 'required',
                'email_anggota' => 'required|email',
                'password_anggota' => 'required',
                'jenis_kelamin' => 'required',
                'user_id' => 'required|exists:users,id',
                'member_id' => 'required|exists:anggotas,id',
            ]);

            $user = User::findOrFail($request->user_id);
            $member = Anggota::findOrFail($request->member_id);

            $user->name = $request->nama_anggota;
            $user->email = $request->email_anggota;
            $user->password = bcrypt($request->password_anggota);
            $user->save();

            $member->nama_anggota = $request->input('nama_anggota');
            $member->id_anggota = $request->input('id_anggota');
            $member->alamat_anggota = $request->input('alamat_anggota');
            $member->jenis_kelamin = $request->input('jenis_kelamin');
            $member->id_user = $user->id;
            $member->save();

            // Commit the database transaction if everything is successful
            DB::commit();

            return redirect()->back()->with('success', 'Berhasil merubah anggota');
        } catch (\Throwable $th) {
            // An error occurred, rollback the database transaction
            DB::rollback();
            
            return redirect()->back()->with('error', 'Gagal merubah anggota');
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
