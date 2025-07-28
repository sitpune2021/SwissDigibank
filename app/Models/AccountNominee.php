<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountNominee extends Model
{
    protected $fillable = [
        'account_id',
        'nominee_name',
        'nominee_relation',
        'nominee_address',
        'share_percentage',
    ];
}

