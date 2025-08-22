<?php

namespace Modules\Customers\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Leads\Models\Application;
use Modules\Leads\Models\Lead;
use Modules\Leads\Models\LeadModel;
use Modules\Orders\Models\Order;
use Modules\Orders\Models\Transaction;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'company',
        'position',
        'is_active',
        'last_login_at',
        'email_verified_at'
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's total lifetime value.
     */
    public function getLifetimeValueAttribute()
    {
        return $this->successfulTransactions()
            ->sum('amount');
    }

    /**
     * Get the user's average order value.
     */
    public function getAverageOrderValueAttribute()
    {
        return $this->completedOrders()
            ->avg('total_amount');
    }

    /**
     * Get the user's lead conversion rate.
     */
    public function getLeadConversionRateAttribute()
    {
        $totalLeads = $this->leads()->count();
        $convertedLeads = $this->convertedLeads()->count();

        return $totalLeads > 0 
            ? round(($convertedLeads / $totalLeads) * 100, 2)
            : 0;
    }
}