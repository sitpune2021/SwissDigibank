<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareCertificate extends Model
{
     protected $fillable = [
        'member_id',
        'branch_id',
         'certificate_no',
         'share_range',
     ];
    public function branch()
{
    return $this->belongsTo(Branch::class, 'branch_id');
}

public function member()
{
    return $this->belongsTo(Member::class, 'member_id');
}
public function shareholding()
{
    return $this->belongsTo(Shareholding::class, 'shareholding_id');
}

}

