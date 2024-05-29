<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingFile extends Model
{
    use HasFactory;

    protected $tables = 'saving_files';

    protected $fillable = [
        'files',
        'id_savings',
        // Add other fields as needed
    ];
}
