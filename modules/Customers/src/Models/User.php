<?php

namespace Modules\Customers\Models;

use Modules\Leads\Models\Lead;
use Modules\Orders\Models\Order;
use Modules\Leads\Models\LeadModel;
use Modules\Customers\Models\Address;
use Modules\Leads\Models\Application;
use Modules\Orders\Models\Transaction;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'is_active',
        'last_login_at',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /** ----------------------------
     * RELATIONSHIPS
     * ---------------------------- */

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id')
            ->orderBy('created_at', 'desc');
    }

    public function getOrderTotal()
    {
        return $this->orders()->sum('total'); // assuming your orders table has a `total` column
    }

    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            Order::class,
            'user_id',
            'order_id',
            'id',
            'id'
        )->orderBy('created_at', 'desc');
    }

    public function successfulTransactions()
    {
        return $this->transactions()->where('status', 'success');
    }

    public function failedTransactions()
    {
        return $this->transactions()->where('status', 'failed');
    }

    public function completedOrders()
    {
        return $this->orders()->where('status', fn_get_setting('general.order.complete'));
    }

    public function pendingOrders()
    {
        return $this->orders()->where('status', fn_get_setting('general.order.create'));
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'email')->orderBy('created_at', 'desc');
    }

    public function leads()
    {
        return $this->hasMany(LeadModel::class, 'user_id')->orderBy('created_at', 'desc');
    }

    public function looseLeads()
    {
        return $this->leads()->where('status_id', 6);
    }

    public function convertedLeads()
    {
        return $this->leads()->where('status_id', 7);
    }

    /** ----------------------------
     * ADDRESSES
     * ---------------------------- */

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function billingAddresses(): HasMany
    {
        return $this->addresses()->billing();
    }

    public function shippingAddresses(): HasMany
    {
        return $this->addresses()->shipping();
    }

    public function defaultBillingAddress()
    {
        return $this->hasOne(Address::class)->billing()->default();
    }

    public function defaultShippingAddress()
    {
        return $this->hasOne(Address::class)->shipping()->default();
    }

    /** ----------------------------
     * ACCESSORS
     * ---------------------------- */

    public function getPrimaryAddressAttribute()
    {
        return $this->defaultBillingAddress ?? $this->billingAddresses()->first();
    }

    public function getLifetimeValueAttribute()
    {
        return $this->successfulTransactions()->sum('amount');
    }

    public function getAverageOrderValueAttribute()
    {
        return $this->completedOrders()->avg('total_amount');
    }

    public function getLeadConversionRateAttribute()
    {
        $totalLeads = $this->leads()->count();
        $convertedLeads = $this->convertedLeads()->count();

        return $totalLeads > 0
            ? round(($convertedLeads / $totalLeads) * 100, 2)
            : 0;
    }
}
