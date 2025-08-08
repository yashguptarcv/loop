<?php

namespace Modules\Leads\Models;

use Modules\Acl\Models\Admin;
use Modules\Customers\Models\User;
use Modules\Leads\Models\TagsModel;
use Illuminate\Database\Eloquent\Model;
use Modules\Leads\Models\LeadNoteModel;
use Modules\Leads\Models\LeadSourceModel;
use Modules\Leads\Models\LeadStatusModel;
use Modules\Leads\Models\LeadActivityModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Leads\Models\LeadAttachmentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'leads';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'description',
        'value',
        'status_id',
        'source_id',
        'assigned_to',
        'created_by'
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];

    // In LeadModel
    public function status()
    {
        return $this->belongsTo(LeadStatusModel::class, 'status_id', 'id');
    }

    public function source()
    {
        return $this->belongsTo(LeadSourceModel::class, 'source_id', 'id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(Admin::class, 'assigned_to', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function activities()
    {
        return $this->hasMany(LeadActivityModel::class, 'lead_id')->latest();
    }

    public function notes()
    {
        return $this->hasMany(LeadNoteModel::class, 'lead_id')->latest();
    }

    public function attachments()
    {
        return $this->hasMany(LeadAttachmentModel::class, 'lead_id')->latest();
    }

    public function syncTags(array|string $tags)
    {
        // Convert string input to array (if tags come as comma-separated string)
        if (is_string($tags)) {
            $tags = explode(',', $tags);
            $tags = array_map('trim', $tags);
        }

        // Prepare tag IDs - create new tags if they don't exist
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = TagsModel::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        // Sync the tags
        $this->tags()->sync($tagIds);
    }

    public function tags()
    {
        return $this->morphToMany(
            TagsModel::class,       // Related model
            'taggable',       // Polymorphic relationship name
            'taggables',      // Pivot table name (optional if following Laravel conventions)
            'taggable_id',    // Foreign key on pivot table
            'tag_id'          // Related key on pivot table
        );
    }
}
