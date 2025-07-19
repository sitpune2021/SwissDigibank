<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table="banks_name";
    protected $fillable=['name'];
}
