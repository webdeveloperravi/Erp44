@php
$store = \App\Model\Guard\UserStore::find(session('account_id'));
$proCategories = getProductCategories();
$products = getOriginalProducts();
$user_id = session('user_id');

@endphp



@extends('layouts.front.app')

@section('page_title') Welcome to {{ $store->company_name }} @endsection
@section('page_description') description @endsection

@section('content')
    <!-- hero slider area start -->
    <section class="slider-area hero-style-five">
        <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">
            <!-- single slider item start -->
            <div class="hero-single-slide hero-overlay">
                <div class="hero-slider-item bg-img"
                    data-bg="{{ asset('public/front/banners/pexels-castorly-stock-3641056.jpg') }}" style="height: 250px">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="hero-slider-content slide-1">
                                    <h4 class="slide-title" style="font-size:3rem">Family Jewellery
                                        <span>Collection</span>
                                    </h4>
                                    <h6 class="slide-desc">Designer Jewellery Necklaces-Bracelets-Earings</h6>
                                    <a href="shop.html" class="btn btn-hero">Explore Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- single slider item start -->

            <!-- single slider item start -->
            <div class="hero-single-slide hero-overlay">
                <div class="hero-slider-item bg-img"
                    data-bg="{{ asset('public/front/banners/pexels-castorly-stock-3641064.jpg') }}" style="height: 250px">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="hero-slider-content slide-2 float-md-right float-none">
                                    <h4 class="slide-title" style="font-size:3rem">Diamonds
                                        Jewellery<span>Collection</span>
                                    </h4>
                                    <h6 class="slide-desc">Shukra Yogam & Silver Power Silver Saving Schemes.</h6>
                                    <a href="shop.html" class="btn btn-hero">Explore Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- single slider item start -->

            <!-- single slider item start -->
            <div class="hero-single-slide hero-overlay">
                <div class="hero-slider-item bg-img"
                    data-bg="{{ asset('public/front/banners/pexels-pixabay-265906.jpg') }}" style="height: 250px">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="hero-slider-content slide-3">
                                    <h4 class="slide-title" style="font-size:3rem">Grace Designer<span>Jewellery</span>
                                    </h4>
                                    <h6 class="slide-desc">Rings, Occasion Pieces, Pandora & More.</h6>
                                    <a href="shop.html" class="btn btn-hero">Explore Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- single slider item end -->
        </div>
    </section>
    <!-- hero slider area end -->


    {{-- <div class="blog-main-wrapper section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">Recommended for you</h2>
                    <hr class="w-50 mx-auto mb-5">
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
                                                    href="{{ route('9gem_blog_details', ['category' => $post['category_id'], 'blog_id' => $post['id'], 'blogname' => $post['title']]) }}">
                                                    <img src="{{ asset('public/storage/blog_featured_imgs/' . $post['featured_img']) }}"
                                                        alt="9gem.com" height="400" style="object-fit: cover">
                                                </a>
                                                </figEXploreure>
                                                <div class="blog-content">
                                                    <div class="blog-meta">
                                                        <p>{{ \Carbon\Carbon::parse($post['updated_at'])->format('M d Y') }}
                                                            | <a
                                                                href="{{ route('9gem_blog_details', ['category' => $post['category_id'], 'blog_id' => $post['id'], 'blogname' => $post['title']]) }}">{{ $post['title'] }}</a>
                                                        </p>
                                                    </div>
                                                    <h4 class="blog-title">
                                                        <a
                                                            href="{{ route('9gem_blog_details', ['category' => $post['category_id'], 'blog_id' => $post['id'], 'blogname' => $post['title']]) }}">{{ $post['description'] }}</a>
                                                    </h4>
                                                </div>
                                        </div>

                                        <!-- blog post item end -->
                                    </div>

                                @endforeach
                            @endif



                        </div>
                    </div>
                    <!-- blog item wrapper end -->






                    <!-- start pagination area -->
                    <div class="paginatoin-area text-center">
                        <ul class="pagination-box">
                            <li><a class="previous" href="#"><i class="pe-7s-angle-left"></i></a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a class="next" href="#"><i class="pe-7s-angle-right"></i></a></li>
                        </ul>
                    </div>
                    <!-- end pagination area -->
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->

    <!-- service policy area start -->
    <div class="service-policy">
        <div class="container">
            <div class="policy-block section-padding">
                <div class="row mtn-30">
                    <div class="col-sm-6 col-lg-3">
                        <div class="policy-item">
                            <div class="policy-icon">
                                <i class="pe-7s-plane"></i>
                            </div>
                            <div class="policy-content">
                                <h6>Free Shipping</h6>
                                <p>Free shipping all order</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="policy-item">
                            <div class="policy-icon">
                                <i class="pe-7s-help2"></i>
                            </div>
                            <div class="policy-content">
                                <h6>Support 24/7</h6>
                                <p>Support 24 hours a day</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="policy-item">
                            <div class="policy-icon">
                                <i class="pe-7s-back"></i>
                            </div>
                            <div class="policy-content">
                                <h6>Money Return</h6>
                                <p>30 days for free return</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="policy-item">
                            <div class="policy-icon">
                                <i class="pe-7s-credit"></i>
                            </div>
                            <div class="policy-content">
                                <h6>100% Payment Secure</h6>
                                <p>We ensure secure payment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- service policy area end -->

    <!-- group product start -->
    <section class="group-product-area section-padding my-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="group-product-banner">
                        <figure class="banner-statistics">
                            <a href="#">
                                <img src="{{ asset('public/front/assets/front/img/banner/img-bottom-banner.jpg') }}"
                                    alt="product banner">
                            </a>
                            <div class="banner-content banner-content_style3 text-center">
                                <h6 class="banner-text1">BEAUTIFUL</h6>
                                <h2 class="banner-text2">Wedding Rings</h2>
                                <a href="shop.html" class="btn btn-text">Shop Now</a>
                            </div>
                        </figure>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories-group-wrapper">
                        <!-- section title start -->
                        <div class="section-title-append">
                            <h4>best seller product</h4>
                            <div class="slick-append"></div>
                        </div>
                        <!-- section title start -->

                        <!-- group list carousel start -->
                        <div class="group-list-item-wrapper">
                            <div class="group-list-carousel">

                                @include('components.front.get_on_sale&best_seller_products',['ledgers'=>$ledgers])




                            </div>
                        </div>
                        <!-- group list carousel start -->
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="categories-group-wrapper">
                        <!-- section title start -->
                        <div class="section-title-append">
                            <h4>on-sale product</h4>
                            <div class="slick-append"></div>
                        </div>
                        <!-- section title start -->

                        <!-- group list carousel start -->
                        <div class="group-list-item-wrapper">
                            <div class="group-list-carousel">



                                @include('components.front.get_on_sale&best_seller_products',['ledgers'=>$ledgers])



                            </div>
                        </div>
                        <!-- group list carousel start -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- group product end -->

    <!-- banner statistics area start -->
    <div class="banner-statistics-area my-4">
        <div class="container">
            <div class="row row-20 mtn-20">
                <div class="col-sm-6">
                    <figure class="banner-statistics mt-20">
                        <a href="#">
                            <img src="{{ asset('public/front/assets/front/img/banner/img1-top.jpg') }}"
                                alt="product banner">
                        </a>
                        <div class="banner-content text-right">
                            <h5 class="banner-text1">BEAUTIFUL</h5>
                            <h2 class="banner-text2">Wedding<span>Rings</span></h2>
                            <a href="shop.html" class="btn btn-text">Shop Now</a>
                        </div>
                    </figure>
                </div>
                <div class="col-sm-6">
                    <figure class="banner-statistics mt-20">
                        <a href="#">
                            <img src="{{ asset('public/front/assets/front/img/banner/img2-top.jpg') }}"
                                alt="product banner">
                        </a>
                        <div class="banner-content text-center">
                            <h5 class="banner-text1">EARRINGS</h5>
                            <h2 class="banner-text2">Tangerine Floral <span>Earring</span></h2>
                            <a href="shop.html" class="btn btn-text">Shop Now</a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!-- banner statistics area end -->

    <!-- product area start -->
    <section class="product-area section-padding my-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">new products</h2>
                        <p class="sub-title">Add our products to weekly lineup</p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-container">
                        <!-- product tab menu start -->
                        <div class="product-tab-menu">
                            <ul class="nav justify-content-center">
                                @foreach ($proCategories as $category)

                                    @if ($category->name == 'GemStone')
                                        @foreach ($category->Product->take(5) as $product)
                                            <li><a href="#{{ str_replace(' ', '', $product->name) }}"
                                                    data-toggle="tab">{{ $product->name }}</a>
                                            </li>
                                        @endforeach

                                    @endif

                                @endforeach

                            </ul>
                        </div>
                        <!-- product tab menu end -->

                        <!-- product tab content start -->
                        <div class="tab-content">

                            @include('components.front.get_tab_products',['ledgers'=>$ledgers])



                        </div>
                        <!-- product tab content end -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product area end -->

    <!-- hot deals area start -->
    <section class="hot-deals section-padding pt-0 my-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Hot deals</h2>
                        <p class="sub-title">Add featured products to weekly lineup</p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="deals-carousel-active--two slick-row-10 slick-arrow-style" id="hotdealsproducts">


                        @include('components.front.get-products', ['ledgers' => $ledgers])


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- hot deals area end -->






    <!-- hot deals area start -->
    <section class="hot-deals section-padding pt-0 my-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Featured Products</h2>
                        <p class="sub-title">Add featured products to weekly lineup</p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="deals-carousel-active--two slick-row-10 slick-arrow-style" id="hotdealsproducts">

                        @include('components.front.get-products', ['ledgers' => $ledgers])

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- hot deals area end -->

    <!-- testimonial area start -->
    <section class="testimonial-area my-4">
        <div class="container">
            <div class="testimonial-bg section-padding bg-img" data-bg="assets/img/testimonial/testimonials-bg.jpg">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">testimonials</h2>
                            <p class="sub-title">What they say</p>
                        </div>
                        <!-- section title start -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="testimonial-thumb-wrapper">
                            <div class="testimonial-thumb-carousel">
                                <div class="testimonial-thumb">
                                    <img src="{{ asset('public/front/assets/front/img/testimonial/testimonial-1.png') }}"
                                        alt="testimonial-thumb">
                                </div>
                                <div class="testimonial-thumb">
                                    <img src="{{ asset('public/front/assets/front/img/testimonial/testimonial-2.png') }}"
                                        alt="testimonial-thumb">
                                </div>
                                <div class="testimonial-thumb">
                                    <img src="{{ asset('public/front/assets/front/img/testimonial/testimonial-3.png') }}"
                                        alt="testimonial-thumb">
                                </div>
                                <div class="testimonial-thumb">
                                    <img src="{{ asset('public/front/assets/front/img/testimonial/testimonial-2.png') }}"
                                        alt="testimonial-thumb">
                                </div>
                            </div>
                        </div>
                        <div class="testimonial-content-wrapper">
                            <div class="testimonial-content-carousel">
                                <div class="testimonial-content">
                                    <p>Vivamus a lobortis ipsum, vel condimentum magna. Etiam id turpis tortor. Nunc
                                        scelerisque, nisi a blandit varius, nunc purus venenatis ligula, sed
                                        venenatis orci augue nec sapien. Cum sociis natoque</p>
                                    <div class="ratings">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                    </div>
                                    <h5 class="testimonial-author">lindsy niloms</h5>
                                </div>
                                <div class="testimonial-content">
                                    <p>Vivamus a lobortis ipsum, vel condimentum magna. Etiam id turpis tortor. Nunc
                                        scelerisque, nisi a blandit varius, nunc purus venenatis ligula, sed
                                        venenatis orci augue nec sapien. Cum sociis natoque</p>
                                    <div class="ratings">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                    </div>
                                    <h5 class="testimonial-author">Daisy Millan</h5>
                                </div>
                                <div class="testimonial-content">
                                    <p>Vivamus a lobortis ipsum, vel condimentum magna. Etiam id turpis tortor. Nunc
                                        scelerisque, nisi a blandit varius, nunc purus venenatis ligula, sed
                                        venenatis orci augue nec sapien. Cum sociis natoque</p>
                                    <div class="ratings">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                    </div>
                                    <h5 class="testimonial-author">Anamika lusy</h5>
                                </div>
                                <div class="testimonial-content">
                                    <p>Vivamus a lobortis ipsum, vel condimentum magna. Etiam id turpis tortor. Nunc
                                        scelerisque, nisi a blandit varius, nunc purus venenatis ligula, sed
                                        venenatis orci augue nec sapien. Cum sociis natoque</p>
                                    <div class="ratings">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                    </div>
                                    <h5 class="testimonial-author">Maria Mora</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- testimonial area end -->




    <!-- product banner statistics area start -->
    <section class="product-banner-statistics my-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-banner-carousel slick-row-10">


                        @foreach ($products as $product)

                            <!-- banner single slide start -->
                            <div class="banner-slide-item">
                                <figure class="banner-statistics">
                                    <a href="{{ route('9gem_product_items_list', $product->name) }}">
                                        <img src="{{ asset('public/front/assets/front/img/banner/img1-middle.jpg') }}"
                                            alt="product banner">
                                    </a>
                                    <div class="banner-content banner-content_style2">
                                        <h5 class="banner-text3"><a
                                                href="{{ route('9gem_product_items_list', $product->name) }}">{{ $product->name }}</a>
                                        </h5>
                                    </div>
                                </figure>
                            </div>
                            <!-- banner single slide start -->
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product banner statistics area end -->

    <!-- brand logo area start -->
    <div class="brand-logo section-padding my-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="brand-logo-carousel slick-row-10 slick-arrow-style">
                        <!-- single brand start -->
                        <div class="brand-item">
                            <a href="#">
                                <img src="{{ asset('public/front/assets/front/img/brand/1.png') }}" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class=" brand-item">
                            <a href="#">
                                <img src="{{ asset('public/front/assets/front/img/brand/2.png') }}" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class=" brand-item">
                            <a href="#">
                                <img src="{{ asset('public/front/assets/front/img/brand/3.png') }}" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class=" brand-item">
                            <a href="#">
                                <img src="{{ asset('public/front/assets/front/img/brand/4.png') }}" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class=" brand-item">
                            <a href="#">
                                <img src="{{ asset('public/front/assets/front/img/brand/5.png') }}" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->

                        <!-- single brand start -->
                        <div class=" brand-item">
                            <a href="#">
                                <img src="{{ asset('public/front/assets/front/img/brand/6.png') }}" alt="">
                            </a>
                        </div>
                        <!-- single brand end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- brand logo area end -->
    </main>
@endsection
