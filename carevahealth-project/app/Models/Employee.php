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
        'email',
        'password',
        'date_of_birth',
        'age',
        'gender',
        'marital_status',
        'about_me_notes',
        'upload_documents',
        'department_id',
        'role_id',
        'location',
        'employment_type_id',
        'shift_type_id',
        'designation_id',
        'employee_status_id',
        'salary_pkr',
        'salary_usd',
        'source_of_hire',
        'date_of_joining',
        'date_of_regularisation',
        'expertise_id',
        'break_allowed_hours',
        'reporting_manager_id',
    ];

    protected $hidden = [
        'password',
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
}
