<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $fillable = [
        'user_id',
        'activity_name',
        'activity_action',
        'ip_address',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}