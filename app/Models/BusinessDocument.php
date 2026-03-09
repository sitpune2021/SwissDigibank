<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessDocument extends Model
{
    use SoftDeletes;
    protected $table = 'business_loan_documents'; // ✅ important

    protected $fillable = [
        'loan_id',
        'document_type',
        'file_path'
    ];
}
