
                                @foreach ($ledgers->take(2) as $ledger)

                                @foreach ($ledger->ledgerDetails->take(10) as $ledgerDetail)
                                    @php
                                        
                                        $rateProfileId = App\Helpers\Helper::getRateProfile($ledgerDetail->productStock->product_id, $ledgerDetail->productStock->grade_id);
                                        $productPrice = App\Helpers\Helper::getProductPrice($ledgerDetail->productStock->weight, $rateProfileId);
                                        
                                    @endphp

                                    <!-- group list item start -->
                                    <div class="group-slide-item">
                                        <div class="group-item">
                                            <div class="group-item-thumb">
                                                <a
                                                    href="
                                                                                                                                                                                                                                                    {{ route('9gem_product_details', ['product_name' => $ledgerDetail->productStock->product->name, 'product_item_id' => $ledgerDetail->productStock->id]) }}">
                                                    <img src="{{ asset('public/front/assets/front/img/product/product-17.jpg') }}"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="group-item-desc">
                                                <h5 class="group-product-name"><a
                                                        href="
                                                                                                                                                                                                                                                        {{ route('9gem_product_details', ['product_name' => $ledgerDetail->productStock->product->name, 'product_item_id' => $ledgerDetail->productStock->id]) }}">
                                                        {{ $ledgerDetail->productStock->product->alias }}
                                                        -
                                                        {{ $ledgerDetail->productStock->productGrade->alias }} -
                                                        {{ $ledgerDetail->productStock->ratti->rati_standard }}+</a>
                                                </h5>
                                                <div class="price-box">
                                                    <span class="price-regular">INR. {{ $productPrice }}</span>
                                                    {{-- <span class="price-old"><del>$29.99</del></span> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- group list item end -->
                                @endforeach
                            @endforeach