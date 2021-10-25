<?php

namespace App\Model\Store;

use App\Model\Store\Lead;
use Illuminate\Database\Eloquent\Model;
use App\Model\Admin\Master\SocialMediaType;

class SocialMedia extends Model
{
    protected $guarded = [''];
    public $table ='social_medias';

    public function mediaType()
    {
        return $this->belongsTo(SocialMediaType::class,'social_media_type_id','id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class,'lead_id','id');
    }
}
