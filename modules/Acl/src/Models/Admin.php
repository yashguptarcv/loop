<?php

namespace Modules\Acl\Models;

use Modules\Orders\Models\Order;
use Modules\Leads\Models\LeadModel;
use Modules\Meetings\Models\Meeting;
use Modules\Leads\Models\Application;
use Modules\Orders\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

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

    /**
     * Get the user's orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the user's transactions through orders.
     */
    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            Order::class,
            'user_id', // Foreign key on orders table
            'order_id', // Foreign key on transactions table
            'id', // Local key on users table
            'id' // Local key on orders table
        )->orderBy('created_at', 'desc');
    }

    /**
     * Get the user's successful transactions.
     */
    public function successfulTransactions()
    {
        return $this->transactions()
            ->where('status', 'success');
    }

    /**
     * Get the user's failed transactions.
     */
    public function failedTransactions()
    {
        return $this->transactions()
            ->where('status', 'failed');
    }

    /**
     * Get the user's completed orders.
     */
    public function completedOrders()
    {
        return $this->orders()
            ->where('status', fn_get_setting('general.order.complete'));
    }

    /**
     * Get the user's pending orders.
     */
    public function pendingOrders()
    {
        return $this->orders()
            ->where('status', fn_get_setting('general.order.create'));
    }

    /**
     * Get the applications sent to the user.
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'email')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the leads associated with the user.
     */
    public function leads()
    {
        return $this->hasMany(LeadModel::class, 'user_id')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the user's active leads.
     */
    public function looseLeads()
    {
        return $this->leads()
            ->where('status_id', 6);
    }

    /**
     * Get the user's converted leads.
     */
    public function convertedLeads()
    {
        return $this->leads()
            ->where('status_id', 7);
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
