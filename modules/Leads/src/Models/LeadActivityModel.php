<?php

namespace Modules\Leads\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Acl\Models\Admin;

class LeadActivityModel extends Model
{
    use HasFactory;

    protected $table = 'lead_activities';

    protected $fillable = [
        'lead_id',
        'admin_id',
        'type',
        'description',
        'activity_date',
        'duration_minutes',
        'outcome',
        'schedule_meeting'
    ];

    protected $casts = [
        'activity_date' => 'datetime',
    ];

    /**
     * Get the lead associated with the activity.
     */
    public function lead()
    {
        return $this->belongsTo(LeadModel::class);
    }

    /**
     * Get the user who performed the activity.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Scope activities by type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope recent activities.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('activity_date', '>=', now()->subDays($days));
    }
}