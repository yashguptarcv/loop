<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Leads\Models\AwardCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    protected $fillable = ['code', 'name'];

    public function countryStates()
    {
        return $this->hasMany(CountryState::class, 'country_id');
    }

    public function awardCategories()
    {
        return $this->hasMany(AwardCategory::class);
    }
    public $timestamps = false;
}
