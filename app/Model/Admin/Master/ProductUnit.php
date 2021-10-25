<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnit extends Model
{
   use SoftDeletes;

   protected $fillable=['product_type_id', 'name', 'status', 'created_by'];
}
