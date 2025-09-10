<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'invoice_number',
        'period_start',
        'period_end',
        'total_hours',
        'total_amount',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end'   => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function salaries()
    {
        return $this->hasMany(EmployeeSalary::class);
    }
}
