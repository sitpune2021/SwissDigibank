<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class logo_letterhead_img_uploads extends Model
{
  
    protected $fillable = [
        'type',
        'image_path',
        'uploaded_by',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
