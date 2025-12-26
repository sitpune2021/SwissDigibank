<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'collection_center_id',
        'branch_id',
        'open_date',
        'group_name',
        'group_no',
        'group_head_member_id',
        'group_cashier_member_id',
        'is_active',
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'group_members') ->withTimestamps();;
    }

    public function head()
    {
        return $this->belongsTo(Member::class, 'group_head_member_id');
    }

    public function cashier()
    {
        return $this->belongsTo(Member::class, 'group_cashier_member_id');
    }
    public function collectionCenter()
    {
        return $this->belongsTo(CollectionCenter::class);
    }

    public function groupHead()
    {
        return $this->belongsTo(Member::class, 'group_head_member_id');
    }
  public function comments()
{
    return $this->hasMany(GroupComment::class);
}
   
}
