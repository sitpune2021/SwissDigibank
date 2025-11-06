<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicalProcessingFee extends Model
{
    protected $fillable = [
        'application_id', 'value', 'gst_percent',
        'sgst', 'cgst', 'igst', 'total', 'fee_mode',
        'bank_id', 'cheque_no', 'cheque_date',
        'transfer_date', 'utr_no', 'transfer_mode',
        'credited'
    ];
}
