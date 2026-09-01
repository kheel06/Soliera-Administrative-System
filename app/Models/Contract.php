<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'contract_number',
        'counterparty',
        'value',
        'start_date',
        'end_date',
        'status', // draft, active, expired, terminated
        'risk_level', // low, medium, high
        'department',
        'owner_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'value' => 'decimal:2'
    ];

    public function owner()
    {
        return $this->belongsTo(DeptAccount::class, 'owner_id', 'employee_id');
    }
}
