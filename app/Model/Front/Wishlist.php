<?php

namespace App\Model\Front;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = ['user_id', 'product_item_id'];
}
