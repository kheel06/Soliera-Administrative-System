<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    protected $table = 'legal_documents';
    
    protected $fillable = [
        'title', 
        'file_path', 
        'status', 
        'department', 
        'description', 
        'case_id', 
        'uploaded_by',
        'created_by',
        'document_type',
        'responsible_officer_id',
        'current_reviewer_id',
        'version',
        'retention_until',
        'archived_at',
        'ai_summary',
        'ai_tags',
        'ai_risk_score',
        'metadata'
    ];

    protected $casts = [
        'status' => 'string',
        'retention_until' => 'date',
        'archived_at' => 'datetime',
        'ai_risk_score' => 'float',
        'metadata' => 'array',
        'ai_tags' => 'array'
    ];

    public function case()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function responsibleOfficer()
    {
        return $this->belongsTo(User::class, 'responsible_officer_id');
    }

    public function currentReviewer()
    {
        return $this->belongsTo(User::class, 'current_reviewer_id');
    }
}
