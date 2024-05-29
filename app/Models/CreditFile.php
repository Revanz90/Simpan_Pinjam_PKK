<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditFile extends Model
{
    use HasFactory;

    protected $tables = 'credit_files';

    protected $fillable = [
        'files',
        'id_credits',
        // Add other fields as needed
    ];
}
