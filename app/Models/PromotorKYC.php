<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Promotor;

class PromotorKYC extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'promotor_id', 'aadhaar_no', 'voter_id_no', 'pan_no', 'ration_card_no',
        'meter_no', 'ci_no', 'ci_relation', 'dl_no', 'kyc_status'
    ];

    public function promotor()
    {
        return $this->belongsTo(Promotor::class);
    }
}
