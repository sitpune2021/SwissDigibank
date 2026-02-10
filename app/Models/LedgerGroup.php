<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LedgerGroup extends Model
{
    protected $fillable = [
        'display_name',
        'system_name',
        'type',
        'is_system_group',
        'weightage'
    ];
}
