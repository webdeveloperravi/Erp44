@extends('layouts.front.app')


@section('content')
    @php
    $addOns = [];
    $addOnCount = 0;
    $addOnsAmount = 0;
    $subTotal = 0;
    $shippingCharges = 0;
    $taxAmount = 0;
    @endphp
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
                                <li class="breadcrumb-item active" aria-current="page">my-account</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <div class="head my-4">
        <h2 class="text-center text-uppercase text-hero" style="color:#c29958">Order Details</h2>
    </div>
    <div class="container">
        <div class="col-lg-12 col-md-12 mx-auto ">
            <div class="tab-content" id="myaccountContent">


                <!-- Single Tab Content Start -->
                <div class="tab-pane fade active show" id="orders" role="tabpanel">
                    <div class="myaccount-content">

                        <div class="">
                            <h5>Order No : {{ $order->id }}</h5>
                            <span class="my-4 d-block">Placed At: {{ $order->created_at }}</span>

                        </div>


                        <div class="myaccount-table table-responsive text-center">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Product Item Name</th>
                                        <th>Product Category</th>
                                        <th>Product Name</th>
                                        <th>Product price</th>
                                        <th>Quantity ordered</th>
                                        <th>Addon</th>
                                        <th>Total Amt.</th>
                                        <th>View Product</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $grandTotal = 0;
                                        
                                    @endphp


                                    @foreach ($orders_details as $order_detail)


                                        @php
                                            //addOns
                                            foreach ($order_detail->addOns as $key => $addOn) {
                                                $service = App\Model\Front\Service::where('name', $addOn->add_on_name)->first();
                                                $addOns[] = $service->master::find($addOn->add_on_master_id);
                                            }
                                            
                                            $product_item = \App\Model\Warehouse\InvoiceDetailGradeProduct::find($order_detail->product_id);
                                            $rateProfileId = App\Helpers\Helper::getRateProfile($product_item->product_id, $product_item->grade_id);
                                            $productPrice = App\Helpers\Helper::getProductPrice($product_item->weight, $rateProfileId);
                                            
                                            $grandTotal += $productPrice * $order_detail->quantity;
                                            // dd($addOns);
                                        @endphp

                                        <tr>
                                            <td>{{ $product_item->product->alias }}
                                                -
                                                {{ $product_item->productGrade->alias }} -
                                                {{ $product_item->ratti->rati_standard }}+</td>

                                            <td>{{ $product_item->productCategory->name }}
                                            </td>
                                            <td>{{ $product_item->product->name }}
                                            </td>
                                            <td>INR. {{ $productPrice }}
                                            </td>
                                            <td>{{ $order_detail->quantity }}
                                            </td>
                                            <td>{{ $order_detail->addOns->count() }}
                                            </td>
                                            <td>INR. {{ $order_detail->quantity * $productPrice }}
                                            </td>


                                            <td><a href="{{ route('9gem_product_details', ['product_name' => $product_item->product->name, 'product_item_id' => $product_item->id]) }}"
                                                    class="btn btn-sqr">View</a>
                                            </td>
                                        </tr>
                                    @endforeach







                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Single Tab Content End -->

                <div class="row my-4 " x-data={isCancel:false}>
                    <div class="col-lg-6 mx-auto">
                        @php
                            $address_id = $order->shipping_address;
                            $shipAddress = App\Model\Admin\Organization\StoreAddress::find($address_id);
                            
                        @endphp
                        <h4 style="color:#c29958;font-weight: 450">
                            Shipping Address
                        </h4>
                        <h6 class="mt-2 text-capitalize" style="font-weight: 400"> {{ $shipAddress->address }},
                            {{ $shipAddress->landmark }},
                            {{ $shipAddress->city->name }},{{ $shipAddress->pincode }},
                            {{ $shipAddress->state->name }}, {{ $shipAddress->country->name }}.

                        </h6>
                        <div class="my-4">
                            <h4 style="color:#c29958;font-weight: 450;">Order Status</h4>
                            <h6 class="mt-2" style="font-weight: 400">{{ $order->status }}</h6>
                        </div>


                        <div class="my-4">
                            <h2 style="font-weight: 400" class="text-hero">Track Your Order</h2>
                            <h6 class=""><button class=" btn btn-hero mt-2"><a href="#" class="text-light">Track
                                        Now</a></button>
                            </h6>
                        </div>





                    </div>
                    <div class="col-lg-6 mx-auto">
                        <!-- Cart Calculation Area -->
                        <div class="cart-calculator-wrapper">
                            <div class="cart-calculate-items">
                                <h6>Order Totals</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Products</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @foreach ($orders_details as $order_detail)
                                                {{-- {{ dd($order_detail) }} --}}
                                                @php
                                                    $product_item = \App\Model\Warehouse\InvoiceDetailGradeProduct::find($order_detail->product_id);
                                                    $rateProfileId = App\Helpers\Helper::getRateProfile($product_item->product_id, $product_item->grade_id);
                                                    $productPrice = App\Helpers\Helper::getProductPrice($product_item->weight, $rateProfileId);
                                                    
                                                @endphp
                                                <tr class="text-left">
                                                    <td><a href="#" class="text-dark">{{ $product_item->product->alias }}
                                                            -
                                                            {{ $product_item->productGrade->alias }} -
                                                            {{ $product_item->ratti->rati_standard }}+
                                                            <strong> ×
                                                                {{ $order_detail->quantity }}</strong></a>
                                                    </td>
                                                    <td class="">
                                                        INR. {{ $productPrice }}

                                                        <br>
                                                        <div class="addOn ">

                                                            @foreach ($order_detail->addOns as $addOn)
                                                                @php
                                                                    
                                                                    $service = App\Model\Front\Service::where('name', $addOn->add_on_name)->first();
                                                                    $addOnName = $service->master::find($addOn->add_on_master_id)->name;
                                                                    $addOnPrice = $service->master::find($addOn->add_on_master_id)->price;
                                                                    
                                                                @endphp

                                                                + <span>{{ $addOnName }}</span>
                                                                <small
                                                                    class="text-success">(INR-{{ $addOnPrice }})</small>
                                                                <br />


                                                                @php
                                                                    $addOnsAmount += $addOnPrice;
                                                                @endphp

                                                            @endforeach


                                                        </div>

                                                    </td>
                                                </tr>
                                                @php
                                                    
                                                    $subTotal += $productPrice * $order_detail->quantity;
                                                @endphp

                                            @endforeach

                                        </tbody>
                                        <tfoot class="t class=" text-left"">
                                            <tr>
                                                <td>Sub Total</td>
                                                <td><strong style="background:#c29958" class="text-light p-2">INR.
                                                        {{ $addOnsAmount + $subTotal + $shippingCharges + $taxAmount }}</strong>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Tax </td>
                                                <td>+ 0</td>
                                            </tr>
                                            <tr>
                                                <td>Shipping Charges </td>
                                                <td>+ {{ $shippingCharges }}</td>
                                            </tr>

                                            <tr>

                                                <td> Grand Amount</td>
                                                <td><strong style="background:#c29958" class="text-light p-2">INR.
                                                        {{ $addOnsAmount + $subTotal + $shippingCharges + $taxAmount }}</strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>



                                </div>


                            </div>
                            <a href="javascript:void(0)" class="btn btn-sqr d-block" @click="isCancel = !isCancel">Cancel
                                Order</a>

                        </div>

                        <form action="{{ route('9gem_cancel_order') }}" class="my-2" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <div class="row" x-show.transition.fade="isCancel">



                                <div class="col-md-12">
                                    <div class="single-input-item">
                                        <label for="order_cancel_reason" class="required text-capitalize">Please Provide a
                                            reason for cancelling your Order</label>

                                        <select name="order_cancel_reason" id="order_cancel_reason">

                                            <option value="Order placed by mistake" selected>
                                                Order placed by mistake
                                            </option>
                                            <option value="There is No discount available">
                                                There is No discount available
                                            </option>
                                            <option value="Others">
                                                Others
                                            </option>

                                        </select>
                                        <span class="text-danger">
                                            @error('order_cancel_reason')
                                                {{ $message }}
                                            @enderror
                                        </span>



                                    </div>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <button type="submit" class="btn btn-sqr d-block">Confirm
                                        Cancel
                                    </button>
                                </div>
                        </form>

                    </div>

                </div>

            </div>


        </div>
    </div>

    </div>
@endsection



@section('scripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endsection
