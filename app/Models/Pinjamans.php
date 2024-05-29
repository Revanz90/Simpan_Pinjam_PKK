<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjamans extends Model
{
    use HasFactory;

    protected $fillable = [
        'nominal_pinjaman',
        'keterangan',
        'tanggal_pinjaman',
        'status_credit',
        'author_id',
        'author_name',
        'status_ketua',
        'loan_interest',
        'penalty',
        'count_pinalty',
        'due_date',
        'total_terbayar',
        'jumlah_cicilan_per_bulan',
    ];

    public function getStatusCreditMasukAttribute()
    {
        if (isset($this->attributes['status_credit']) && $this->attributes['status_credit']) {
            switch ($this->attributes['status_credit']) {
                case 'baru':
                    return "badge-primary";
                case 'aktif':
                    return "badge-success";
                case 'ditolak':
                    return "badge-danger";
                case 'lunas':
                    return "badge-info";
            }
        }
        return 'badge-primary';
    }
}
