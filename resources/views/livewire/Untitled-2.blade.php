<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">product details</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding pb-0">
        <div class="container">
            <div class="row">
                <!-- product details wrapper start -->
                <div class="col-lg-12 order-1 order-lg-2">
                    <!-- product details inner end -->
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-5">
                                <section id="detail">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-11 mx-auto">
                                                <!-- Product Images & Alternates -->
                                                <div class="product-images demo-gallery">
                                                    <!-- Begin Product Images Slider -->
                                                    <div class="main-img-slider">
                                                        <a data-fancybox="gallery" href=""><img src=""
                                                                class="img-fluid"></a>
                                                        <a data-fancybox="gallery" href=""><img src=""
                                                                class="img-fluid"></a>

                                                    </div>
                                                    <!-- End Product Images Slider -->

                                                    <!-- Begin product thumb nav -->
                                                    <ul class="thumb-nav">
                                                        <li><img src="">
                                                        </li>
                                                        <li><img src="">
                                                        </li>

                                                    </ul>
                                                    <!-- End product thumb nav -->
                                                </div>
                                                <!-- End Product Images & Alternates -->

                                            </div>
                                        </div>
                                    </div>
                                </section>




                            </div>
                            <div class="col-lg-7" id="product_item_main">
                                <div class="product-details-des">
                                    <div class="manufacturer-name">
                                        <a
                                            href="{{ route('9gem_product_items_list', $proName) }}">{{ $proName }}</a>
                                    </div>
                                    {{-- {{ dd($proItem) }} --}}
                                    <h3 class="product-name">
                                        {{ $proItem['product_alias'] }} - {{ $proItem['product_grade_alias'] }}
                                        -
                                        {{ $proItem['product_item_ratti_std'] }}+
                                    </h3>
                                    <div class="ratings d-flex">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <div class="pro-review">
                                            <span>1 Reviews</span>
                                        </div>
                                    </div>
                                    <div class="price-box">
                                        <span class="price-regular">INR. {{ $proItem['productPrice'] }}</span>
                                        {{-- <span class="price-old"><del>$90.00</del></span> --}}
                                    </div>


                                    <div class="availability">
                                        @if ($proItem['status'])
                                            <i class="fa fa-check-circle"></i>
                                            <span>In stock</span>
                                        @else
                                            <i class="fa fa-times" style="color:red"></i>
                                            <span>Out Of stock</span>
                                        @endif

                                    </div>

                                    <div class="pro-size">
                                        <h6 class="option-title">Shape : {{ $proItem['shape'] }}</h6>

                                    </div>
                                    <div class="color-option">
                                        <h6 class="option-title">color : {{ $proItem['color'] }}</h6>

                                    </div>
                                    <p class="pro-desc">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                        diam nonumy
                                        eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                                        voluptua. Phasellus id nisi quis justo tempus mollis sed et dui. In hac
                                        habitasse platea dictumst.</p>

                                    @if (count($services) > 0)

                                        <div id="services">
                                            <table class="table table-stripped">


                                                @foreach ($services as $key => $service)


                                                    <tr>
                                                        <th>
                                                            <h4 class="text-hero text-uppercase"
                                                                style="font-weight: 500">
                                                                {{ $key }}</h4>
                                                        </th>
                                                        <td class="">
                                                            <select class="form-control " style="width: 100%"
                                                                id="exampleFormControlSelect1"
                                                                onchange="getServices(this.value)">
                                                                <option value="" selected>Select Here...</option>
                                                                @foreach ($service as $val)
                                                                    <option
                                                                        value="{{ $key }},{{ $val['id'] }}">
                                                                        {{ $val['name'] }}</option>
                                                                @endforeach

                                                            </select>
                                                        </td>
                                                    </tr>

                                                @endforeach


                                            </table>
                                        </div>

                                    @endif
                                    <div class="quantity-cart-box d-flex align-items-center">
                                        <h6 class="option-title">qty:</h6>
                                        <div>
                                            <input type="number" value="1" class="number-inp">
                                        </div>
                                        <div class="action_link ml-4">
                                            <button type="button" wire:click="addToCartInit">Add to Cart</button>
                                        </div>
                                        <div class="useful-links ml-4 mt-2">

                                            <a href="#" data-toggle="tooltip" title="" data-original-title="Wishlist"><i
                                                    class="pe-7s-like "></i>wishlist</a>

                                        </div>

                                    </div>










                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details inner end -->

                    {{-- <div class="addOn my-4">
                        <h2 class="text-hero text-center ">Our Customers Frequently Buy this item<br /> with
                            One
                            of These Products..</h2>
                        <hr class="w-25 mx-auto">
                    </div>
                    <!--add ons-->
                    <section id="addOn" class="position-relative ">
                        <!--spinner-->
                        <div id="addOnSpinner" class="position-absolute">
                            <div class="spinner-border text-light" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>

                            <div class="col-md-3">
                                <div id="addTocartBoth">
                                    <div class="my-2 d-block" id="product1">
                                        <a href="#product_item_main"><img
                                                src="https://source.unsplash.com/840x480/?nature,water" alt="pic1"
                                                height="150" width="150">

                                        </a>
                                        <small class="product-name d-block text-dark text-center">
                                            {{ $proItem['product_alias'] }} -
                                            {{ $proItem['product_grade_alias'] }} -
                                            {{ $proItem['product_item_ratti_std'] }}+
                                        </small>

                                    </div>
                                    <span>
                                        +
                                    </span>
                                    <div class="my-2" id="product2">
                                        <img src="{{ asset('public/front/assets/front/img/product/product-1.jpg') }}"
                                            alt="pic2" height="150" width="150">
                                        <small class="product-name d-block text-dark text-center">
                                            {{ $proItem['product_alias'] }} -
                                            {{ $proItem['product_grade_alias'] }} -
                                            {{ $proItem['product_item_ratti_std'] }}+
                                        </small>

                                    </div>
                                    <div class="my-2">
                                        <button id="addToCartBoth" type="button"
                                            class="btn btn-dark text-light p-2 cursor-pointer ">
                                            Add To Cart
                                            Both
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 ">
                                <div class="">

                                    <div class="content bg-dark text-light" style="min-height: 300px;">
                                        <h4 class="text-center text-capitalize text-hero my-4">Select a Item</h4>

                                        <table class="table table-stripped text-light">
                                            <tr>
                                                <div class="product-carousel-4 slick-row-12 slick-arrow-style">

                                                    @foreach (range(10, 0) as $productItem)

                                                        <!-- product item start -->
                                                        <div class="product-item">
                                                            <figure class="product-thumb">
                                                                <a href="#">
                                                                    <img class="pri-img"
                                                                        src="{{ asset('public/front/assets/front/img/product/product-1.jpg') }}"
                                                                        alt="product">
                                                                    <img class="sec-img"
                                                                        src="{{ asset('public/front/assets/front/img/product/product-18.jpg') }}"
                                                                        alt="product">
                                                                </a>
                                                                <div class="button-group">
                                                                    <a href="#" data-toggle="tooltip"
                                                                        data-placement="left" title="Add This Item"><i
                                                                            class="pe-7s-plus"></i></a>

                                                                </div>



                                                            </figure>


                                                        </div>
                                                        <!-- product item end -->

                                                    @endforeach





                                                </div>
                                            </tr>
                                            <tr>
                                                <th>

                                                </th>
                                                <th class="d-flex justify-content-end">
                                                    <button id="resetAddOn" class="btn btn-light"
                                                        style="background: #fff;padding:5px">Reset Changes</button>
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-1"></div>
                        </div>


                        <!--/add ons-->
                    </section> --}}

                    <!-- product details reviews start -->
                    <div class="product-details-reviews section-padding pb-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-review-info">
                                    <ul class="nav review-tab">
                                        <li>
                                            <a class="active" data-toggle="tab" href="#tab_one">description</a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_two">information</a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_three">reviews (1)</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content reviews-tab">
                                        <div class="tab-pane fade show active" id="tab_one">
                                            <div class="tab-one">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam
                                                    fringilla augue nec est tristique auctor. Ipsum metus feugiat
                                                    sem, quis fermentum turpis eros eget velit. Donec ac tempus
                                                    ante. Fusce ultricies massa massa. Fusce aliquam, purus eget
                                                    sagittis vulputate, sapien libero hendrerit est, sed commodo
                                                    augue nisi non neque.Cras neque metus, consequat et blandit et,
                                                    luctus a nunc. Etiam gravida vehicula tellus, in imperdiet
                                                    ligula euismod eget. Pellentesque habitant morbi tristique
                                                    senectus et netus et malesuada fames ac turpis egestas. Nam
                                                    erat mi, rutrum at sollicitudin rhoncus</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab_two">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>color</td>
                                                        <td>black, blue, red</td>
                                                    </tr>
                                                    <tr>
                                                        <td>size</td>
                                                        <td>L, M, S</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="tab_three">
                                            <form action="#" class="review-form">
                                                <h5>1 review for <span>Chaz Kangeroo</span></h5>
                                                <div class="total-reviews">
                                                    <div class="rev-avatar">
                                                        <img src="assets/img/about/avatar.jpg" alt="">
                                                    </div>
                                                    <div class="review-box">
                                                        <div class="ratings">
                                                            <span class="good"><i class="fa fa-star"></i></span>
                                                            <span class="good"><i class="fa fa-star"></i></span>
                                                            <span class="good"><i class="fa fa-star"></i></span>
                                                            <span class="good"><i class="fa fa-star"></i></span>
                                                            <span><i class="fa fa-star"></i></span>
                                                        </div>
                                                        <div class="post-author">
                                                            <p><span>admin -</span> 30 Mar, 2019</p>
                                                        </div>
                                                        <p>Aliquam fringilla euismod risus ac bibendum. Sed sit
                                                            amet sem varius ante feugiat lacinia. Nunc ipsum nulla,
                                                            vulputate ut venenatis vitae, malesuada ut mi. Quisque
                                                            iaculis, dui congue placerat pretium, augue erat
                                                            accumsan lacus</p>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span>
                                                            Your Name</label>
                                                        <input type="text" class="form-control" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span>
                                                            Your Email</label>
                                                        <input type="email" class="form-control" required="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span>
                                                            Your Review</label>
                                                        <textarea class="form-control" required=""></textarea>
                                                        <div class="help-block pt-10"><span
                                                                class="text-danger">Note:</span>
                                                            HTML is not translated!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span>
                                                            Rating</label>
                                                        &nbsp;&nbsp;&nbsp; Bad&nbsp;
                                                        <input type="radio" value="1" name="rating">
                                                        &nbsp;
                                                        <input type="radio" value="2" name="rating">
                                                        &nbsp;
                                                        <input type="radio" value="3" name="rating">
                                                        &nbsp;
                                                        <input type="radio" value="4" name="rating">
                                                        &nbsp;
                                                        <input type="radio" value="5" name="rating" checked="">
                                                        &nbsp;Good
                                                    </div>
                                                </div>
                                                <div class="buttons">
                                                    <button class="btn btn-sqr" type="submit">Continue</button>
                                                </div>
                                            </form> <!-- end of review-form -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details reviews end -->
                </div>
                <!-- product details wrapper end -->
            </div>
        </div>
    </div>
    <!-- page main wrapper end -->

    <!-- related products area start -->
    <section class="related-products section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section title start -->
                    <div class="section-title text-center">
                        <h2 class="title">Related Products</h2>
                        <p class="sub-title">Add related products to weekly lineup</p>
                    </div>
                    <!-- section title start -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-4 slick-row-10 slick-arrow-style">

                        @foreach ($relatedProItems as $productItem)
                            @php
                                
                                $rateProfileId = App\Helpers\Helper::getRateProfile($productItem->product_id, $productItem->grade_id);
                                $productPrice = App\Helpers\Helper::getProductPrice($productItem->weight, $rateProfileId);
                                
                            @endphp
                            <!-- product item start -->
                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a
                                        href="{{ route('9gem_product_details', ['product_name' => $productItem->product->name, 'product_item_id' => $productItem->id]) }}">
                                        <img class="pri-img"
                                            src="{{ asset('public/front/assets/front/img/product/product-1.jpg') }}"
                                            alt="product">
                                        <img class="sec-img"
                                            src="{{ asset('public/front/assets/front/img/product/product-18.jpg') }}"
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
                                    <div class="button-group">
                                        <a href="wishlist.html" data-toggle="tooltip" data-placement="left"
                                            title="Add to wishlist"><i class="pe-7s-like"></i></a>

                                    </div>
                                    <div class="cart-hover">
                                        @php
                                            $no = rand(111, 999);
                                        @endphp
                                        {{-- <livewire:add-to-cart-button :product_qty="1" :product_id="$productItem['id']"
                                            :price="$productPrice" :key="$no" /> --}}
                                        @livewire('add-to-cart-button', ['product_qty' =>
                                        '1','product_id'=>$productItem['id'],'price' => $productPrice])

                                    </div>
                                </figure>

                                <div class="product-caption">
                                    <div class="product-identity">
                                        <p class="manufacturer-name"><a
                                                href="product-details.html">{{ $productItem->product()->get()[0]->name }}</a>
                                        </p>
                                    </div>
                                    <h6 class="product-name">
                                        <a href="product-details.html">{{ $productItem->product->alias }}
                                            -
                                            {{ $productItem->productGrade->alias }} -
                                            {{ $productItem->ratti->rati_standard }}+</a>
                                    </h6>
                                    <div class="price-box">
                                        <span class="price-regular">INR. {{ $productPrice }}</span>
                                        {{-- <span class="price-old"><del>$70.00</del></span> --}}
                                    </div>
                                </div>
                            </div>
                            <!-- product item end -->

                        @endforeach





                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <form action="">
        <input type="text" name="service" value="">
    </form> --}}
    @push('scripts')
        <script>
            function getServices(services) {
                @this.setServices(services)

            }
        </script>
    @endpush

    <!-- related products area end -->
</main>
