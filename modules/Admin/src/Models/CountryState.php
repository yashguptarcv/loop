<?php

namespace Modules\Admin\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class CountryState extends Model
{
    protected $fillable = ['country_id', 'country_code', 'code', 'default_name'];

     public $timestamps = false;


    public function country()
    {
        return $this->belongsTo(Country::class, 'id');
    }
}