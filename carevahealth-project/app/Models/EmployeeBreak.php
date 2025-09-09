<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeBreak extends Model
{
    protected $fillable = ['attendance_id', 'start_time', 'end_time','notes'];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
