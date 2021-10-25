<?php

namespace App\Model\Store\Pages;

use App\Model\Guard\UserStore;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [''];

    function category()
    {
        return $this->belongsTo('App\Model\Store\blogs\BlogCategory', 'category_id', 'id');
    }

    function parentPage()
    {
        return $this->belongsTo($this, 'parent_page_id', 'id');
    }

    function user()
    {
        return $this->belongsTo(UserStore::class, 'author_id', 'id');
    }
}
