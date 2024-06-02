<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjamans;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPinjamanController extends Controller
{
    public function index(Request $request)
    {
        //Ambil DataUser
        $user = Auth::user();
        $anggota = Anggota::where('id_user', $user->id)->first();

        // Inisiasi Query Angsuran
        $query = Pinjamans::query();
        
        // Apply date range filter if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->whereBetween('tanggal_pinjaman', [$startDate, $endDate]);
        }

        if ($user->hasRole('admin') | $user->hasRole('ketua') | $user->hasRole('bendahara')) {
            // Mengambil data berdasarkan user dan mengurutkan berdasarkan created_at
            $query->orderBy('created_at', 'desc')->get();
        } else {
            $query->where('author_id', $anggota->id_anggota)->orderBy('created_at', 'desc')->get();
        }

        $credits = $query->get();

        // Calculate the sum of nilai setoran
        $totalNilaiPinjaman = $credits->sum('nominal_pinjaman');

        // Count the status
        $countBaru = $credits->where('status_credit', 'baru')->count();
        $countDiterima = $credits->where('status_credit', 'diterima')->count();
        $countDitolak = $credits->where('status_credit', 'ditolak')->count();

        // Prepare the response data
        $response = [
            'getPinjaman' => $credits,
            'totalNilaiPinjaman' => $totalNilaiPinjaman
        ];

        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json($response);
        } else {
            // Return view for non-AJAX requests
            return view('layouts.laporan_pinjaman', $response);
        }
    }

    public function exportPdf(Request $request)
    {
        // Ambil waktu sekarang
        $dateNow = Carbon::now();

        //Ambil DataUser
        $user = Auth::user();
        $anggota = Anggota::where('id_user', $user->id)->first();

        // Inisiasi Query Angsuran
        $query = Pinjamans::query();
        
        // Apply date range filter if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->whereBetween('tanggal_pinjaman', [$startDate, $endDate]);
        }

        if ($user->hasRole('admin') | $user->hasRole('ketua') | $user->hasRole('bendahara')) {
            // Mengambil data berdasarkan user dan mengurutkan berdasarkan created_at
            $query->orderBy('created_at', 'desc')->get();
        } else {
            $query->where('author_id', $anggota->id_anggota)->orderBy('created_at', 'desc')->get();
        }

        $credits = $query->get();

        // Calculate the sum of nilai setoran
        $totalNilaiPinjaman = $credits->sum('nominal_pinjaman');

        // Count the status
        $countBaru = $credits->where('status_credit', 'baru')->count();
        $countDiterima = $credits->where('status_credit', 'diterima')->count();
        $countDitolak = $credits->where('status_credit', 'ditolak')->count();

        // Prepare the response data
        $response = [
            'getPinjaman' => $credits,
            'totalNilaiPinjaman' => $totalNilaiPinjaman,
            'dateNow' => $dateNow
        ];

        $pdf = Pdf::loadView('pdf.export_pinjaman', $response);
        return $pdf->download('Laporan Pinjaman' . Carbon::now() . '.pdf');
    }
}
