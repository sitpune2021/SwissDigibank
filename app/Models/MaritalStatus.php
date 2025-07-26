<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    protected $fillable = [
        'status',
    ];

    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }
}
