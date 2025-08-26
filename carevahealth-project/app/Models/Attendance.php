<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['employee_id', 'date', 'clock_in', 'clock_out', 'break_limit', 'break_taken','total_minutes','overtime'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function breaks()
    {
        return $this->hasMany(EmployeeBreak::class);
    }

    protected $casts = [
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
        'date' => 'date',
    ];
}
