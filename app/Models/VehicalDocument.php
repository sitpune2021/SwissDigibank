<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\SoftDeletes;

class VehicalDocument extends Model
{
    use SoftDeletes;
    protected $table = 'vehical_loan_documents';
    protected $fillable = [
        'loan_id',
        'document_type',
        'file_path'
    ];
}
