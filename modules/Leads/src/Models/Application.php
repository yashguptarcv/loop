<?php

namespace Modules\Leads\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Leads\Models\AwardCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customers\Models\User;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'full_name',
        'mobile',
        'email',
        'alternate_contact',
        'organization',
        'designation',
        'billing_address',
        'lead_id',
        'admin_id'
    ];

    protected $casts = [
        'billing_address' => 'array'
    ];

    public function awardCategories()
    {
        return $this->belongsToMany(AwardCategory::class, 'application_award_category')
            ->withTimestamps();
    }

    public function user() {
        return $this->belongsToMany(User::class, 'email');
    }

    public static function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'alternate_contact' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'billing_address.address_line1' => 'nullable|string|max:255',
            'billing_address.address_line2' => 'nullable|string|max:255',
            'billing_address.city' => 'nullable|string|max:255',
            'billing_address.state' => 'nullable|string|max:255',
            'billing_address.postal_code' => 'nullable|string|max:20',
            'billing_address.country' => 'renullablequired|string|max:255',
            'award_categories' => 'nullable|array',
            'award_categories.*' => 'nullable|exists:award_categories,id'
        ];
    }
}
