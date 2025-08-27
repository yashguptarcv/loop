<?php

namespace Modules\Leads\Models;

use Illuminate\Database\Eloquent\Model;

class LeadStatusModel extends Model
{
    // Table name
    protected $table = 'lead_statuses';

    // Primary key
    protected $primaryKey = 'id';

    // Timestamps
    public $timestamps = false;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'color_code',
        'sort',
        'created_at',
    ];

    /**
     * Get the leads for the status.
     */
    public function leads()
    {
        return $this->hasMany(LeadModel::class);
    }

    /**
     * Get the default status.
     */
    public static function getDefaultStatus()
    {
        return static::where('is_default', true)->first();
    }
}
