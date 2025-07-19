<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayableExpense extends Model
{
    protected $table = "expense_ledgers";
    protected $fillable = ['name'];
}
