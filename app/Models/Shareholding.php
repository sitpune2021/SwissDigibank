<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shareholding extends Model
{
    protected $fillable = [
        'promoter',
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
        'pay_mode',
    ];

    public function promoters()
    {
        return $this->belongsTo(Promotor::class, 'promoter');
    }
}
