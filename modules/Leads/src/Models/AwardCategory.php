<?php

namespace Modules\Leads\Models;

use Modules\Admin\Models\Country;
use Modules\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AwardCategory extends Model
{
    use HasFactory;

    protected $table = 'award_categories';

    protected $fillable = [
        'name',
        'country_id',
        'main_category_id',
        'sub_category_id'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function mainCategory()
    {
        return $this->belongsTo(Category::class, 'main_category_id', 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id', 'category_id');
    }

    public function applications()
    {
        return $this->belongsToMany(Application::class, 'application_award_category')
            ->withTimestamps();
    }
}
