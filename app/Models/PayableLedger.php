<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayableLedger extends Model
{
    protected $table = "payable_ledgers";
    protected $fillable = ['name'];
}
