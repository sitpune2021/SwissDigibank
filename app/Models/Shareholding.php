<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Promotor;

class Shareholding extends Model
{
    protected $fillable = [
        'promotor_id',
        'allotment_date',
        'first_share',
        'share_no',
        'nominal_value',
        'total_share_held',
        'total_share_value',
        'certificate_no',
        'transaction_date',
        'amount',
        'remarks',
        'pay_mode'
    ];

    public function promotors()
    {
        return $this->belongsTo(Promotor::class, 'promotor_id');
    }
}
