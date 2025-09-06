<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'business_name',
        'country',
        'phone_number',
        'per_hour_charges',
        'timezone',
        'contract_type_id',
        'service_id',
        'ring_center'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // 🔗 Each client has one contract type
    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }

    // 🔗 A client can have many employees
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_client_schedules', 'client_id', 'employee_id')
                    ->withPivot(['weekday', 'start_time', 'end_time', 'no_of_hours', 'enabled', 'repeat']);
    }
    public function employeeSchedules()
    {
        return $this->hasMany(EmployeeClientSchedule::class, 'client_id');
    }
    public function salaries()
    {
        return $this->hasMany(EmployeeSalary::class);
    }
}
