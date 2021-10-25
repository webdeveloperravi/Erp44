<?php

namespace App\Model\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Blog_Post extends Model
{
    // use HasFactory;+
    protected $table = 'blog_posts';


    public $fillable = ['userid', 'title', 'description', 'tags', 'permalink', 'allow_comment', 'category_id', 'slug', 'publish', 'content', 'featured_img'];

    function category()
    {
        return $this->belongsTo('App\Model\Store\blogs\BlogCategory', 'category_id', 'id');
    }

    function users()
    {
        return $this->belongsTo('App\Model\Guard\UserStore', 'userid', 'id');
    }

    function comments()
    {
        return $this->hasMany('App\Model\Front\Blog_Comment', 'post_id');
    }

 
}
