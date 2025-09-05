<?php

namespace Modules\Leads\Models;

use Modules\Customers\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Acl\Models\Admin;

class LeadNoteModel extends Model
{
    use HasFactory;

    protected $table = 'lead_notes';
    
    protected $fillable = [
        'lead_id',
        'admin_id',
        'note',
        'is_private'
    ];

    /**
     * Get the lead associated with the note.
     */
    public function lead()
    {
        return $this->belongsTo(LeadModel::class);
    }

    /**
     * Get the admin who created the note.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Scope public notes.
     */
    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    /**
     * Scope private notes.
     */
    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }

    /**
     * Scope notes by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}