<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'clock_in',
        'clock_out',
        'break_limit',
        'break_taken',
        'total_minutes',
        'overtime'
    ];

    // 🔹 Ek Attendance ek Employee se belong karti hai
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // 🔹 Ek Attendance ke multiple breaks ho sakte hain
    public function breaks()
    {
        return $this->hasMany(EmployeeBreak::class, 'attendance_id');
    }

    protected $casts = [
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
        'date' => 'date',
    ];
}