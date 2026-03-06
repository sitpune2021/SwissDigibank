<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoldLoanDocument extends Model
{
    protected $fillable = [
        'loan_id',
        'document_type',
        'file_path'
    ];
}
