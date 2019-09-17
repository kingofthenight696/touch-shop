<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function scopeAdminRole($query)
    {
        return $query->whereHas('role', function ($query) {
            return $query->whereName(Role::ADMIN_ROLE);
        });
    }

    public function scopeUserRole($query)
    {
        return $query->whereHas('role', function ($query) {
            return $query->whereName(Role::USER_ROLE);
        });
    }
}
