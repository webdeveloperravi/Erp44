<div>
    <div id="main_search_container" class="position-relative" x-data="{isOpen:true}"
        @keydown.escape.window="isOpen=false" @keydown.window="

        if(event.keyCode == 191){
            event.preventDefault();
            $refs.main_search_bar.focus();
        }
    
    ">
        <!-- Custom rounded search bars with input group -->
        <form action="{{ route('9gem_search_results') }}" method="get">
            <div class="p-1 bg-light rounded rounded-sm shadow-sm">
                <div class="input-group">
                    <input type="search" placeholder="What're you searching for?" aria-describedby="button-addon1"
                        class="form-control border-0 bg-light" name="query" autocomplete="off" minlength="3"
                        wire:model.debounce.0ms="query" @click="isOpen=true" x-ref="main_search_bar"
                        @click.away="isOpen = false" @focus="isOpen=true"
                        @keydown.escape="$refs.main_search_bar.blur()">



                    <div class="input-group-append" style="margin-right:18px;margin-left:10px;">
                        <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i
                                class="fa fa-search" style="font-size:1.5rem;color:#000"></i></button>
                    </div>
                </div>
            </div>

        </form>
        <!--ends-->

        @if (strlen($query) >= 3)
            @if (count($searchResults))


                <div id="main_search_results" x-show="isOpen">
                    <ul>
                        @foreach ($searchResults as $item)


                            <a
                                href="{{ route('9gem_product_details', ['product_item_id' => $item->id, 'product_name' => $item->product->name]) }}">
                                <li>
                                    <img src="{{ asset('public/front/assets/front/img/product/product-6.jpg') }}"
                                        alt="product img" class="img-responsive">
                                    <div class="product-content">
                                        <h6>{{ $item->iname }}</h6>
                                        <small>in gemstone</small>

                                    </div>
                                </li>
                            </a>
                        @endforeach
                    </ul>
                </div>
            @else
                <div style="background:#fff;padding:10px;border-radius:2px">
                    <span>Oops, seems no result for "{{ $query }}"</span>
                </div>
            @endif

        @endif
    </div>
</div>
