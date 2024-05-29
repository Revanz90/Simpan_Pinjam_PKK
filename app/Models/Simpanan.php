<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nominal_uang',
        'keterangan',
        'tanggal_transfer',
        'status',
        'author_id',
        'author_name',
        // Add other fields as needed
    ];

    public function getStatusSavingMasukAttribute()
    {
        if (isset($this->attributes['status']) && $this->attributes['status']) {
            switch ($this->attributes['status']) {
                case 'baru':
                    return "badge-primary";
                case 'disimpan':
                    return "badge-secondary";
                case 'diterima':
                    return "badge-success";
                case 'ditolak':
                    return "badge-danger";

            }
        }
        return 'badge-primary';
    }
}
