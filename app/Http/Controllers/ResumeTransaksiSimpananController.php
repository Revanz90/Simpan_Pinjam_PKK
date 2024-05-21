<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ResumeTransaksiSimpananController extends Controller
{
    public function index(){
        $user = Auth::user();
    
        // Fungsi untuk menghitung nominal uang berdasarkan koleksi Simpanan
        function hitungNominal($simpanan) {
            return $simpanan->sum('nominal_uang');
        }
    
        $nominalPerAuthor = [];
        $simpananSorted = collect();  // Inisialisasi sebagai koleksi kosong
        $totalNominal = 0;
        $anggotaid = collect();
    
        if ($user->hasRole('admin')|$user->hasRole('ketua')|$user->hasRole('bendahara')) {
            // Ambil semua simpanan dan kelompokkan berdasarkan author_id
            $simpananGroupedByAuthor = Simpanan::all()->groupBy('author_id');

            // Ambil semua anggota
            $authorIds = $simpananGroupedByAuthor->keys();
            $anggotaid = Anggota::whereIn('id_user', $authorIds)->get();
            
            // Loop melalui setiap kelompok simpanan untuk menghitung total nominal per author
            foreach ($simpananGroupedByAuthor as $author_id => $simpanan) {
                $nominalPerAuthor[$author_id] = hitungNominal($simpanan);
            }
    
            // Sort by desc berdasarkan created_at
            $simpananSorted = $simpananGroupedByAuthor->sortByDesc(function($group) {
                return $group->max('created_at');
            });
    
        } else {
            // Ambil simpanan berdasarkan author_id user
            $simpanan = Simpanan::where('author_id', $user->id)->get()->sortByDesc('created_at');
            // $anggotaid = Anggota::where('id_user', $user->id)->first();

            // Ambil data anggota dan masukkan ke dalam koleksi
            $anggota = Anggota::where('id_user', $user->id)->first();
            if ($anggota) {
                $anggotaid = collect([$anggota]);
            }
            
            // Hitung total nominal
            $totalNominal = hitungNominal($simpanan);
        }
    
        // Mengirimkan data ke view
        return view('layouts.resume_transaksi_simpanan', compact('simpananSorted', 'nominalPerAuthor', 'totalNominal', 'user', 'anggotaid'));
    }
    
    public function exportDetailTransaksiSimpananToPDF(){
        $user = Auth::user();
        $dateNow = Carbon::now();
        // Fungsi untuk menghitung nominal uang berdasarkan koleksi Simpanan
        function hitungNominalAngsuran($simpanan) {
            return $simpanan->sum('nominal_uang');
        }
    
        $nominalPerAuthor = [];
        $simpananSorted = collect();  // Inisialisasi sebagai koleksi kosong
        $totalNominal = 0;
        $anggotaid = collect();
    
        if ($user->hasRole('admin')|$user->hasRole('ketua')|$user->hasRole('bendahara')) {
            // Ambil semua simpanan dan kelompokkan berdasarkan author_id
            $simpananGroupedByAuthor = Simpanan::all()->groupBy('author_id');

            // Ambil semua anggota
            $authorIds = $simpananGroupedByAuthor->keys();
            $anggotaid = Anggota::whereIn('id_user', $authorIds)->get();
            
            // Loop melalui setiap kelompok simpanan untuk menghitung total nominal per author
            foreach ($simpananGroupedByAuthor as $author_id => $simpanan) {
                $nominalPerAuthor[$author_id] = hitungNominalAngsuran($simpanan);
            }
    
            // Sort by desc berdasarkan created_at
            $simpananSorted = $simpananGroupedByAuthor->sortByDesc(function($group) {
                return $group->max('created_at');
            });
    
        } else {
            // Ambil simpanan berdasarkan author_id user
            $simpanan = Simpanan::where('author_id', $user->id)->get()->sortByDesc('created_at');
            // $anggotaid = Anggota::where('id_user', $user->id)->first();

            // Ambil data anggota dan masukkan ke dalam koleksi
            $anggota = Anggota::where('id_user', $user->id)->first();
            if ($anggota) {
                $anggotaid = collect([$anggota]);
            }
            
            // Hitung total nominal
            $totalNominal = hitungNominalAngsuran($simpanan);
        }

        $pdf = Pdf::loadView('pdf.export_detail_simpanan', compact('simpananSorted', 'nominalPerAuthor', 'totalNominal', 'user', 'anggotaid', 'dateNow'));
        return $pdf->download('Detail Transaksi Simpanan ' . Carbon::parse($dateNow)->translatedFormat('d F Y') . '.pdf');
    }
}
