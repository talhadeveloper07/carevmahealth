<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
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
        return $this->hasMany(Employee::class);
    }
}
