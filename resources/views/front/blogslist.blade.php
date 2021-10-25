@extends('layouts.front.app')

@section('page_title') {{ $current_page }} Blogs @endsection

@section('page_description') Blogs list all description @endsection

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

                                    <li class="breadcrumb-item active" aria-current="page" id="current_page_breadcrum">
                                        <a href="{{ url()->current() }}"> {{ $current_page }}</a>
                                    </li>
                                    <li class="breadcrumb-item " aria-current="page">Blogs</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->
        <div class="head my-2 mt-4">
            <h1 class="text-center">Blogs </h1>
            <h6 class="text-hero text-center" style="font-weight: 450">{{ $current_page }}</h6>
            <hr class="mx-auto w-50">
        </div>
        <!-- blog main wrapper start -->
        <div class="blog-main-wrapper section-padding">
            <div class="container">
                <div class="row">


                    <x-front.sidebar />

                    <div class="col-lg-9 order-1 order-lg-2">
                        <div class="blog-item-wrapper">
                            <!-- blog item wrapper end -->
                            <div class="row mbn-30">


                                @if (count($posts) > 0)
                                    @foreach ($posts as $post)
                                        <div class="col-md-6">
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
                            <a href="{{ route('9gem_blog_catalogue', [$post['category_id'], 'page' => 1]) }}"
                                class="btn btn-hero mx-auto d-block" tabindex="-1"
                                style="width: 120px;border-radius:0;height:40px">view
                                all</a>

                        @else
                            <h3 class="text-center w-100 text-hero" style="font-weight: 450">No Blogs found under
                                "{{ $current_page }}"!
                            </h3>
                            @endif





                            <!-- blog item wrapper end -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- blog main wrapper end -->
    </main>


@endsection
