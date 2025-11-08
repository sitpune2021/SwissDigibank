<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rank extends Model
{
    use SoftDeletes;

    protected $table = 'ranks';

    protected $fillable = [
        'name',
        'display_position',
        'working_position',
        'collection_commission',
        'created_by',
    ];

    protected $casts = [
        'collection_commission' => 'boolean',
    ];
}
