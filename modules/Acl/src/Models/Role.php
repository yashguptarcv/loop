<?php

namespace Modules\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'permission_type',
        'permissions',
    ];
      protected $casts = [
        'permissions' => 'array', 
    ];

}