<?php

namespace Modules\Leads\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class TagsModel extends Model
{
    use HasFactory;

    protected $table = 'tags';

    protected $fillable = [
        'name',
        'color',
    ];

    /**
     * Get all of the leads that are assigned this tag.
     */
    public function leads()
    {
        return $this->morphedByMany(\Modules\Leads\Models\LeadModel::class, 'taggable');
    }
}