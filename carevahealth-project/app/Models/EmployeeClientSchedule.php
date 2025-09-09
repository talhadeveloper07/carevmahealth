<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeClientSchedule extends Model
{
    protected $fillable = [
        'client_id',
        'employee_id',
        'weekday',
        'start_time',
        'end_time',
        'no_of_hours',
        'enabled',
        'repeat'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
