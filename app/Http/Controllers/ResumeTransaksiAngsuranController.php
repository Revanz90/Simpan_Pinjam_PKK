<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Angsuran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeTransaksiAngsuranController extends Controller
{
    public function index(){
        $user = Auth::user();
    
        // Fungsi untuk menghitung nominal uang berdasarkan koleksi Angsuran
        function hitungNominal($angsuran) {
            return $angsuran->sum('nominal_angsuran');
        }
    
        $nominalPerAuthor = [];
        $angsuranSorted = collect();  // Inisialisasi sebagai koleksi kosong
        $totalNominal = 0;
        $anggotaid = collect();

        if ($user->hasRole('admin')) {
            // Ambil semua simpanan dan kelompokkan berdasarkan author_id
            $angsuranGroupedByAuthor = Angsuran::all()->groupBy('author_id');

            // Ambil semua anggota
            $authorIds = $angsuranGroupedByAuthor->keys();
            $anggotaid = Anggota::whereIn('id_user', $authorIds)->get();
            
            // Loop melalui setiap kelompok simpanan untuk menghitung total nominal per author
            foreach ($angsuranGroupedByAuthor as $author_id => $angsuran) {
                $nominalPerAuthor[$author_id] = hitungNominal($angsuran);
            }
    
            // Sort by desc berdasarkan created_at
            $simpananSorted = $angsuranGroupedByAuthor->sortByDesc(function($group) {
                return $group->max('created_at');
            });
    
        } else {
            // Ambil simpanan berdasarkan author_id user
            $angsuran = Angsuran::where('author_id', $user->id)->get()->sortByDesc('created_at');
            // $anggotaid = Anggota::where('id_user', $user->id)->first();

            // Ambil data anggota dan masukkan ke dalam koleksi
            $anggota = Anggota::where('id_user', $user->id)->first();
            if ($anggota) {
                $anggotaid = collect([$anggota]);
            }
            
            // Hitung total nominal
            $totalNominal = hitungNominal($angsuran);
        }

        return view('layouts.resume_transaksi_angsuran', compact('angsuranSorted', 'nominalPerAuthor', 'totalNominal', 'user', 'anggotaid'));
    }

    public function exportDetailTransaksiAngsuranToPDF(){
        $user = Auth::user();
        $dateNow = Carbon::now();
    
        // Fungsi untuk menghitung nominal uang berdasarkan koleksi Angsuran
        function hitungNominalAngsuran($angsuran) {
            return $angsuran->sum('nominal_angsuran');
        }
    
        $nominalPerAuthor = [];
        $angsuranSorted = collect();  // Inisialisasi sebagai koleksi kosong
        $totalNominal = 0;
        $anggotaid = collect();

        if ($user->hasRole('admin')) {
            // Ambil semua simpanan dan kelompokkan berdasarkan author_id
            $angsuranGroupedByAuthor = Angsuran::all()->groupBy('author_id');

            // Ambil semua anggota
            $authorIds = $angsuranGroupedByAuthor->keys();
            $anggotaid = Anggota::whereIn('id_user', $authorIds)->get();
            
            // Loop melalui setiap kelompok simpanan untuk menghitung total nominal per author
            foreach ($angsuranGroupedByAuthor as $author_id => $angsuran) {
                $nominalPerAuthor[$author_id] = hitungNominalAngsuran($angsuran);
            }
    
            // Sort by desc berdasarkan created_at
            $simpananSorted = $angsuranGroupedByAuthor->sortByDesc(function($group) {
                return $group->max('created_at');
            });
    
        } else {
            // Ambil simpanan berdasarkan author_id user
            $angsuran = Angsuran::where('author_id', $user->id)->get()->sortByDesc('created_at');
            // $anggotaid = Anggota::where('id_user', $user->id)->first();

            // Ambil data anggota dan masukkan ke dalam koleksi
            $anggota = Anggota::where('id_user', $user->id)->first();
            if ($anggota) {
                $anggotaid = collect([$anggota]);
            }
            
            // Hitung total nominal
            $totalNominal = hitungNominalAngsuran($angsuran);
        }

        $pdf = Pdf::loadView('pdf.export_detail_angsuran', compact('simpananSorted', 'nominalPerAuthor', 'totalNominal', 'user', 'anggotaid', 'dateNow'));
        return $pdf->download('Detail Transaksi Angsuran ' . Carbon::parse($dateNow)->translatedFormat('d F Y') . '.pdf');
    }
}
