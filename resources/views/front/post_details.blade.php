@extends('layouts.front.app')

@section('page_title'){{ $post['title'] }} @endsection

@section('page_description') Blog - {{ $post['title'] }} @endsection
@section('styles')
    <style>
        #content_container img {
            height: 400px;
            width: 100%;
        }

    </style>
@endsection

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
                                    <li class="breadcrumb-item"><a href="#">blog</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><a class="active"
                                            href="{{ url()->current() }}">{{ $post['title'] }}</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->
        @if (session('message'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('public/front/icons/warning-sign.png') }}" alt="" height="30"
                        class="mr-2">
                    <h4 class="text-center"> {{ session('message') }}!</h4>
                </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </butto @endif

                    <!-- blog main wrapper start -->
                    <div class="blog-main-wrapper section-padding">
                        <div class="container">
                            <div class="row">

                                <div class="col-lg-9 order-1">
                                    {{-- {{   dd($post['featured_img'])  }}}}}} --}}
                                    <div class="blog-item-wrapper">


                                        <!-- blog post item start -->
                                        <div class="blog-post-item blog-details-post">
                                            <h1 class="text-capitalize">{{ $post['title'] }}</h1>
                                            <p class="text-capitalize">{{ $post['description'] }}</p>
                                            <img src="{{ asset('public/storage/blog_featured_imgs/' . $post['featured_img']) }}"
                                                alt="" height="500" style="width: 100%;object-fit:fill;">

                                            <div>
                                                <span
                                                    id="post_time">{{ \Carbon\Carbon::parse($post['created_at'])->format('M d Y') }}</span>
                                                &nbsp|
                                                <span id="post_author" style="color: #c29958;margin-left:10px">
                                                    {{ $post['users']['name'] }}
                                                </span>

                                            </div>
                                            <div id="content_container">
                                                {!! $post['content'] !!}
                                            </div>

                                        </div>
                                        @if ($post['allow_comment'])
                                            <!-- blog post item end -->
                                            @if (count($post['comments']) > 0)
                                                <!-- comment area start -->
                                                <div class="comment-section section-padding">
                                                    <h5>Comments</h5>
                                                    <ul>


                                                        @foreach ($post['comments'] as $comment)
                                                            @php
                                                                $comment_user = $comment->user()->get()[0];
                                                                
                                                            @endphp
                                                            <li>
                                                                {{-- <div class="author-avatar">
                                                    <img src="assets/img/blog/comment-icon.png" alt="">
                                                </div> --}}
                                                                <div class="comment-body">
                                                                    <span class="reply-btn"><a href="#"></a></span>
                                                                    <h5 class="comment-author">
                                                                        {{ $comment_user['name'] }}
                                                                    </h5>
                                                                    <div class="comment-post-date">
                                                                        {{ \Carbon\Carbon::parse($comment['created_at'])->format('M d Y') }}
                                                                    </div>
                                                                    <p>{{ $comment['content'] }}
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        @endforeach



                                                    </ul>
                                                </div>
                                                <!-- comment area end -->
                                            @endif


                                            <!-- start blog comment box -->
                                            <div class="blog-comment-wrapper" style="margin-top: 50px">
                                                <h5>Leave a reply</h5>


                                                <form action="{{ route('9gem_post_comment') }}" style="margin-top:30px"
                                                    method="post">
                                                    @csrf
                                                    <div class="comment-post-box">
                                                        <div class="row">
                                                            <input type="hidden" name="post_id"
                                                                value="{{ $post['id'] }}">
                                                            <input type="hidden" name="user_id"
                                                                value="{{ session('user_id') }}">

                                                            <div class="col-12 my-2">
                                                                <label>Email</label>
                                                                <input type="email" name="email" id="email"
                                                                    placeholder="Email" class="form-control">
                                                                <small class="text-danger">
                                                                    @error('email')
                                                                        {{ $message }}
                                                                    @enderror
                                                                </small>
                                                            </div>

                                                            <div class="col-12">
                                                                <label>Comment</label>
                                                                <textarea name="content"
                                                                    placeholder="Write a comment"></textarea>
                                                                <small class="text-danger">
                                                                    @error('content')
                                                                        {{ $message }}
                                                                    @enderror
                                                                </small>

                                                                <h6 class="text-capitalize ">Note: <small
                                                                        style="color:#c29958">Only
                                                                        Registered
                                                                        users
                                                                        can comment
                                                                        here...</small>
                                                                </h6>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="coment-btn">
                                                                    <input class="btn btn-sqr" type="submit"
                                                                        value="Post Comment">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- start blog comment box -->
                                        @endif
                                    </div>
                                </div>

                                <x-front.sidebar :relatedPosts="$related_posts" />


                            </div>
                        </div>
                    </div>
                    <!-- blog main wrapper end -->
    </main>

@endsection
