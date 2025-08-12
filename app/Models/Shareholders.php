<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shareholders extends Model
{
        protected $fillable = [
        'transferor',
        'member_id', 
        'shareholding_id ',
        'branch_id',
        'business_type',
        'transfer_date',
        'shares',
        'face_value',
        'total_consideration',
        'share_range',
        'total_share_held',
        'nominal_value',
        'total_share_value',
        'allotment_date',
        'certificate_no',
        'surrendered',  
      
];
 public function member()
    {
         return $this->belongsTo(Member::class,'member_id');
    }
   public function branch()
{
    return $this->belongsTo(Branch::class, 'branch_id'); 
}

      public function shareholding()
    {
         return $this->belongsTo(Shareholding::class, 'shareholding_id');
    }
//      public function shareholding()
//     {
//          return $this->belongsTo(Shareholding::class, 'shareholding_id');
//     }
}
