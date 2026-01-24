<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupComment extends Model
{  protected $table = 'groupcomments'; 
    protected $fillable = [
        'group_id',
        'user_id',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
