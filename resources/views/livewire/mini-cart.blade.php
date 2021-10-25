<div>
    @php
        $grandTotal = 0;
    @endphp

    <!-- offcanvas mini cart start -->
    <div class="offcanvas-minicart-wrapper">
        <div class="minicart-inner">
            <div class="offcanvas-overlay"></div>
            <div class="minicart-inner-content">
                <div class="minicart-close">
                    <i class="pe-7s-close"></i>
                </div>
                <div class="minicart-content-box">
                    <div class="minicart-item-wrapper">
                        <ul>
                            @if (session('cart_items') && count(session('cart_items')))
                                @foreach (session('cart_items') as $item)


                                    @php
                                        $product_item = App\Model\Warehouse\InvoiceDetailGradeProduct::find($item['product_id']);
                                        $rateProfileId = App\Helpers\Helper::getRateProfile($product_item->product_id, $product_item->grade_id);
                                        $productPrice = App\Helpers\Helper::getProductPrice($product_item->weight, $rateProfileId);
                                        
                                    @endphp
                                    <li class="minicart-item">
                                        <div class="minicart-thumb">
                                            <a
                                                href="{{ route('9gem_product_details', ['product_name' => $product_item->product->name, 'product_item_id' => $item['product_id']]) }}">
                                                <img src="{{ asset('public/front/assets/front/img/product/gem.jpg') }}"
                                                    alt="product">
                                            </a>
                                        </div>
                                        <div class="minicart-content">
                                            <h3 class="product-name">
                                                <a
                                                    href="{{ route('9gem_product_details', ['product_name' => $product_item->product->name, 'product_item_id' => $item['product_id']]) }}">{{ $product_item->product->alias }}
                                                    -
                                                    {{ $product_item->productGrade->alias }} -
                                                    {{ $product_item->ratti->rati_standard }}+</a>
                                            </h3>
                                            <p>
                                                <span class="cart-quantity"> {{ $item['product_qty'] }}
                                                    <strong>&times;</strong></span>
                                                <span class="cart-price">INR. {{ $item['price'] }}</span>
                                            </p>
                                        </div>
                                        <button class="minicart-remove" type="button"
                                            wire:click.prevent="removeCartItem('{{ $loop->index }}')"><i
                                                class="pe-7s-close"></i></button>
                                    </li>
                                    @php
                                        $grandTotal += $item['price'] * $item['product_qty'];
                                    @endphp

                                @endforeach




                        </ul>
                    </div>

                    <div class="minicart-pricing-box">
                        <ul>
                            {{-- <li>
                                <span>sub-total</span>
                                <span><strong>$300.00</strong></span>
                            </li>
                            <li>
                                <span>Eco Tax (-2.00)</span>
                                <span><strong>$10.00</strong></span>
                            </li>
                            <li>
                                <span>VAT (20%)</span>
                                <span><strong>$60.00</strong></span>
                            </li> --}}
                            <li class="total">
                                <span>total</span>
                                <span><strong>INR. {{ $grandTotal ?? 0 }}</strong></span>
                            </li>
                        </ul>
                    </div>


                    <div class="minicart-button">
                        <a href="{{ route('9gem_user_cart') }}"><i class="fa fa-shopping-cart"></i> View Cart</a>
                        <a href="{{ route('9gem_user_checkout') }}"><i class="fa fa-share"></i> Checkout</a>
                    </div>
                @else
                    <img src="{{ asset('public/front/icons/empty-cart.svg') }}" alt="" height="180"
                        class="img-responsive mx-auto d-block ">
                    <h4 class="text-center mt-5 block">Your Shopping Cart Is Empty</h4>
                    <a href="{{ route('9gemhome') }}" class="btn  btn-hero text-center mx-auto block"
                        style="display:block;max-width:200px">Continue
                        Shopping</a>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- offcanvas mini cart end -->
</div>
