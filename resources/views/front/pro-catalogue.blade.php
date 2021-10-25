@extends('layouts.front.app')

@section('page_title') {{ $proName  }} Catalogue @endsection
@section('page_description') {{ $proName }} Catalogue @endsection

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
                                        href="{{ route('9gem_product_items_list', $proName) }}">{{ $proName }}</a></li>
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
        <h2 class="text-center text-uppercase">{{ $proName }} Catalogue</h2>
        <hr class="w-25 mx-auto">
    </div>
  
                       <div class="container">
                                <!-- product item list wrapper start -->
                                <div class="shop-product-wrap grid-view row mbn-30 grid">
                                    {{-- {{ dd($proItems) }} --}}
                                    @if (count($proItems) > 0)
                                        @foreach ($proItems as $item)
                                            @php
                                                
                                                $rateProfileId = App\Helpers\Helper::getRateProfile($item->product_id, $item->grade_id);
                                                $productPrice = App\Helpers\Helper::getProductPrice($item->weight, $rateProfileId);
                                                
                                            @endphp
                                            <!-- product single item start -->
                                            <div class="col-md-4 col-sm-6 grid-item">
                                                <!-- product grid start -->
                                                <div class="product-item">
                                                    <figure class="product-thumb">
                                                        <a href="product-details.html">
                                                            <img class="pri-img"
                                                                src="{{ asset('public/front/assets/front/img/product/product-6.jpg') }}"
                                                                alt="product">
                                                            <img class="sec-img"
                                                                src="{{ asset('public/front/assets/front/img/product/product-13.jpg') }}"
                                                                alt="product">
                                                        </a>
                                                        <div class="product-badge">
                                                            <div class="product-label new">
                                                                <span>new</span>
                                                            </div>
                                                            <div class="product-label discount">
                                                                <span>10%</span>
                                                            </div>
                                                        </div>
                                                        @if (session('user_login'))
                                                        <div class="button-group">
                                                            @php
                                                             $user_id = session('user_id');
                                                                $wishlishted = \App\Model\Front\Wishlist::where(['user_id' => $user_id, 'product_item_id' => $item->id])->exists();
                                                            @endphp
                            
                                                            @livewire('user-wishlist', ['item_id' =>
                                                            $item->id,'wishlishted'=>$wishlishted],key($key))
                            
                                                        </div>
                                                        @endif
                                      
                                                        <div class="cart-hover">
                                                            @livewire('add-to-cart-button', ['product_qty' =>
                                                            '1','product_id'=>$item['id'],'price' =>
                                                            $productPrice],key($key))
                            
                                                        </div>
                                                    </figure>
                                                    <div class="product-caption text-center">
                                                        <div class="product-identity">
                                                            <p class="manufacturer-name"><a
                                                                    href="product-details.html">{{ $item->product->name }}</a>
                                                            </p>
                                                        </div>
                                                        {{-- <ul class="color-categories">
                                                            <li>
                                                                <a class="c-lightblue" href="#" title="LightSteelblue"></a>
                                                            </li>
                                                            <li>
                                                                <a class="c-darktan" href="#" title="Darktan"></a>
                                                            </li>
                                                            <li>
                                                                <a class="c-grey" href="#" title="Grey"></a>
                                                            </li>
                                                            <li>
                                                                <a class="c-brown" href="#" title="Brown"></a>
                                                            </li>
                                                        </ul> --}}
                                                        <h6 class="product-name">
                                                            <a href="product-details.html">
                                                                {{ $item->product->alias }}
                                                                -
                                                                {{ $item->productGrade->alias }} -
                                                                {{ $item->ratti->rati_standard }}+</a>
                                                        </h6>
                                                        <div class="price-box">
                                                            <span class="price-regular">INR. {{ $productPrice }}</span>
                                                            {{-- <span class="price-old"><del>$70.00</del></span> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- product grid end -->
    
                                              
                                            </div>
                                            <!-- product single item start -->
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
                                <h2>No item found</h2>
                                @endif
        
                                <!-- product item list wrapper end -->
                       </div>
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

