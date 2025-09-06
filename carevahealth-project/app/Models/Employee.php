<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // if employees need login
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // If employees should be authenticatable (with login), extend Authenticatable
    // If not, just extend Model
    // For now, I'll keep it simple with Model:
    // class Employee extends Model

    protected $fillable = [
        'user_id',
        'profile_picture',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'date_of_birth',
        'age',
        'gender',
        'marital_status',
        'about_me_notes',
        'department_id',
        'role_id',
        'location',
        'timezone',
        'employment_type_id',
        'shift_type_id',
        'designation_id',
        'employee_status_id',
        'salary_pkr',
        'salary_usd',
        'source_of_hire',
        'upload_documents',
        'date_of_joining',
        'date_of_regularisation',
        'expertise_id',
        'break_allowed_hours',
        'reporting_manager_id',
        'profile_completed'
    ];

    protected $hidden = [
        'password',
    ];
    protected $casts = [
        'upload_documents' => 'array',
    ];

    // 🔹 Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class);
    }

    public function shiftType()
    {
        return $this->belongsTo(ShiftType::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function employeeStatus()
    {
        return $this->belongsTo(EmployeeStatus::class);
    }

    public function expertise()
    {
        return $this->belongsTo(Expertise::class);
    }

    public function reportingManager()
    {
        return $this->belongsTo(ReportingManager::class);
    }

    // 🔹 Accessors
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function clientSchedules()
    {
        return $this->hasMany(EmployeeClientSchedule::class, 'employee_id');
    }
    
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'employee_client_schedules', 'employee_id', 'client_id')
                    ->withPivot(['weekday', 'start_time', 'end_time', 'no_of_hours', 'enabled', 'repeat']);
    }

    public function salaries()
    {
        return $this->hasMany(EmployeeSalary::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            $lastEmployee = self::orderBy('id', 'desc')->first();
            $nextNumber = $lastEmployee ? ((int) filter_var($lastEmployee->employee_code, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;

            $employee->employee_code = 'CVMA' . $nextNumber;
        });
    }
}
