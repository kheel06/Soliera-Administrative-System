<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'contract_number',
        'counterparty_name',
        'type',
        'status',
        'effective_date',
        'expiration_date',
        'contract_value',
        'user_id',
        'department',
        'description',
        'file_path'
    ];

    protected $casts = [
        'effective_date' => 'date',
        'expiration_date' => 'date',
        'contract_value' => 'decimal:2',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
