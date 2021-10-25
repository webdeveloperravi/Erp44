@foreach ($ledgers->take(2) as $ledger)

    @foreach ($ledger->ledgerDetails->take(10) as $key => $ledgerDetail)

        @php
            // dd($ledgerDetail->productStock);
            $rateProfileId = App\Helpers\Helper::getRateProfile($ledgerDetail->productStock->product_id, $ledgerDetail->productStock->grade_id);
            $productPrice = App\Helpers\Helper::getProductPrice($ledgerDetail->productStock->weight, $rateProfileId);
            
        @endphp

        <!-- hot deals item start -->
        <div class="hot-deals-item product-item">

            <figure class="product-thumb">
                <a
                    href="{{ route('9gem_product_details', ['product_name' => $ledgerDetail->productStock->product->name, 'product_item_id' => $ledgerDetail->productStock->id]) }}">
                    <img src="{{ asset('public/front/assets/front/img/product/product-details-img') }}1.jpg"
                        alt="product">
                </a>

                <div class="product-badge">
                    <div class="product-label new">
                        <span>sale</span>
                    </div>
                    <div class="product-label discount">
                        <span>new</span>
                    </div>
                </div>

                @if (session('user_login'))
                    <div class="button-group">
                        @php
                            $wishlishted = \App\Model\Front\Wishlist::where(['user_id' => $user_id, 'product_item_id' => $ledgerDetail->productStock->id])->exists();
                        @endphp

                        @livewire('user-wishlist', ['item_id' =>
                        $ledgerDetail->productStock->id,'wishlishted'=>$wishlishted],key($key))
                    </div>
                @endif

                <div class="cart-hover">
                    @livewire('add-to-cart-button', ['product_qty' =>
                    '1','product_id'=>$ledgerDetail->productStock['id'],'price' => $productPrice],key($key))
                </div>
            </figure>
            <div class="product-caption">
                <div class="product-identity">
                    <p class="manufacturer-name"><a
                            href="product-details.html">{{ $ledgerDetail->productStock->product->name }}</a>
                    </p>
                </div>
                <h6 class="product-name">
                    <a href="product-details.html">{{ $ledgerDetail->productStock->product->alias }}
                        -
                        {{ $ledgerDetail->productStock->productGrade->alias }} -
                        {{ $ledgerDetail->productStock->ratti->rati_standard }}+</a>
                </h6>
                <div class="price-box">
                    <span class="price-regular">INR. {{ $productPrice }}</span>
                    {{-- <span class="price-old"><del>$70.00</del></span> --}}
                </div>
                {{-- <div class="product-countdown product-countdown--style-two"
                    data-countdown="2020/11/25">
                </div> --}}
            </div>
        </div>
        <!-- hot deals item end -->
    @endforeach
@endforeach
