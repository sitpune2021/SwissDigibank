<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class DailyWeeklyDocument extends Model
{
    use SoftDeletes;
    protected $table = 'daily_weekly_documents'; // ✅ important

    protected $fillable = [
        'loan_id',
        'document_type',
        'file_path'
    ];
}