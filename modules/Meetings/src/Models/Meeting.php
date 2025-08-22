<?php

namespace Modules\Meetings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    use HasFactory;

    protected $table = 'meetings';

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'google_calendar_id',
        'google_event_id',
        'admin_id'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    
    protected $dates = ['start_time', 'end_time'];

}