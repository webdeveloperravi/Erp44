@extends('layouts.front.app')


@section('page_title') account page title @endsection

@section('page_description') account page description @endsection

@section('styles')
    <style>
        .slick-slider .slick-prev,
        .slick-slider .slick-next {
            z-index: 100;
            font-size: 2.5em;
            height: 40px;
            width: 40px;
            margin-top: -20px;
            color: #B7B7B7;
            position: absolute;
            top: 50%;
            text-align: center;
            color: #000;
            opacity: .3;
            transition: opacity .25s;
            cursor: pointer;
        }

        .slick-slider .slick-prev:hover,
        .slick-slider .slick-next:hover {
            opacity: .65;
        }

        .slick-slider .slick-prev {
            left: 0;
        }

        .slick-slider .slick-next {
            right: 0;
        }

        #detail .product-images {
            width: 100%;
            margin: 0 auto;
            border: 1px solid #eee;
        }

        #detail .product-images li,
        #detail .product-images figure,
        #detail .product-images a,
        #detail .product-images img {
            display: block;
            outline: none;
            border: none;
        }

        #detail .product-images .main-img-slider figure {
            margin: 0 auto;
            padding: 0 2em;
        }

        #detail .product-images .main-img-slider figure a {
            cursor: pointer;
            cursor: -webkit-zoom-in;
            cursor: -moz-zoom-in;
            cursor: zoom-in;
        }

        #detail .product-images .main-img-slider figure a img {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        #detail .product-images .thumb-nav {
            margin: 0 auto;
            padding: 20px 10px;
            max-width: 600px;
        }

        #detail .product-images .thumb-nav.slick-slider .slick-prev,
        #detail .product-images .thumb-nav.slick-slider .slick-next {
            font-size: 1.2em;
            height: 20px;
            width: 26px;
            margin-top: -10px;
        }

        #detail .product-images .thumb-nav.slick-slider .slick-prev {
            margin-left: -30px;
        }

        #detail .product-images .thumb-nav.slick-slider .slick-next {
            margin-right: -30px;
        }

        #detail .product-images .thumb-nav li {
            display: block;
            margin: 0 auto;
            cursor: pointer;
        }

        #detail .product-images .thumb-nav li img {
            display: block;
            width: 100%;
            max-width: 75px;
            margin: 0 auto;
            border: 2px solid transparent;
            -webkit-transition: border-color .25s;
            -ms-transition: border-color .25s;
            -moz-transition: border-color .25s;
            transition: border-color .25s;
        }

        #detail .product-images .thumb-nav li:hover,
        #detail .product-images .thumb-nav li:focus {
            border-color: #999;
        }

        #detail .product-images .thumb-nav li.slick-current img {
            border-color: #d12f81;
        }

    </style>

    <style>
        #addOn {
            /* background: #16a085; */
            background: url('../../../public/front/banners/bg1.jpg');
            background-size: cover;
            min-height: 300px;
            width: 100%;
            padding-top: 40px;
            padding-bottom: 40px;

        }

        #addOn table tr select+div,
        #services table tr select+div {
            width: 100%;
        }

        #addOn table th {
            font-size: 1.2rem;
            font-weight: 500;
            text-transform: uppercase;
            color: #bd6a33;
        }



        #addOnSpinner {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

        }

        #addOnSpinner>div {
            height: 4rem !important;
            width: 4rem !important;
        }

        #addTocartBoth {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center
        }

        #addTocartBoth span {
            font-weight: 600;
            font-size: 2rem;
        }

        #addTocartBoth small {
            font-weight: 500;
            font-size: 1rem;
        }

        .number-inp {
            padding-left: 10px;
            padding-right: 10px;
            border-radius: 20px;
            padding: 8px;
            outline: none;
            border: 1px solid gray;
            width: 100px;

        }

        #addOn .content {
            width: 100%;
            height: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        #addOn .nav-pills {
            width: 100%;
        }

        #addOn .nav-item {
            width: 50%;
        }

        #addOn .nav-item img {
            height: 40px;
            width: 40px;
            margin-top: -10px;
            margin-left: 20px;
            object-fit: cover;
        }

        #addOn .nav-pills .nav-link {
            font-weight: bold;
            padding-top: 13px;
            text-align: center;
            background: #fff;
            color: #000;
            border-radius: 30px;
            height: 100px;
        }

        #addOn .nav-pills .nav-link.active {
            background: #343436;
            color: #fff;
        }

        #addOn .tab-content {
            position: relative;
            width: 100%;
            height: 100%;
            margin-top: -50px;
            background: #fff;
            color: #000;
            border-radius: 30px;
            box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.4);
            padding: 10px;
            margin-bottom: 10px;
        }

        #addOn .tab-content button {
            border-radius: 15px;
            width: 100px;
            margin: 0 auto;
            float: right;
        }

    </style>
@endsection


@section('content')
    <livewire:product-details />

@endsection

@section('scripts')

    <script>
        /*--------------*/



        // Main/Product image slider for product page
        $('#detail .main-img-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            fade: true,
            autoplay: true,
            autoplaySpeed: 4000,
            speed: 300,
            lazyLoad: 'ondemand',
            asNavFor: '.thumb-nav',
            prevArrow: '<div class="slick-prev"><i class="i-prev"></i><span class="sr-only sr-only-focusable">Previous</span></div>',
            nextArrow: '<div class="slick-next"><i class="i-next"></i><span class="sr-only sr-only-focusable">Next</span></div>'
        });
        // Thumbnail/alternates slider for product page
        $('.thumb-nav').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            centerPadding: '0px',
            asNavFor: '.main-img-slider',
            dots: false,
            centerMode: false,
            draggable: true,
            speed: 200,
            focusOnSelect: true,
            prevArrow: '<div class="slick-prev"><i class="i-prev"></i><span class="sr-only sr-only-focusable">Previous</span></div>',
            nextArrow: '<div class="slick-next"><i class="i-next"></i><span class="sr-only sr-only-focusable">Next</span></div>'
        });


        //keeps thumbnails active when changing main image, via mouse/touch drag/swipe
        $('.main-img-slider').on('afterChange', function(event, slick, currentSlide, nextSlide) {
            //remove all active class
            $('.thumb-nav .slick-slide').removeClass('slick-current');
            //set active class for current slide
            $('.thumb-nav .slick-slide:not(.slick-cloned)').eq(currentSlide).addClass('slick-current');
        });
    </script>

 


    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    {{-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-60d6f0f1d242103b"></script> --}}

@endsection
