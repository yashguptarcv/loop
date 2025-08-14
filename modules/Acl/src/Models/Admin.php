<?php

namespace Modules\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Meetings\Models\Meeting;

class Admin extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role_id',
        'image',
        'google_access_token',
        'google_refresh_token',
        'google_expires_in',
        'google_token_type',
        'google_token_created_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->role && $this->role->permission_type === 'all') {
            return true;
        }

        return in_array($permission, $this->role->permissions ?? []);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function hasGoogleAuth()
    {
        return !empty($this->google_access_token);
    }

    public function isGoogleTokenExpired()
    {
        if (!$this->google_token_created_at || !$this->google_expires_in) {
            return true;
        }

        return now()->gte($this->google_token_created_at->addSeconds($this->google_expires_in));
    }

    public function setGoogleToken(array $tokenData)
    {
        $this->update([
            'google_access_token'       => $tokenData['access_token'],
            'google_refresh_token'      => $tokenData['refresh_token'] ?? $this->google_refresh_token,
            'google_expires_in'         => $tokenData['expires_in'],
            'google_token_type'         => $tokenData['token_type'],
            'google_token_created_at'   => $tokenData['timestamp'],
        ]);
    }
}
