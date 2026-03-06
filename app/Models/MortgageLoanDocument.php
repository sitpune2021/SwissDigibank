<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MortgageLoanDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'loan_id',
        'document_type',
        'file_path'
    ];
}
