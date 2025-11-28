<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'mis_id',
        'rd_id',
        'dd_id',
        'fd_id',
        'mds_id',
        'document_type',
        'file_path',
    ];


    public function misaccount()
    {
        return $this->belongsTo(Misaccount::class, 'id');
    }

    // public function rd()
    // {
    //     return $this->belongsTo(RdAccount::class, 'rd_id');
    // }

    // public function dd()
    // {
    //     return $this->belongsTo(DdAccount::class, 'dd_id');
    // }

    // public function fd()
    // {
    //     return $this->belongsTo(FdAccount::class, 'fd_id');
    // }

    // public function mds()
    // {
    //     return $this->belongsTo(MdsAccount::class, 'mds_id');
    // }
}
