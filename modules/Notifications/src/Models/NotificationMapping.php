<?php

namespace Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationMapping extends Model
{
    protected $fillable = [
        'event_id',
        'channel_id', // Changed from channel_name to channel_id for proper relation
        'notify_admin',
        'notify_customer',
        'template_id',
        'config'
    ];

    protected $casts = [
        'config' => 'array',
        'notify_admin' => 'boolean',
        'notify_customer' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(NotificationEvent::class, 'event_id');
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(NotificationChannel::class, 'channel_id');
    }

    public function scopeForChannel($query, $channelId)
    {
        return $query->where('channel_id', $channelId);
    }
}