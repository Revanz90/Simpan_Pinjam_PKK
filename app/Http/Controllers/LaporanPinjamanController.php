<?php

namespace App\Http\Controllers;

use App\Models\Pinjamans;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPinjamanController extends Controller
{
    public function index(Request $request)
    {
        // $savings = Saving::all()->sortByDesc('tanggal_pinjaman');
        $querySavingMonth = Pinjamans::query();
        $month = $request->month_filter;
        $year = $request->year_filter;

        switch ($month) {
            case 'januari':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '1');
                break;
            case 'februari':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '2');
                break;
            case 'maret':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '3');
                break;
            case 'april':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '4');
                break;
            case 'mei':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '5');
                break;
            case 'juni':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '6');
                break;
            case 'juli':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '7');
                break;
            case 'agustus':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '8');
                break;
            case 'september':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '9');
                break;
            case 'oktober':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '10');
                break;
            case 'november':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '11');
                break;
            case 'desember':
                $querySavingMonth->whereMonth('tanggal_pinjaman', '12');
                break;
        }

        switch ($year) {
            case '2023':
                $querySavingMonth->whereYear('tanggal_pinjaman', '2023');
                break;
            case '2024':
                $querySavingMonth->whereYear('tanggal_pinjaman', '2024');
                break;

        }

        $credits = $querySavingMonth->get();

        $user = Auth::user();
        if ($user->hasRole('admin') | $user->hasRole('ketua') | $user->hasRole('bendahara')) {
            $credits = Pinjamans::all()->sortByDesc('created_at');
        } else {
            $credits = Pinjamans::where('author_id', $user->id)->get()->sortByDesc('created_at');
        }
        return view('layouts.laporan_pinjaman', ['datas' => $credits]);
    }

    public function exportPdf()
    {
        $user = Auth::user();
        if ($user->hasRole('admin') | $user->hasRole('ketua') | $user->hasRole('bendahara')) {
            $credit = Pinjamans::all()->sortByDesc('created_at');
        } else {
            $credit = Pinjamans::where('author_id', $user->id)->get()->sortByDesc('created_at');
        }
        $pdf = Pdf::loadView('pdf.export_pinjaman', ['datas' => $credit]);
        return $pdf->download('laporan-pinjaman' . Carbon::now()->timestamp . '.pdf');
    }
}
