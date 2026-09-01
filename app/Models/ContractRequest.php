<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'requester_id',
        'department',
        'description',
        'counterparty_name',
        'priority',
        'status',
        'desired_date',
        'comments'
    ];

    protected $casts = [
        'desired_date' => 'date',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
}
