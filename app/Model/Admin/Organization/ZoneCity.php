<?php

namespace App\Model\Admin\Organization;

use App\Model\Admin\Organization\Zone;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\MasterCreateUpdate;

class ZoneCity extends Model
{
    protected $table = 'zone_city';

    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }
}
