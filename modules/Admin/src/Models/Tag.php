<?php

namespace Modules\Admin\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    protected $table = 'tags'; 
    protected $fillable = ['name', 'color'];
    
    public $timestamps = true;
}