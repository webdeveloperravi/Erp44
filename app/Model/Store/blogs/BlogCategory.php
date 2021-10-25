<?php

namespace App\Model\Store\blogs;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    public $fillable = ['status', 'name', 'alias', 'parent'];

    function posts()
    {
        return $this->hasMany('App\Model\Front\Blog_Post', 'category_id', 'id');
    }

    function parent_cat()
    {
        return $this->belongsTo($this, 'parent');
    }
}
