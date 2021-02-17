<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    public $guard_name = 'api';
    protected $fillable = [
        'full_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [];

    public function setFullNameAttribute($value)
    {
        $this->attributes['full_name'] = ucwords(strtolower($value));
    }
}
