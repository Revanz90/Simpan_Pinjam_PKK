<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Simpanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyReportController extends Controller
{
    public function index(Request $request)
    {
        //Ambil DataUser
        $user = Auth::user();
        $anggota = Anggota::where('id_user', $user->id)->first();

        // Inisiasi Query Angsuran
        $query = Simpanan::query();

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

        $saving = $query->get();

        // Calculate the sum of nilai setoran
        $totalNilaiSimpanan = $saving->sum('nominal_uang');

        // Count the status
        $countBaru = $saving->where('status', 'baru')->count();
        $countDiterima = $saving->where('status', 'diterima')->count();
        $countDitolak = $saving->where('status', 'ditolak')->count();

        // Prepare the response data
        $response = [
            'getSimpanan' => $saving,
            'totalNilaiSimpanan' => $totalNilaiSimpanan
        ];

        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json($response);
        } else {
            // Return view for non-AJAX requests
            return view('layouts.laporan_simpanan', $response);
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
        $query = Simpanan::query();

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

        $saving = $query->get();

        // Calculate the sum of nilai setoran
        $totalNilaiSimpanan = $saving->sum('nominal_uang');

        // Count the status
        $countBaru = $saving->where('status', 'baru')->count();
        $countDiterima = $saving->where('status', 'diterima')->count();
        $countDitolak = $saving->where('status', 'ditolak')->count();

        // Prepare the response data
        $response = [
            'getSimpanan' => $saving,
            'totalNilaiSimpanan' => $totalNilaiSimpanan,
            'dateNow' => $dateNow
        ];
        
        // Print PDF
        $pdf = Pdf::loadView('pdf.export_simpanan',$response);
        return $pdf->download('Laporan Simpanan ' . Carbon::now() . '.pdf');
    }
}
