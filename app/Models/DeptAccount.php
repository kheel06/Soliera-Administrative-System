<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class DeptAccount extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'department_accounts';
    protected $primaryKey = 'Dept_no';
    public $timestamps = false;

    protected $fillable = [
        'Dept_no',
        'Dept_id',
        'dept_name',
        'employee_name',
        'employee_id',
        'role',
        'email',
        'status',
        'password',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the user's name (alias for employee_name)
     */
    public function getNameAttribute()
    {
        return $this->employee_name;
    }

    /**
     * Get the id attribute (alias for Dept_no for backward compatibility)
     */
    public function getIdAttribute()
    {
        return $this->Dept_no;
    }

    /**
     * The channels the user receives notification broadcasts on.
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'user.' . $this->Dept_no;
    }
}
