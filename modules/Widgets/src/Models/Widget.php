<?php

namespace Modules\Widgets\Models;

use Modules\Acl\Models\Role;
use Modules\Core\Models\UserGroup;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $fillable = [
        'title',
        'table_name',
        'column_name',
        'operation',
        'is_currency',
        'revenue_column',
        'cost_column',
        'joins',
        'conditions',
        'date_column',
        'date_filter',
        'date_from',
        'date_to',
        'widget_type',
        'user_groups',
        'group_by'
    ];

    protected $casts = [
        'joins' => 'array',
        'conditions' => 'array',
        'user_groups' => 'array',
        'date_from' => 'date',
        'date_to'   => 'date',
    ];

    public function userGroups() {
        return $this->belongsToMany(Role::class, 'user_group_widget');
    }
}
