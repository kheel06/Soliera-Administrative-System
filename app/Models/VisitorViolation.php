<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorViolation extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_id',
        'violation_type',
        'description',
        'severity',
        'resolved_at',
        'resolved_by',
        'notes'
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
