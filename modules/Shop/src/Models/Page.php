<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_og_image',
        'view',
        'content',
        'status',
        'route_parameters',
    ];

     /**
     * Use slug instead of ID for route model binding (optional).
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Accessor: Get the full URL of the OG image.
     */
    public function getOgImageUrlAttribute()
    {
        return $this->meta_og_image
            ? asset($this->meta_og_image)
            : asset('images/default-og.jpg');
    }   

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Add your hidden attributes here
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'route_parameters' => 'array',
        'status' => 'string',
    ];

    /**
     * Scope to get only active pages
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to order by title
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('title', 'asc');
    }

    /**
     * Check if page is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get the full URL for this page
     */
    public function getUrlAttribute()
    {
        return $this->slug === '/' ? url('/') : url($this->slug);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        
    }
}