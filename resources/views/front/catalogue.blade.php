@extends('layouts.front.app')

@section('page_title') {{ $cat }} Blogs Catalogue @endsection
@section('page_description') {{ $cat }} Blogs Catalogue @endsection

@section('content')
<main>
   
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('9gemhome') }}"><i
                                            class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item " aria-current="page"><a
                                        href="{{ route('9gem_allblogs', $cat_id) }}">{{ $cat }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page" id="current_page_breadcrum">
                                    catalogue
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
    <div class="head mt-5">
        <h2 class="text-center">Catalogue</h2>
        <hr class="w-25 mx-auto">
    </div>
    <!-- blog main wrapper start -->
    <div class="blog-main-wrapper section-padding">
        <div class="container">
            <div class="row">



                <div class="col-lg-12 order-1 order-lg-2">
                    <div class="blog-item-wrapper">
                        <!-- blog item wrapper end -->
                        <div class="row mbn-30 grid">


                            @if (count($posts) > 0)
                                @foreach ($posts as $post)
                                    <div class="col-md-4 grid-item">
                                        <!-- blog post item start -->

                                        <div class="blog-post-item mb-30">
                                            <figure class="blog-thumb">
                                                <a
                                                    href="{{ route('9gem_blog_details', ['category' => $post['category_id'], 'blog_slug' => $post['slug'], 'blogname' => $post['title']]) }}">

                                                    <img src="{{ asset('public/storage/blog_featured_imgs/' . $post['featured_img']) }}"
                                                        alt="blog image" height="300">
                                                </a>
                                            </figure>
                                            <div class="blog-content">
                                                <div class="blog-meta">
                                                    <p> {{ \carbon\carbon::parse($post['updated_at'])->format('D d-F-Y h:i:s') }}|
                                                        <a
                                                            href="{{ route('9gem_blog_details', ['category' => $post['category_id'], 'blog_slug' => $post['slug'], 'blogname' => $post['title']]) }}">
                                                            {{ $post['title'] }}</a>
                                                    </p>
                                                </div>
                                                <h4 class="blog-title">
                                                    <a
                                                        href="{{ route('9gem_blog_details', ['category' => $post['category_id'], 'blog_slug' => $post['slug'], 'blogname' => $post['title']]) }}">
                                                        {{ $post['description'] }}</a>
                                                </h4>
                                            </div>
                                        </div>

                                        <!-- blog post item end -->



                                    </div>
                                @endforeach
                                                                        
                              


                        </div>
                        <div class="page-load-status">
                            <div class="loader-ellips infinite-scroll-request">
                            <span class="loader-ellips__dot"></span>
                            <span class="loader-ellips__dot"></span>
                            <span class="loader-ellips__dot"></span>
                            <span class="loader-ellips__dot"></span>
                            </div>
                            <p class="infinite-scroll-last text-center h2">End of content</p>
                            <p class="infinite-scroll-error text-center h2">No more pages to load</p>
                        </div>
                        <!-- blog item wrapper end -->

                         @else
                        <h2 class="text-center w-100">No post found under this category!!!</h2>
                        @endif



                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- blog main wrapper end -->
  
</main>


@endsection




@section('scripts')



<script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script>
    var elem = document.querySelector('.grid');




    let infScroll = new InfiniteScroll(elem, {
        // options
        path: '?page=@{{#}}',
        append: '.grid-item',
        status: '.page-load-status'
        // history: false,
    });
</script>

    
@endsection

