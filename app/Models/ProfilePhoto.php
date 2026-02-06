<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePhoto extends Model
{
   
    protected $fillable = ['user_id', 'filename'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
