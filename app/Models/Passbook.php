<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passbook extends Model
{
     protected $table = 'passbook';
    protected $fillable = [
        'account_type',
        'account_no',
        'passbook_no',
        'issue_date',
        'pages',
    ];

public function misAccount()
{
    return $this->belongsTo(Misaccount::class, 'mis_account_id');
}

}
