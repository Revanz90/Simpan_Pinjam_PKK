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

        // Fungsi untuk menghitung nominal denda berdasarkan koleksi Angsuran
        function hitungDenda($angsuran) {
            return $angsuran->sum('nominal_denda');
        }

        // Fungsi untuk menghitung nominal denda berdasarkan koleksi Angsuran
        function hitungTerbayar($angsuran) {
            return $angsuran->sum('total_terbayar');
        }
    
        $nominalPerAuthor = [];
        $dendaPerAuthor = [];
        $totalTerbayarPerAuthor = [];
        $angsuranSorted = collect();  // Inisialisasi sebagai koleksi kosong
        $totalNominal = 0;
        $totalDenda = 0;
        $totalTerbayar = 0;
        $anggotaid = collect();

        if ($user->hasRole('admin')|$user->hasRole('ketua')|$user->hasRole('bendahara')) {
            // Ambil semua simpanan dan kelompokkan berdasarkan author_id
            $angsuranGroupedByAuthor = Angsuran::all()->groupBy('author_id');

            // Ambil semua anggota
            $authorIds = $angsuranGroupedByAuthor->keys();
            $anggotaid = Anggota::whereIn('id_anggota', $authorIds)->get();
            
            // Loop melalui setiap kelompok simpanan untuk menghitung total nominal per author
            foreach ($angsuranGroupedByAuthor as $author_id => $angsuran) {
                $nominalPerAuthor[$author_id] = hitungNominal($angsuran);
                $dendaPerAuthor[$author_id] = hitungDenda($angsuran);
                $totalTerbayarPerAuthor[$author_id] = hitungTerbayar($angsuran);
            }
    
            // Sort by desc berdasarkan created_at
            $angsuranSorted = $angsuranGroupedByAuthor->sortByDesc(function($group) {
                return $group->max('created_at');
            });
    
        } else {
            //Ambil data anggota
            $anggota = Anggota::where('id_user', $user->id)->first();

            // Ambil simpanan berdasarkan author_id user
            $angsuran = Angsuran::where('author_id', $anggota->id_anggota)->get()->sortByDesc('created_at');

            // Ambil data anggota dan masukkan ke dalam koleksi
            if ($anggota) {
                $anggotaid = collect([$anggota]);
            }

            // Hitung total nominal
            $totalNominal = hitungNominal($angsuran);
            $totalDenda = hitungDenda($angsuran);
            $totalTerbayar = hitungTerbayar($angsuran);
        }

        return view('layouts.resume_transaksi_angsuran', compact('angsuranSorted', 'nominalPerAuthor', 'dendaPerAuthor', 'totalNominal', 'totalDenda', 'totalTerbayarPerAuthor', 'totalTerbayar','user', 'anggotaid'));
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

        if ($user->hasRole('admin')|$user->hasRole('ketua')|$user->hasRole('bendahara')) {
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
            $angsuranSorted = $angsuranGroupedByAuthor->sortByDesc(function($group) {
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

        $pdf = Pdf::loadView('pdf.export_detail_angsuran', compact('angsuranSorted', 'nominalPerAuthor', 'totalNominal', 'user', 'anggotaid', 'dateNow'));
        return $pdf->download('Detail Transaksi Angsuran ' . Carbon::parse($dateNow)->translatedFormat('d F Y') . '.pdf');
    }
}
