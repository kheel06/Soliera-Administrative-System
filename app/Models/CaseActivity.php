<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'legal_case_id',
        'user_id',
        'user_name',
        'action_type',
        'action_description',
        'changes',
        'ip_address',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    /**
     * Get the legal case this activity belongs to
     */
    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class);
    }

    /**
     * Create a new activity log entry
     */
    public static function log($caseId, $actionType, $actionDescription, $changes = null)
    {
        return self::create([
            'legal_case_id' => $caseId,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()?->name ?? auth()->user()?->employee_name ?? 'System',
            'action_type' => $actionType,
            'action_description' => $actionDescription,
            'changes' => $changes,
            'ip_address' => request()->ip(),
        ]);
    }
}
