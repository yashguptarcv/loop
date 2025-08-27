<?php

namespace Modules\Leads\Models;

use Modules\Leads\Models\LeadModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadSourceModel extends Model
{
    use HasFactory;

    protected $table = 'lead_sources';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active'
    ];

    /**
     * Get the leads for this source.
     */
    public function leads()
    {
        return $this->hasMany(LeadModel::class);
    }

    /**
     * Scope active sources.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}