<div>
    @php
        $addOnsAmount = 0;
        $subTotal = 0;
        $taxAmount = 0;
        $shippingCharges = 0;
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
                                    <li class="breadcrumb-item"><a href="{{ route('9gemhome') }}"><i
                                                class="fa fa-home"></i></a></li>

                                    <li class="breadcrumb-item active" aria-current="page">checkout</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- {{ dd(session('cart_items')) }} --}}

        <!-- breadcrumb area end -->
        @if (count(session('cart_items')) > 0)
            <!-- checkout main wrapper start -->
            <div class="checkout-page-wrapper section-padding">
                <div class="container">
                    @if ($errors->any())

                        @foreach ($errors->all() as $error)
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">

                                <strong class="d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('public/front/icons/warning-sign.png') }}" alt="" height="30"
                                        class="mr-2">
                                    <h4 class="text-center"> {{ $error ?? 'error' }}!</h4>
                                </strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>



                        @endforeach
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <!-- Checkout Login Coupon Accordion Start -->
                            <div class="checkoutaccordion" id="checkOutAccordion">
                                <div class="card">
                                    <h6>Have A Coupon? <span data-toggle="collapse" data-target="#couponaccordion"
                                            aria-expanded="false" class="collapsed">Click
                                            Here To Enter Your Code</span></h6>
                                    <div id="couponaccordion" class="collapse" data-parent="#checkOutAccordion"
                                        style="">
                                        <div class="card-body">
                                            <div class="cart-update-option">
                                                <div class="apply-coupon-wrapper">
                                                    <form action="#" method="post" class=" d-block d-md-flex">
                                                        <input type="text" placeholder="Enter Your Coupon Code">
                                                        <button class="btn btn-sqr">Apply Coupon</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Checkout Login Coupon Accordion End -->
                        </div>
                    </div>
                    @php
                        $user = session('user_login');
                        
                        $grandTotal = 0;
                    @endphp

                    @if (!isset($user))

                        <a href="{{ route('9gem_user_login') }}"
                            class="btn btn-sqr text-center mx-auto block text-light" style="width: 220px">Login</a>
                        <h4 class="my-4 ml-2 ">OR</h4>
                    @endif

                    <div class="row">

                        <!-- Checkout Billing Details -->

                        <div class="col-lg-7">
                            <div class="checkout-billing-details-wrap">
                                {{ $user['id'] ?? '' }}
                                <h5 class=" checkout-title text-hero" style="font-weight: 450">Personal Details</h5>
                                <div class="billing-form-wrap">
                                    <form action="{{ route('9gem_user_place_order') }}" method="POST">
                                        @csrf
                                        @if (!isset($user))


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="single-input-item">
                                                        <label for="name" class="required">Full Name</label>
                                                        <input type="text" placeholder="Full Name" name="name"
                                                            required="" value="{{ old('name') }}">
                                                    </div>
                                                    <span class="text-danger">
                                                        @error('name')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                                <div class="col-lg-12">

                                                    <div class="single-input-item">
                                                        <label for="name" class="required">Email</label>
                                                        <input type="email" placeholder="Email" name="email" required=""
                                                            value="{{ old('email') }}">
                                                    </div>
                                                    <span class="text-danger">
                                                        @error('email')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                                <div class="col-lg-12 mb-1 single-input-item">

                                                    <label for="phone" class="required">Phone No.</label>
                                                    <div class="row">
                                                        <div class="col-xl-3 col-3 pr-0">
                                                            <select class="form-control" name="phone_country_code_id">
                                                                @foreach ($phoneCodes as $key => $code)
                                                                    <option value="{{ $key }}"
                                                                        {{ old('phone_country_code_id') == $key ? 'selected' : ' ' }}>
                                                                        +{{ $code }}</option>
                                                                @endforeach



                                                            </select>
                                                        </div>
                                                        <div class="col-xs-9 col-9 pl-1">
                                                            <input type="text" placeholder="Phone No" name="phone"
                                                                required="" value="{{ old('phone') }}">


                                                        </div>

                                                        <span class="text-danger pl-3">
                                                            @error('phone_country_code_id')
                                                                {{ $message }}
                                                            @enderror

                                                            @error('phone')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>

                                                    </div>


                                                </div>

                                            </div>



                                            <div class="single-input-item">
                                                <div class="g-recaptcha"
                                                    data-sitekey="6Le2sdcbAAAAAH0Wc49EOCurkgzq7Bq96ya_SADN"
                                                    style="width: 100%">
                                                </div>
                                                <span class="text-danger">
                                                    @error('g-recaptcha-response')
                                                        {{ 'Please fill reCaptcha field .' }}
                                                    @enderror
                                                </span>
                                            </div>

                                        @else
                                            {{-- {{ dd($userDetails) }} --}}
                                            <button type="button" class="btn btn-sqr" onclick="addnewAddressModal()">
                                                Add New
                                                Address</button>
                                            @if ($userDetails != null)
                                                <div class="single-input-item">
                                                    <label for="address" class="required"> Select Shipping
                                                        Address</label>

                                                    <select name="address" id="address">
                                                        @foreach ($userDetails->addresses as $address)
                                                            <option value="{{ $address['id'] }}">
                                                                {{ $address['address'] }},
                                                                {{ $address['locality'] }},
                                                                {{ $address['landmark'] }},
                                                                {{ $address['pincode'] }},
                                                                {{ $address->city->name }},
                                                                {{ $address->state->name }},
                                                                {{ $address->country->name }}.
                                                            </option>
                                                        @endforeach


                                                    </select>
                                                    <span class="text-danger">
                                                        @error('Address')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>



                                                </div>
                                            @endif



                                        @endif


                                        <div class="single-input-item">
                                            <label for="ordernote">Order Note</label>
                                            <textarea name="ordernote" id="ordernote" cols="30" rows="3"
                                                placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                        </div>






                                </div>
                            </div>
                        </div>

                        <!-- Order Summary Details -->
                        <div class="col-lg-5">
                            <div class="order-summary-details">
                                <h5 class="checkout-title">Your Order Summary</h5>
                                <div class="order-summary-content">
                                    <!-- Order Summary Table -->
                                    <div class="order-summary-table table-responsive ">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Products</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                @foreach (session('cart_items') as $item)

                                                    @php
                                                        $product_item = App\Model\Warehouse\InvoiceDetailGradeProduct::find($item['product_id']);
                                                        $rateProfileId = App\Helpers\Helper::getRateProfile($product_item->product_id, $product_item->grade_id);
                                                        $productPrice = App\Helpers\Helper::getProductPrice($product_item->weight, $rateProfileId);
                                                        
                                                    @endphp
                                                    <tr class="text-left">
                                                        <td><a href="product-details.html">{{ $product_item->product->alias }}
                                                                -
                                                                {{ $product_item->productGrade->alias }} -
                                                                {{ $product_item->ratti->rati_standard }}+
                                                                <strong> ×
                                                                    {{ $item['product_qty'] }}</strong></a>
                                                        </td>
                                                        <td class="">
                                                            INR. {{ $item['price'] }}
                                                            @empty(!$item['addOns'])
                                                                <br>

                                                                <div class="
                                                            addOn ">
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
                                @php
                                    $subTotal += $item['price'] * $item['product_qty'];
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

            <td> Grand Total </td>
            <td><strong style="background:#c29958" class="text-light p-2">INR.
                    {{ $addOnsAmount + $subTotal + $shippingCharges + $taxAmount }}</strong>
            </td>
        </tr>
    </tfoot>
    </table>
</div>
{{-- <div class="row">
                                        <div class="col-lg-5 ml-auto">
                                            <!-- Cart Calculation Area -->
                                            <div class="cart-calculator-wrapper">
                                                <div class="cart-calculate-items">
                                                    <h6>Cart Totals</h6>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                
                
                                                                <tr class="total">
                                                                    <td>Sub Total</td>
                                                                    <td class="total-amount">INR. {{ $subTotal ?? 0 }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>AddOns</td>
                                                                    <td>+ {{ $addOnsAmount }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tax</td>
                                                                    <td>+ {{ $tax }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Shipping Charges</td>
                                                                    <td>+ {{ $shippingCharges }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Grand Total</td>
                                                                    <td>INR.
                                                                        {{ $addOnsAmount + $subTotal + $tax + $shippingCharges }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <a href="{{ route('9gem_user_checkout') }}" class="btn btn-sqr d-block ">Proceed
                                                    Checkout</a>
                                            </div>
                                        </div>
                                    </div> --}}
<h4 class="mt-4">Billing Details</h4>
<!-- Order Payment Method -->
<div class="order-payment-method mt-2">

<div class="single-payment-method show">
    <div class="payment-method-name">
        <div class="custom-control custom-radio">
            <input type="radio" id="cashon" name="paymentmethod" value="cash" class="custom-control-input"
                checked="">
            <label class="custom-control-label" for="cashon">Cash On
                Delivery</label>
        </div>
    </div>
    <div class="payment-method-details" data-method="cash">
        <p>Pay with cash upon delivery.</p>
    </div>
</div>

<div class="single-payment-method ">
    <div class="payment-method-name">
        <div class="custom-control custom-radio">
            <input type="radio" id="check" name="paymentmethod" value="check" class="custom-control-input">
            <label class="custom-control-label" for="check">Pay via
                Check</label>
        </div>
    </div>
    <div class="payment-method-details" data-method="check">
        <p>Paying With Check.</p>
    </div>
</div>

<div class="single-payment-method">
    <div class="payment-method-name">
        <div class="custom-control custom-radio">
            <input type="radio" id="online" name="paymentmethod" value="online" class="custom-control-input">
            <label class="custom-control-label" for="online">Pay Online

        </div>
    </div>
    <div class="payment-method-details" data-method="online">
        <p>Pay via RazorPay; you can pay with your credit card if you don’t
            have
            a
            RazorPay account.</p>
    </div>
</div>


<button type="submit" class="btn btn-sqr d-block" style="width: 100%">Place
    Order</button>

</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@else

<div class="jumbotron text-center">
<h1 class="display-3">Cart is Empty!</h1>
<p class="lead">Add Some items into cart first for<strong> checkOut</strong>
    <hr>
<p>
    Having trouble? <a href="{{ route('9gemhome') }}">Contact us</a>
</p>
<p class="lead">
    <a class="btn btn-sqr " href="{{ route('9gemhome') }}" role="button">Continue to homepage</a>
    {{-- <a class="btn btn-sqr " href="{{ route('9gemhome') }}" role="button">View Order Details</a> --}}
</p>
</div>
@endif

<!-- checkout main wrapper end -->
</main>

<!--modal address-->
<div class="modal fade text-center py-5" id="subscribeModal" tabindex="-1" role="dialog"
aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-body overflow-hidden">
            <div class="top-strip"></div>
            <a class="h2">Enter New Address</a>

            <form action="{{ route('9gem_add_new_address') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="Country" class="required">Country</label>
                            <select class="form-control" name="country" id="countrySelect"
                                value="{{ old('Country') }}">
                                <option value="" selected>Select a country</option>
                                @foreach ($countries as $key => $Country)


                                    <option value="{{ $key }}"
                                        {{ old('Country') == $key ? 'selected' : ' ' }}>
                                        {{ $Country }}</option>


                                @endforeach

                            </select>
                        </div>
                        <span class="text-danger">
                            @error('Country')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>


                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="State" class="required">State</label>

                            <select class="form-control" name="state" id="statesSelect">
                                <option value="">Select a state</option>
                                {{-- @foreach ($states as $key => $state)
                                                <option value="{{ $key }}" selected>{{ $state }}</option>
        
                                            @endforeach --}}


                            </select>
                        </div>
                        <span class="text-danger">
                            @error('State')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="City" class="required">City</label>
                            <select class="form-control" name="city" id="citySelect">

                                <option value="">select a city</option>


                            </select>
                        </div>
                        <span class="text-danger">
                            @error('City')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>



                </div>


                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="Address-Type"
                                class="">Address Type</label>
                                    <select class="
                                form-control" name="Address-Type">

                                @foreach ($addressTypes as $key => $type)
                                    <option value="{{ $key }}"
                                        {{ old('Address-Type') == $key ? 'selected' : ' ' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach


                                </select>
                        </div>
                        <span class="text-danger">
                            @error('Address-Type')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="address" class="required">Full
                                Address</label>
                            <input type="text" placeholder="Full Address" name="address"
                                value="{{ old('address') }}">
                        </div>
                        <span class="text-danger">
                            @error('address')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="Town" class="required">Town</label>
                            <select class="form-control" name="town" id="townSelect">

                                <option value="">Select a town
                                </option>


                            </select>
                        </div>
                        <span class="text-danger">
                            @error('Town')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>



                </div>


                <div class="row">

                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="Locality" class="required">Locality</label>
                            <input type="text" placeholder="Locality" name="locality"
                                value="{{ old('Locality') }}">
                        </div>
                        <span class="text-danger">
                            @error('Locality')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="Landmark" class="required">Landmark</label>
                            <input type="text" placeholder="Landmark" name="landmark"
                                value="{{ old('Landmark') }}">
                        </div>
                        <span class="text-danger">
                            @error('Landmark')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="Pincode" class="required">Pincode</label>
                            <input type="number" placeholder="Pincode" name="pincode"
                                value="{{ old('Pincode') }}">
                        </div>
                        <span class="text-danger">
                            @error('Pincode')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>



                </div>


                <button class="btn btn-hero mx-auto d-block my-4" type="submit">Confirm Order</button>

            </form>

            <p class="pb-1 text-muted"><small>Your address is safe with us. We won't spam.</small></p>
            <div class="bottom-strip" style="z-index: 1"></div>
        </div>
    </div>
</div>
</div>
</div>
