<div>

    <div class="filterLoader" wire:loading>
        <div class="loader">
            <div class="loader-inner">
                <div class="loading one"></div>
            </div>
            <div class="loader-inner">
                <div class="loading two"></div>
            </div>
            <div class="loader-inner">
                <div class="loading three"></div>
            </div>
            <div class="loader-inner">
                <div class="loading four"></div>
            </div>
        </div>
    </div>


    <main x-data>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap">
                            <nav aria-label="breadcrumb">
                                @if ($query == '')
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('9gemhome') }}"><i
                                                    class="fa fa-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $proName ?? '' }}
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">list product items</li>

                                    </ul>
                                @else
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('9gemhome') }}"><i
                                                    class="fa fa-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ __('search') }}
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">"{{ $proName ?? '' }}"
                                        </li>

                                    </ul>
                                @endif
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->
        @if (strlen($query) > 3)
            <div class="head my-2 mt-4">
                <h2 class="text-center text-hero">Showing Search Results</h2>
                <hr class="mx-auto w-50">
            </div>
        @else
            <div class="head my-2 mt-4">
                <h2 class="text-center text-hero">{{ $proName }}</h2>
                <hr class="mx-auto w-50">
            </div>

        @endif


        <!-- page main wrapper start -->
        <div class="shop-main-wrapper section-padding">

            <div class="container">
                <div class="row">

                    <!-- sidebar area start -->
                    <div class="col-lg-3 order-1 order-lg-1">
                        <aside class="sidebar-wrapper">
                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <h5 class="sidebar-title">Products</h5>
                                <div class="sidebar-body">
                                    <ul class="shop-categories">
                                        @foreach ($products ?? [] as $product)
                                            <li>
                                                <a class="{{ $proName == strToLower($product['name']) ? 'bg-hero p-2' : '' }}"
                                                    href="{{ route('9gem_product_items_list', $product['name']) }}">{{ $product['name'] }}</a>
                                            </li>

                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <!-- single sidebar end -->

                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <h5 class="sidebar-title">price</h5>
                                <div class="sidebar-body">
                                    <div class="price-range-wrap">
                                        <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                            data-min="{{ $minRange ?? 500 }}" data-max="{{ $maxRange ?? 500000 }}">
                                            <div class="ui-slider-range ui-corner-all ui-widget-header"
                                                style="left: 0%; width: 100%;"></div><span tabindex="0"
                                                class="ui-slider-handle ui-corner-all ui-state-default"
                                                style="left: 0%;"></span><span tabindex="0"
                                                class="ui-slider-handle ui-corner-all ui-state-default"
                                                style="left: 100%;"></span>
                                        </div>
                                        <div class="range-slider">
                                            <form action="#" class="d-flex align-items-center justify-content-between">
                                                <div class="price-input">
                                                    <label for="amount">Price: </label>
                                                    <input type="text" id="amount" style="max-width: none"
                                                        x-ref="filterAmount">
                                                </div>
                                                <button type="button" class="filter-btn"
                                                    @click="$wire.priceFilter($refs.filterAmount.value)">filter</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single sidebar end -->

                            <!-- single sidebar end -->
                            @if (count($colors) > 0)
                                <!-- single sidebar start -->
                                <div class="sidebar-single">
                                    <h5 class="sidebar-title">color</h5>
                                    <div class="sidebar-body">
                                        <ul class="checkbox-container categories-list">

                                            @foreach ($colors as $color)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="color_{{ $color['color'] }}"
                                                            wire:click="filterColor('{{ $color['id'] }}')">
                                                        <label class="custom-control-label"
                                                            for="color_{{ $color['color'] }}">{{ $color['color'] }}
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                                <!-- single sidebar end -->
                            @endif
                            @if (count($shapes) > 0)
                                <!-- single sidebar start -->
                                <div class="sidebar-single">
                                    <h5 class="sidebar-title">Shapes</h5>
                                    <div class="sidebar-body">
                                        <ul class="checkbox-container categories-list">
                                            @foreach ($shapes as $shape)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="shape_{{ $shape['shape'] }}"
                                                            wire:click="filterShape('{{ $shape['id'] }}')">
                                                        <label class="custom-control-label"
                                                            for="shape_{{ $shape['shape'] }}">{{ $shape['shape'] }}</label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!-- single sidebar end -->
                            @endif

                            <!-- single sidebar start -->
                            <div class="sidebar-banner">
                                <div class="img-container">
                                    <a href="#">
                                        <img src="assets/img/banner/sidebar-banner.jpg" alt="">
                                    </a>
                                </div>
                            </div>
                            <!-- single sidebar end -->
                        </aside>
                    </div>
                    <!-- sidebar area end -->


                    <!-- shop main wrapper start -->
                    <div class="col-lg-9 order-2 order-lg-2">
                        <div class="shop-product-wrapper">
                            <!-- shop product top wrap start -->
                            <div class="shop-top-bar">
                                <div class="row align-items-center">
                                    <div class="col-lg-7 col-md-6 order-2 order-md-1">
                                        <div class="top-bar-left">
                                            <div class="product-view-mode">
                                                <a class="active" href="#" data-target="grid-view"
                                                    data-toggle="tooltip" title="" data-original-title="Grid View"><i
                                                        class="fa fa-th"></i></a>
                                                <a href="#" data-target="list-view" data-toggle="tooltip" title=""
                                                    data-original-title="List View"><i class="fa fa-list"></i></a>
                                            </div>
                                            <div class="product-amount">
                                                @if ($totalProducts > 200)
                                                    <p>Showing 1-200 of {{ $totalProducts }} results</p>
                                                @else
                                                    <p>Showing {{ $totalProducts }} of {{ $totalProducts }}
                                                        results</p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 order-1 order-md-2">
                                        <div class="top-bar-right">
                                            <div class="product-short">

                                                <p>Sort By : </p>
                                                <select class="nice-select" name="sortby" style="display: none;">

                                                    <option value="sales">Name (A - Z)</option>
                                                    <option value="sales">Name (Z - A)</option>
                                                    <option value="rating">Price (Low &gt; High)</option>
                                                    <option value="rating">Price (High &gt; Low)</option>

                                                </select>
                                                <div class="nice-select" tabindex="0"><span
                                                        class="current">{{ $sortType ?? 'None' }}</span>
                                                    <ul class="list">

                                                        <li data-value="sales" class="option"
                                                            @click="$wire.sortFilter($event.target.innerText)">Name
                                                            (A -
                                                            Z)</li>
                                                        <li data-value="sales" class="option"
                                                            @click="$wire.sortFilter($event.target.innerText)">Name
                                                            (Z -
                                                            A)</li>
                                                        <li data-value="rating" class="option"
                                                            @click="$wire.sortFilter($event.target.innerText)">Price
                                                            (Low &gt; High)
                                                        </li>
                                                        <li data-value="rating" class="option"
                                                            @click="$wire.sortFilter($event.target.innerText)">Price
                                                            (High &gt; Low)
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- shop product top wrap start -->
                            @if (count($proItems) > 0)
                                <!-- product item list wrapper start -->
                                <div class="shop-product-wrap grid-view row mbn-30">
                                    {{-- {{ dd($proItems) }} --}}


                                    @foreach ($proItems as $key => $item)

                                        {{-- {{ dd($item) }} --}}

                                        <!-- product single item start -->
                                        <div class="col-md-4 col-sm-6">
                                            <!-- product grid start -->
                                            <div class="product-item">

                                                <figure class="product-thumb">
                                                    <a
                                                        href="{{ route('9gem_product_details', ['product_name' => $item['product_name'], 'product_item_id' => $item['id']]) }}">
                                                        <img class="pri-img"
                                                            src="{{ asset('public/front/assets/front/img/product/gem.jpg') }}"
                                                            alt="product">
                                                        <img class="sec-img"
                                                            src="{{ asset('public/front/assets/front/img/product/gem.jpg') }}"
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
                                                                $wishlishted = \App\Model\Front\Wishlist::where(['user_id' => $user_id, 'product_item_id' => $item['id']])->exists();
                                                                
                                                            @endphp
                                                            @livewire('user-wishlist', ['item_id' =>
                                                            $item['id'],'wishlishted'=>$wishlishted],key('user_wishlist_1_'.$key))

                                                        </div>
                                                    @endif

                                                    <div class="cart-hover">
                                                        @livewire('add-to-cart-button', ['product_qty' =>
                                                        '1','product_id'=>$item['id'],'price' =>
                                                        $item['productPrice']],key('user_addtocart_1_'.$key))

                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <div class="product-identity">
                                                        <p class="manufacturer-name"><a
                                                                href="product-details.html">{{ $item['product_name'] }}</a>
                                                        </p>
                                                    </div>

                                                    <h6 class="product-name">
                                                        <a href="product-details.html">
                                                            {{ $item['product_alias'] }}
                                                            -
                                                            {{ $item['product_grade_alias'] }} -
                                                            {{ $item['product_item_ratti_std'] }}+</a>
                                                    </h6>
                                                    <div class="price-box">
                                                        <span class="price-regular">INR.
                                                            {{ $item['productPrice'] }}</span>
                                                        {{-- <span class="price-old"><del>$70.00</del></span> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- product grid end -->

                                            <!-- product list item end -->
                                            <div class="product-list-item">
                                                <figure class="product-thumb">
                                                    <a href="product-details.html">
                                                        <img class="pri-img"
                                                            src="{{ asset('public/front/assets/front/img/product/gem.jpg') }}"
                                                            alt="product">
                                                        <img class="sec-img"
                                                            src="{{ asset('public/front/assets/front/img/product/gem.jpg') }}"
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
                                                                $wishlishted = \App\Model\Front\Wishlist::where(['user_id' => $user_id, 'product_item_id' => $item['id']])->exists();
                                                            @endphp
                                                            @livewire('user-wishlist', ['item_id' =>
                                                            $item['id'],'wishlishted'=>$wishlishted],key('user_wishlist_2_'.$key))

                                                        </div>
                                                    @endif

                                                    <div class="cart-hover">
                                                        @livewire('add-to-cart-button', ['product_qty' =>
                                                        '1','product_id'=>$item['id'],'price' =>
                                                        $item['productPrice']],key('user_addtocart_2_'.$key))

                                                    </div>

                                                </figure>
                                                <div class="product-content-list">
                                                    <div class="manufacturer-name">
                                                        <a
                                                            href="product-details.html">{{ $item['product_name'] }}</a>
                                                    </div>


                                                    <h5 class="product-name"><a href="product-details.html">
                                                            {{ $item['product_alias'] }}
                                                            -
                                                            {{ $item['product_grade_alias'] }} -
                                                            {{ $item['product_item_ratti_std'] }}+</< /a>
                                                    </h5>
                                                    <div class="price-box">
                                                        <span class="price-regular">INR.
                                                            {{ $item['productPrice'] }}</span>
                                                        {{-- <span class="price-old"><del>$29.99</del></span> --}}
                                                    </div>
                                                    <p style="color:#000">Lorem ipsum dolor sit amet consectetur,
                                                        adipisicing elit. Unde
                                                        perspiciatis
                                                        quod numquam, sit fugiat, deserunt ipsa mollitia sunt quam
                                                        corporis
                                                        ullam
                                                        rem, accusantium adipisci officia eaque.</p>
                                                </div>
                                            </div>
                                            <!-- product list item end -->
                                        </div>
                                        <!-- product single item start -->
                                    @endforeach

                                </div>
                                <!-- product item list wrapper end -->
                                {{-- {{ dd($query) }} --}}
                                @if (strlen($query) < 3)
                                    <a href="{{ route('9gem_product_items_list_catalogue', [$proName, 'page' => 1]) }}"
                                        class="btn btn-hero mx-auto d-block" tabindex="-1"
                                        style="width: 120px;border-radius:0;height:40px">view
                                        all</a>
                                @else
                                    <a href="{{ route('pro_search_catalogue', ['query' => $query, 'page' => 1]) }}"
                                        class="btn btn-hero mx-auto d-block" tabindex="-1"
                                        style="width: 120px;border-radius:0;height:40px">view
                                        all </a>
                                @endif

                            @else

                                @if ($query != '')
                                    <h4 class="text-center my-4">No items found for "{{ $query }}"</h4>

                                @else
                                    <h4 class="text-center my-4">No items found under "{{ $proName }}"</h4>
                                @endif
                            @endif



                        </div>

                    </div>
                    <!-- shop main wrapper end -->

                </div>
            </div>
        </div>
        <!-- page main wrapper end -->

    </main>
</div>
