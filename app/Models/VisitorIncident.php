<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorIncident extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'severity',
        'status',
        'location',
        'incident_date',
        'reported_by',
        'visitor_id',
        'resolution_notes'
    ];

    protected $casts = [
        'incident_date' => 'datetime',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }
}
