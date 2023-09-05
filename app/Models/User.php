<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */

    protected $appends = ['profile_photo_url', 'abbr_name', 'role_name', 'last_login_at'];

    protected $guard_name = 'sanctum';

    public function getAbbrNameAttribute()
    {
        $words = explode(" ", $this->name);
        $initials = null;
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return strtoupper($initials);
    }

    public function getRoleNameAttribute()
    {
        if (isset(Auth::user()->roles->pluck('name')[0])) {
            return Auth::user()->roles->pluck('name')[0];
        }

        return '';
    }

    public function getLastLoginAtAttribute()
    {
        if (isset($this->attributes['last_login_at'])) {
            return Carbon::parse($this->attributes['last_login_at'])->toW3cString();
        }

        return '';
    }
}
