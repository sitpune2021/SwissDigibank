<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareTransfer extends Model
{
   protected $table = "share_transfer";
   protected $fillable = [
      'transferor_id',
      'member_id',
      'business_type',
      'transfer_date',
      'shares',
      'face_value',
      'total_consideration'
   ];

   public function shareholdings()
   {
      return $this->belongsTo(Shareholding::class, 'transferor_id');
   }

   public function members()
   {
      return $this->belongsTo(Member::class, 'member_id');
   }
}
