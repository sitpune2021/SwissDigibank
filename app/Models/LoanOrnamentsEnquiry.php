<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanOrnamentsEnquiry extends Model
{
    protected $table = 'loan_ornaments_enquiry'; // 👈 FIX HERE

    protected $fillable = ['type', 'qty', 'carat', 'net_weight'];
}
