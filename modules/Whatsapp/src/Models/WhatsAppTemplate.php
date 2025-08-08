<?php

namespace Modules\Whatsapp\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppTemplate extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_templates';

    protected $fillable = [
        'name',
        'category',
        'language',
        'header_text',
        'header_type',
        'header_image_url',
        'header_video_url',
        'header_document_url',
        'body_text',
        'body_examples',
        'footer_text',
        'buttons',
        'status',
        'template_id',
        'api_response',
        'rejection_reason'
    ];

    protected $casts = [
        'buttons' => 'array',
        'api_response' => 'array',
        'body_examples' => 'array'
    ];

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'in_appeal' => 'bg-purple-100 text-purple-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getFormattedNameAttribute()
    {
        return str_replace('_', ' ', $this->name);
    }

    public function getButtonsCountAttribute()
    {
        return is_array($this->buttons) ? count($this->buttons) : 0;
    }

    public function hasMediaHeader()
    {
        return in_array($this->header_type, ['image', 'video', 'document']);
    }

    public function getHeaderMediaUrlAttribute()
    {
        switch ($this->header_type) {
            case 'image':
                return $this->header_image_url;
            case 'video':
                return $this->header_video_url;
            case 'document':
                return $this->header_document_url;
            default:
                return null;
        }
    }
}