<?php

namespace App\Model\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoutubeUpload extends Model
{
    // use HasFactory;
    public $table = 'youtube_uploads';
    protected $fillable = ['username', 'email', 'uploaded_video_id'];
}
