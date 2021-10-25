<?php

namespace App\Model\Admin\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class WeightRangeUnitPrice extends Model
{
	use SoftDeletes;
    protected $fillable=['price','status'];
    protected $table='rate_profile_weight_range_unit_rate';

}
