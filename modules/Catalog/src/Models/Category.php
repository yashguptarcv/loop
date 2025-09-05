<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'image',
        'status',
        'position',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Parent category relationship
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Child categories relationship
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
