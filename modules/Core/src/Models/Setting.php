<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'storefront_id',
        'key',
        'value'
    ];
}