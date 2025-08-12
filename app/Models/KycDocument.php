<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KycDocument extends Model
{
     protected $fillable = [
        'member_id',
        'promoter_id',
        'document_category',
        'document_type',
        'file_path',
        'type',
    ];
      public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function promoter()
    {
        return $this->belongsTo(Promotor::class);
    }
}
