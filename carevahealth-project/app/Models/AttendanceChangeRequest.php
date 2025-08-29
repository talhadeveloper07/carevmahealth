<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceChangeRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'attendance_id',
        'date',
        'requested_clock_in',
        'requested_clock_out',
        'old_clock_in',
        'old_clock_put',
        'reason',
        'status'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
