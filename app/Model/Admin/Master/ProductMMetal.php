<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMMetal extends Model
{
    use SoftDeletes;
    protected $table = 'product_m_metals';
}
