<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRetentionPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'retention_period'
    ];
}
