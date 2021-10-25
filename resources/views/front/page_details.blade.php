@extends('layouts.front.app')

@section('page_title'){{ $page['title'] }} @endsection

@section('page_description') Blog - {{ $page['title'] }} @endsection
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
                                    <li class="breadcrumb-item"><a href="#">Page</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><a class="active"
                                            href="{{ $page['permalink'] }}">{{ $page['title'] }}</a>
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
                </button>
        @endif

        <!-- blog main wrapper start -->
        <div class="blog-main-wrapper section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-md-10 mx-auto order-1">
                        {{-- {{   dd($page['featured_img'])  }}}}}} --}}
                        <div class="blog-item-wrapper">


                            <!-- blog page item start -->
                            <div class="blog-page-item blog-details-page">
                                <h1 class="text-capitalize">{{ $page['title'] }}</h1>
                                <p class="text-capitalize">{{ $page['description'] }}</p>
                                <img src="{{ asset('public/storage/page_featured_imgs/' . $page['featured_img']) }}"
                                    alt="" height="500" style="width: 100%;object-fit:fill;">


                                <div id="content_container">
                                    {!! $page['content'] !!}
                                </div>

                            </div>

                        </div>
                    </div>




                </div>
            </div>
        </div>
        <!-- blog main wrapper end -->
    </main>

@endsection
