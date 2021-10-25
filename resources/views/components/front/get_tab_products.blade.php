@php
$count = 0;
@endphp

@foreach ($ledgers->take(2) as $ledger)

    @foreach ($ledger->ledgerDetails->take(2) as $ledgerDetail)

        @foreach ($ledgerDetail->productStock->productCategory->Product->take(5) as $product)
            @if ($count == 0)
                <div class="tab-pane fade show active" id="{{ str_replace(' ', '', $product->name) }}">
                @else
                    <div class="tab-pane fade" id="{{ str_replace(' ', '', $product->name) }}">

            @endif
            <div class="product-carousel-4 slick-row-10 slick-arrow-style">

                @foreach ($product->products()->take(20)->get()
    as $key => $productItem)
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
                            @if (session('user_login'))
                                <div class="button-group">
                                    @php
                                        $wishlishted = \App\Model\Front\Wishlist::where(['user_id' => $user_id, 'product_item_id' => $productItem->id])->exists();
                                    @endphp

                                    @livewire('user-wishlist', ['item_id' =>
                                    $productItem->id,'wishlishted'=>$wishlishted],key($key))

                                </div>
                            @endif
                            <div class="cart-hover">
                                @livewire('add-to-cart-button', ['product_qty' =>
                                '1','product_id'=>$productItem['id'],'price' =>
                                $productPrice],key($key))

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
                                <span class="price-regular">INR.
                                    {{ $productPrice }}</span>
                                {{-- <span class="price-old"><del>$70.00</del></span> --}}
                            </div>
                        </div>
                    </div>
                    <!-- product item end -->
                    @php
                        $count++;
                    @endphp

                @endforeach





            </div>
            </div>
        @endforeach


    @endforeach

@endforeach
