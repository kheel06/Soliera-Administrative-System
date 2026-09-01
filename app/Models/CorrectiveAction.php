<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorrectiveAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'assigned_to',
        'due_date',
        'resolved_date',
        'related_permit_id',
        'related_case_id',
        'resolution_notes',
        'created_by'
    ];

    protected $casts = [
        'due_date' => 'date',
        'resolved_date' => 'date',
    ];

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function permit()
    {
        return $this->belongsTo(CompliancePermit::class, 'related_permit_id');
    }
}
