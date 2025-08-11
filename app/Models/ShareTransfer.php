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
      'total_consideration',
      'from_share_no',
      'to_share_no',
      'certificate_number'
   ];

   public function shareholdings()
   {
      return $this->belongsTo(Shareholding::class, 'transferor_id');
   }

   public function members()
   {
      return $this->belongsTo(Member::class, 'member_id');
   }
   public function promotor()
   {
      return $this->belongsTo(Promotor::class, 'promotor_id');
   }
}
