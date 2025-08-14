<?php

namespace Modules\Catalog\Models;

use Str;
use Modules\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'sku',
        'image',
        'track_stock',
        'stock_quantity',
        'stock_status',
        'stock_notes',
        'status',
        'is_featured'
    ];

    protected $casts = [
        'track_stock' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_HIDDEN = 'hidden';
    const STATUS_ACTIVE = 'active';

    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_HIDDEN => 'Hidden',
            self::STATUS_ACTIVE => 'Active',
        ];
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeVisible($query)
    {
        return $query->where('status', '!=', self::STATUS_HIDDEN);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Many-to-many relationship with categories
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = \Str::slug($product->name);
        });

        static::updating(function ($product) {
            $product->slug = \Str::slug($product->name);
        });
    }
}
