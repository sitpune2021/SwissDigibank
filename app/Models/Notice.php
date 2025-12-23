<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Notice extends Model
{
    use HasFactory;

    // Fields that are mass assignable
    protected $fillable = [
        'branch_id',       // Foreign key to branches table
        'notice_title',    // Title of the notice
        'notice_body',     // Body of the notice
        'images',          // Image path
        'start_date',      // Start date
        'end_date',        // End date
        'app_type', // Admin App / Agent App / Both App
        'created_by',     // logedin user   
    ];

    // Relation to Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
     public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
