<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'misaccount_id',
        'date', 
        'comment', 
        'commented_by'
    ];

    public function misaccount()
    {
        return $this->belongsTo(Misaccount::class, 'id');
    }

}