<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentImportLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_system',
        'external_reference_id',
        'document_id',
        'import_status',
        'payload',
        'error_message',
        'started_at',
        'completed_at',
        'processing_time_ms'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'processing_time_ms' => 'float'
    ];

    /**
     * Get the document associated with this import
     */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
