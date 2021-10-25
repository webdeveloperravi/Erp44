<div>
    @php
        $addOnsAmount = 0;
        $subTotal = 0;
        
    @endphp
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

                                    <li class="breadcrumb-item active" aria-current="page">My Cart</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper section-padding" wire:poll.visible="">
            <div class="container">
                <div class="section-bg-color">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Cart Table Area -->
                            @if (session('cart_items') && count(session('cart_items')))
                                <div class="cart-table table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="pro-thumbnail">Thumbnail</th>
                                                <th class="pro-title">Product</th>
                                                <th class="pro-price">Price</th>
                                                <th class="pro-quantity">Quantity</th>
                                                <th class="pro-quantity">Addons</th>
                                                <th class="pro-subtotal">Total</th>
                                                <th class="pro-remove">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach (session('cart_items') as $item)


                                                @php
                                                    $product_item = App\Model\Warehouse\InvoiceDetailGradeProduct::find($item['product_id']);
                                                    $rateProfileId = App\Helpers\Helper::getRateProfile($product_item->product_id, $product_item->grade_id);
                                                    $productPrice = App\Helpers\Helper::getProductPrice($product_item->weight, $rateProfileId);
                                                    
                                                @endphp
                                                <tr>
                                                    <td class="pro-thumbnail"><a href="#"><img class="img-fluid"
                                                                src="assets/img/product/product-1.jpg"
                                                                alt="Product"></a>
                                                    </td>
                                                    <td class="pro-title"><a
                                                            href="#">{{ $product_item->product->alias }}
                                                            -
                                                            {{ $product_item->productGrade->alias }} -
                                                            {{ $product_item->ratti->rati_standard }}+</a>
                                                    </td>

                                                    <td class="pro-price"><span>INR. {{ $item['price'] }}</span></td>

                                                    <td class="pro-quantity">
                                                        <input type="number" value="1" class="number-inp" name="qty"
                                                            disabled>
                                                    </td>
                                                    <td class="pro-quantity">

                                                        {{ $item['addOns'] == null ? 0 : count($item['addOns']) }}

                                                    </td>

                                                    <td class="pro-subtotal"><span>INR
                                                            {{ $item['price'] * $item['product_qty'] }}</span></td>

                                                    <td class="pro-remove"><a href="javascript:void(0)"
                                                            wire:click="$emit('removeCartItem',{{ $loop->index }})"><i
                                                                class="fa fa-trash-o"></i></a>
                                                    </td>
                                                </tr>

                                                @php
                                                    
                                                    $subTotal += $item['price'] * $item['product_qty'];
                                                @endphp

                                            @endforeach




                                        </tbody>
                                    </table>
                                </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 ml-auto">
                            <!-- Cart Calculation Area -->
                            <div class="cart-calculator-wrapper">
                                <div class="cart-calculate-items">
                                    <h6>Cart Totals</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Products</th>
                                                    <th class="text-center">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                @foreach (session('cart_items') as $item)

                                                    @php
                                                        $product_item = App\Model\Warehouse\InvoiceDetailGradeProduct::find($item['product_id']);
                                                        $rateProfileId = App\Helpers\Helper::getRateProfile($product_item->product_id, $product_item->grade_id);
                                                        $productPrice = App\Helpers\Helper::getProductPrice($product_item->weight, $rateProfileId);
                                                        
                                                    @endphp
                                                    <tr>
                                                        <td><a href="product-details.html"
                                                                style="color:black">{{ $product_item->product->alias }}
                                                                -
                                                                {{ $product_item->productGrade->alias }} -
                                                                {{ $product_item->ratti->rati_standard }}+
                                                                <strong> ×
                                                                    {{ $item['product_qty'] }}</strong></a>
                                                        </td>
                                                        <td class="text-hero">
                                                            INR. {{ $item['price'] }}
                                                            @empty(!$item['addOns'])
                                                                <br>
                                                                <div class="addOn ">

                                                                    @foreach ($item['addOns'] as $addOn)
                                                                        @php
                                                                            $addOnData = explode(',', $addOn);
                                                                            
                                                                        @endphp

                                                                        + <span>{{ $addOnData[0] }}</span>
                                                                        <small
                                                                            class="text-success">(INR-{{ $addOnData[2] }})</small>
                                                                        <br />


                                                                        @php
                                                                            $addOnsAmount += $addOnData[2];
                                                                        @endphp
                                                                    @endforeach
                                                                </div>


                                                            @endempty
                                                        </td>
                                                    </tr>


                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>Total Amount</td>
                                                    <td><strong class="text-light p-2" style="background:#c29958">INR.
                                                            {{ $addOnsAmount + $subTotal }}</strong>
                                                    </td>
                                                </tr>


                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <a href="{{ route('9gem_user_checkout') }}" class="btn btn-sqr d-block ">Proceed
                                    Checkout</a>
                            </div>
                        </div>
                    </div>
                @else

                    <img src="{{ asset('public/front/icons/empty-cart.svg') }}" alt="empty-cart"
                        class="mx-auto d-block" height="200">
                    <h2 class="text-center">Nothing in the cart!!!</h2>
                    @endif
                </div>
            </div>
        </div>
        <!-- cart main wrapper end -->



    </main>
</div>
