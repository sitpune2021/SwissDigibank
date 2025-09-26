<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MisaccountNominee extends Model
{
  
  protected $fillable = ['mis_account_id', 'nominee_relation', 'nominee_name', 'nominee_address'];

    public function misaccount()
    {
        return $this->belongsTo(Misaccount::class, 'mis_account_id'); //  fix
    }


}

