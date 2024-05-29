<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallmentFile extends Model
{
    use HasFactory;

    protected $tables = 'installment_files';

    protected $fillable = [
        'files',
        'id_installments',
        // Add other fields as needed
    ];
}
