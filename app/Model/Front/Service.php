<?php

namespace App\Model\Front;

use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\ProductCategory;

class Service extends Model
{
    protected $table = "services";

    function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'category_services', 'service_id', 'category_id');
    }

    function serviceMasters()
    {
        return $this->hasMany(MasterPooja::class);
    }
}
