<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MortgageProperty extends Model
{
    protected $table = 'mortgage_properties';

    protected $fillable = [
        'loan_application_id',
        'property_type',
        'ownership_type',
        'property_address',
        'city',
        'state',
        'area',
        'property_value',
    ];

    public function loanApplication()
    {
        return $this->belongsTo(MortgageLoanApplication::class, 'loan_application_id');
    }
}
