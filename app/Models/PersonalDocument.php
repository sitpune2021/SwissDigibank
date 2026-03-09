<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalDocument extends Model
{
    use SoftDeletes;
    protected $table = 'personal_documents'; // ✅ important

    protected $fillable = [
        'loan_id',
        'document_type',
        'file_path'
    ];
}
