<?php

namespace App\Model\Warehouse;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id','name','url'];

    public function getUrlAttribute($value){
        
        return "public/product_images/".$value;
    }
}
