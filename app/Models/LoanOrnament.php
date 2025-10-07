<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanOrnament extends Model
{
    protected $table = 'loan_ornaments'; //  table  name

    protected $fillable = [
        'application_id',
        'item_type',
        'item_name',
        'no_of_items',
        'value_per_gram',
        'gross_weight',
        'net_weight',
        'tunch',
        'fine_weight',
        'total_value',
        'status',
        'remark'
    ];

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class, 'application_id');
    }
}
