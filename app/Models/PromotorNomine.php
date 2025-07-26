<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Promotor;

class PromotorNomine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'promotor_id', 'name', 'relation', 'mobile_no', 'aadhaar_no',
        'voter_id_no', 'pan_no', 'address'
    ];

    public function promotor()
    {
        return $this->belongsTo(Promotor::class);
    }
}
