<div class="col-lg-3 order-2 order-lg-1">
    <aside class="blog-sidebar-wrapper">
        <div class="blog-sidebar">
            <h5 class="title">search</h5>
            <div class="sidebar-serch-form">
                <form action="{{ route('9gem_blog_search') }}" method="get">
                    @csrf
                    <input type="text" class="search-field" placeholder="search here" name="q">
                    <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div> <!-- single sidebar end -->
        <div class="blog-sidebar">
            <h5 class="title">categories</h5>
            <ul class="blog-archive blog-category">
                @foreach ($cats as $cat)
                    <li><a href="{{ route('9gem_allblogs', $cat['id']) }}">{{ $cat['name'] }}</a>
                    </li>

                @endforeach

            </ul>
        </div> <!-- single sidebar end -->
        {{-- {{ dd($relatedPosts) }} --}}
        @if (!empty($relatedPosts))
            <div class="blog-sidebar">
                <h5 class="title">Related posts</h5>
                <div class="recent-post">


                    @foreach ($relatedPosts as $post)

                        <div class="recent-post-item">
                            <figure class="product-thumb">
                                <a
                                    href="{{ route('9gem_blog_details', ['category' => $post['category_id'], 'blog_slug' => $post['slug'], 'blogname' => $post['title']]) }}">
                                    <img src="{{ asset('public/storage/blog_featured_imgs/' . $post['featured_img']) }}"
                                        alt="blog image" height="60" style="object-fit: cover">
                                </a>
                            </figure>
                            <div class="recent-post-description">
                                <div class="product-name">
                                    <h6><a
                                            href="{{ route('9gem_blog_details', ['category' => $post['category_id'], 'blog_slug' => $post['slug'], 'blogname' => $post['title']]) }}">{{ $post['title'] }}</a>
                                    </h6>
                                    <p>{{ $post['updated_at'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach



                </div>
            </div> <!-- single sidebar end -->
        @endif

            @if (count($tags)>0)
            <div class="blog-sidebar">
                <h5 class="title">Tags</h5>
                <ul class="blog-tags">
                    @foreach ($tags as $tag)
                    <li><a href="{{ route('9gem_tag_related_blog',$tag) }}">{{ $tag }}</a></li>
                    @endforeach
              
        
                </ul>
            </div>
            @endif
     

    </aside>
</div>
