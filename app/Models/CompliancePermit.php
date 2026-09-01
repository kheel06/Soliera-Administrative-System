<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompliancePermit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'issuing_authority',
        'reference_number',
        'expiration_date',
        'status',
        'compliance_score',
        'notes'
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'compliance_score' => 'integer',
    ];
}
