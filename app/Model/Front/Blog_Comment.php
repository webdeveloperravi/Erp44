<?php

namespace App\Model\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog_Comment extends Model
{
    // use HasFactory;
    protected $table = 'blog_comments';

    protected $fillable = ['user_id', 'post_id', 'content'];

    function post()
    {
        return $this->belongsTo('App\Model\Front\Blog_post');
    }

    function user()
    {
        return $this->belongsTo('App\Model\Guard\UserStore', 'user_id');
    }

   
}
