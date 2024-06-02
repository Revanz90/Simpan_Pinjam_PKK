<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Angsuran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanAngsuranController extends Controller
{
    public function index(Request $request)
    {
        //Ambil Data User
        $user = Auth::user();
        $anggota = Anggota::where('id_user', $user->id)->first();

        // Inisiasi Query Angsuran
        $query = Angsuran::query();

        // Apply date range filter if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->whereBetween('tanggal_transfer', [$startDate, $endDate]);
        }

        if ($user->hasRole('admin') | $user->hasRole('ketua') | $user->hasRole('bendahara')) {
            // Mengambil data berdasarkan user dan mengurutkan berdasarkan created_at
            $query->orderBy('created_at', 'desc')->get();
        } else {
            $query->where('author_id', $anggota->id_anggota)->orderBy('created_at', 'desc')->get();
        }

        $angsurans = $query->get();

        // Calculate the sum of nilai setoran
        $totalNilaiAngsurans = $angsurans->sum('nominal_angsuran');

        // Count the status
        $countBaru = $angsurans->where('status', 'baru')->count();
        $countDiterima = $angsurans->where('status', 'diterima')->count();
        $countDitolak = $angsurans->where('status', 'ditolak')->count();

        // Prepare the response data
        $response = [
            'getAngsurans' => $angsurans,
            'totalNilaiAngsuran' => $totalNilaiAngsurans
        ];

        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json($response);
        } else {
            // Return view for non-AJAX requests
            return view('layouts.laporan_angsuran', $response);
        }
    }

    public function exportPdf(Request $request)
    {
        // Ambil waktu sekarang
        $dateNow = Carbon::now();

        //Ambil Data User
        $user = Auth::user();
        $anggota = Anggota::where('id_user', $user->id)->first();

        // Inisiasi Query Angsuran
        $query = Angsuran::query();

        // Apply date range filter if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->whereBetween('tanggal_transfer', [$startDate, $endDate]);
        }

        if ($user->hasRole('admin') | $user->hasRole('ketua') | $user->hasRole('bendahara')) {
            // Mengambil data berdasarkan user dan mengurutkan berdasarkan created_at
            $query->orderBy('created_at', 'desc')->get();
        } else {
            $query->where('author_id', $anggota->id_anggota)->orderBy('created_at', 'desc')->get();
        }

        $angsurans = $query->get();

        // Calculate the sum of nilai setoran
        $totalNilaiAngsurans = $angsurans->sum('nominal_angsuran');

        // Count the status
        $countBaru = $angsurans->where('status', 'baru')->count();
        $countDiterima = $angsurans->where('status', 'diterima')->count();
        $countDitolak = $angsurans->where('status', 'ditolak')->count();

        // Prepare the response data
        $response = [
            'getAngsurans' => $angsurans,
            'totalNilaiAngsuran' => $totalNilaiAngsurans,
            'dateNow' => $dateNow
        ];

        $pdf = Pdf::loadView('pdf.export_angsuran', $response);
        return $pdf->download('Laporan Angsuran ' . Carbon::now() . '.pdf');
    }
}
