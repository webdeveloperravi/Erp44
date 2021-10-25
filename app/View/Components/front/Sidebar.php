<?php

namespace App\View\Components\front;

use App\Model\Front\Blog_Post;
use Illuminate\View\Component;

class Sidebar extends Component
{

    public $cats = [];
    public $tags = [];
    public $relatedPosts = [];

    public function __construct($relatedPosts = [])
    {

        $this->relatedPosts = $relatedPosts;
        $this->cats = getBlogCategories();
        $tags = Blog_Post::where('publish', 1)->pluck('tags', 'id');
        $arr = [];

        foreach ($tags as $tag) {
            $tagarr = explode(',', $tag);
            $arr[] = $tagarr;
        }

        $this->tags = collect($arr)->collapse()->unique();
    }


    public function render()
    {

        return view('components.front.sidebar');
    }
}
