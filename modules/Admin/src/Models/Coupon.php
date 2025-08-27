<?php

namespace Modules\Admin\Models;

use Modules\Acl\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'name',
        'coupon_code',
        'start_date',
        'end_date',
        'coupon_per_user',
        'coupon_used_count',
        'coupon_type',
        'coupon_value',
        'coupon_status',
        'coupon_message',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Add your hidden attributes here
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        
    }

    /**
     * Get the admin that owns the coupon.
     */
    
}