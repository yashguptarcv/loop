<?php

namespace Modules\Whatsapp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WhatsAppMessage extends Model
{
    use HasFactory;

    // Explicitly specify the table name
    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'recipient_phone',
        'recipient_name',
        'message_type',
        'message_content',
        'template_name',
        'template_parameters',
        'media_url',
        'media_caption',
        'status',
        'whatsapp_message_id',
        'api_response',
        'error_message',
        'sent_at'
    ];

    protected $casts = [
        'template_parameters' => 'array',
        'api_response' => 'array',
        'sent_at' => 'datetime'
    ];

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByRecipient($query, $phone)
    {
        return $query->where('recipient_phone', $phone);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    public function getFormattedPhoneAttribute()
    {
        return '+' . $this->recipient_phone;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'sent' => 'bg-blue-100 text-blue-800',
            'delivered' => 'bg-green-100 text-green-800',
            'read' => 'bg-purple-100 text-purple-800',
            'failed' => 'bg-red-100 text-red-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}