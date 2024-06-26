<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pinjamans', function (Blueprint $table) {
            $table->id();
            $table->integer('nominal_pinjaman');
            $table->string('keterangan');
            $table->timestamp('tanggal_pinjaman');
            $table->enum('status_credit', ['baru', 'aktif', 'ditolak', 'lunas'])->default('baru');
            $table->unsignedBigInteger('author_id');
            $table->string('author_name');
            $table->enum('status_ketua', ['baru', 'diterima', 'ditolak'])->default('baru');
            $table->double('loan_interest')->default(0);
            $table->double('penalty')->default(0);
            $table->double('count_pinalty')->default(0)->nullable();
            $table->date('due_date')->default('2024-05-10');
            $table->double('total_terbayar')->default(0);
            $table->double('jumlah_cicilan_per_bulan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamans');
    }
};
