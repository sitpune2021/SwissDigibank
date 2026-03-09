<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CcOdDocument extends Model
{
    use SoftDeletes;
    protected $table = 'cc_od_loan_documents'; // ✅ important

    protected $fillable = [
        'loan_id',
        'document_type',
        'file_path'
    ];
}
