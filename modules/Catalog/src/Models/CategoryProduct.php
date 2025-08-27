<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'category_product';

    protected $fillable = [        
        'category_id',
        'product_id',
    ];
}
