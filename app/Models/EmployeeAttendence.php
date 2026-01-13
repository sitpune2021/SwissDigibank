<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeAttendence extends Model
{protected $table = 'employee_attendances'; // explicitly match migration
   protected $fillable = [
        'employee_id',
        'attendance_date',
        'in_time',
        'out_time',
        'working_minutes',
        'status',
        'created_by',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
