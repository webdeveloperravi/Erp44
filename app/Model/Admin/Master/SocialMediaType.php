<?php

namespace App\Model\Admin\Master;

use App\Model\Store\SocialMedia;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\MasterCreateUpdate;

class SocialMediaType extends Model
{
    protected $guarded = [''];

    public function masterIds()
    {
        return $this->morphMany(MasterCreateUpdate::class, 'masterable');
    }


    public function socialMedias()
    {
        return $this->hasMany(SocialMedia::class,'social_media_type_id','id');
    }
}
