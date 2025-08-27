<?php

namespace Modules\Leads\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadStatusesModels extends Model
{
    use HasFactory;

    protected $table = 'lead_statuses';

    protected $fillable = [
        'name',
        'description',
        'permission_type',
        'permissions',
    ];
}