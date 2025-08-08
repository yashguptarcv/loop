<?php

namespace Modules\Leads\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Acl\Models\Admin;
use Modules\Leads\Models\LeadModel;

class LeadAttachmentModel extends Model
{
    protected $table = 'lead_attachments';

    protected $fillable = [
        'lead_id',
        'admin_id',
        'filename',
        'original_filename',
        'mime_type',
        'size'
    ];

    protected $appends = ['size_for_humans'];

    /**
     * Get the lead that owns the attachment.
     */
    public function lead()
    {
        return $this->belongsTo(LeadModel::class);
    }

    /**
     * Get the admin who uploaded the attachment.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get human readable file size.
     */
    public function getSizeForHumansAttribute()
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $this->size > 1024; $i++) {
            $this->size /= 1024;
        }

        return round($this->size, 2) . ' ' . $units[$i];
    }

    /**
     * Generate a unique filename.
     */
    public static function generateFilename($extension)
    {
        return Str::random(40) . '.' . $extension;
    }
}