<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkVisitSession extends Model
{
    protected $fillable = [
        'group_name',
        'host_name',
        'department',
        'purpose',
        'visit_date',
        'expected_headcount',
        'visitor_data',
        'qr_code_token',
        'status',
    ];

    protected $casts = [
        'visit_date' => 'datetime',
        'visitor_data' => 'array',
    ];
}
