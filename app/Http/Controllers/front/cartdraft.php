<div>

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



        <!-- breadcrumb area end -->
        @if (session('cart_items'))
            <!-- checkout main wrapper start -->
            <div class="checkout-page-wrapper section-padding">
                <div class="container">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong> {{ $error }}!</strong>
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
                        <h4 class="my-4 ml-2">or</h4>
                    @endif


                    <div class="row">

                        <!-- Checkout Billing Details -->

                        <div class="col-lg-7">
                            <div class="checkout-billing-details-wrap">
                                {{ $user['id'] ?? '' }}
                                <h5 class="checkout-title">Billing Details</h5>
                                <div class="billing-form-wrap">
                                    <form action="{{ route('9gem_user_place_order') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user['id'] ?? '' }}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="single-input-item">
                                                    <label for="name" class="required">First Name</label>
                                                    <input type="text" id="name" placeholder="Name" name="name"
                                                        value="{{ $user['name'] ?? '' }}"
                                                        style="pointer-events: none">
                                                </div>
                                                <span class="text-danger">
                                                    @error('name')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="single-input-item">
                                                    <label for="company_name" class="required">Company Name</label>
                                                    <input type="text" id="company_name" placeholder="Company Name"
                                                        name="company_name" value="{{ $user['company_name'] ?? '' }}"
                                                        style="pointer-events: none">
                                                </div>
                                                <span class="text-danger">
                                                    @error('company_name')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>

                                        <div class="single-input-item">
                                            <label for="email" class="required">Email Address</label>
                                            <input type="email" id="email" placeholder="Email Address" name="email"
                                                value="{{ $user['email'] ?? '' }}" style="pointer-events: none">

                                        </div>

                                        <span class="text-danger">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </span>

                                        <div class="single-input-item">
                                            <label for="phone_country_code_id" class="required">Phone Country
                                                Code</label>
                                            <input type="number" id="phone_country_code_id"
                                                placeholder="Phone Country Code" name="phone_country_code_id"
                                                value="{{ $user['phone_country_code_id'] ?? '' }}"
                                                style="pointer-events: none">
                                        </div>
                                        <span class="text-danger">
                                            @error('phone_country_code_id')
                                                {{ $message }}
                                            @enderror
                                        </span>

                                        <div class="single-input-item">
                                            <label for="phone" class="required">Phone</label>
                                            <input type="number" id="phone" placeholder="Phone" name="phone"
                                                value="{{ $user['phone'] ?? '' }}" style="pointer-events: none">
                                        </div>

                                        <span class="text-danger">
                                            @error('phone')
                                                {{ $message }}
                                            @enderror
                                        </span>

                                        @if (session('user_id'))
                                            <div class="single-input-item">
                                                <label for="Address" class="required">Delivery Address</label>

                                                <select name="Address" id="Address">
                                                    @foreach ($userDetails->addresses as $address)

                                                        <option value="{{ $address['id'] }}">
                                                            {{ $address['address'] }},{{ $address['locality'] }},{{ $address['landmark'] }},{{ $address['pincode'] }},{{ $address->city->name }},{{ $address->state->name }},{{ $address->country->name }}
                                                        </option>
                                                    @endforeach


                                                </select>
                                                <span class="text-danger">
                                                    @error('Address')
                                                        {{ $message }}
                                                    @enderror
                                                </span>



                                            </div>
                                            <button type="button" class="btn btn-hero" onclick="addnewAddressModal()">
                                                Add New
                                                Address</button>

                                        @else

                                            <div class="single-input-item">
                                                <label for="Address" class="required mt-20">Full Address</label>
                                                <input type="text" id="Address" placeholder="Full Address"
                                                    name="Address" value="">
                                            </div>
                                            <span class="text-danger">
                                                @error('Address')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        @endif


                                        <div class="single-input-item">
                                            <label for="ordernote">Order Note</label>
                                            <textarea name="ordernote" id="ordernote" cols="30" rows="3"
                                                placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                        </div>


                                        <div class="create-account my-4">
                                            <h5>Don't have an account ? </h5>
                                            <a href="{{ route('9gem_user_register') }}"
                                                class="btn btn-sm btn-sqr text-light my-2">Create new account</a>
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
                                    <div class="order-summary-table table-responsive text-center">
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
                                                    <tr>
                                                        <td><a href="product-details.html">{{ $product_item->product->alias }}
                                                                -
                                                                {{ $product_item->productGrade->alias }} -
                                                                {{ $product_item->ratti->rati_standard }}+ <strong> ×
                                                                    {{ $item['product_qty'] }}</strong></a>
                                                        </td>
                                                        <td>INR. {{ $item['price'] }}</td>
                                                    </tr>
                                                    @php
                                                        $grandTotal += $item['price'] * $item['product_qty'];
                                                    @endphp

                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>Sub Total</td>
                                                    <td><strong>INR. {{ $grandTotal ?? '' }}</strong></td>
                                                </tr>
                                                {{-- <tr>
                                                <td>Shipping</td>
                                                <td class="d-flex justify-content-center">
                                                    <ul class="shipping-type">
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="flatrate" name="shipping"
                                                                    class="custom-control-input" checked="">
                                                                <label class="custom-control-label" for="flatrate">Flat
                                                                    Rate: $70.00</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="freeshipping" name="shipping"
                                                                    class="custom-control-input">
                                                                <label class="custom-control-label"
                                                                    for="freeshipping">Free
                                                                    Shipping</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr> --}}
                                                <tr>
                                                    <td>Total Amount</td>
                                                    <td><strong>INR. {{ $grandTotal ?? '' }}</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- Order Payment Method -->
                                    <div class="order-payment-method">

                                        <div class="single-payment-method show">
                                            <div class="payment-method-name">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="cashon" name="paymentmethod" value="cash"
                                                        class="custom-control-input" checked="">
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
                                                    <input type="radio" id="check" name="paymentmethod" value="check"
                                                        class="custom-control-input">
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
                                                    <input type="radio" id="online" name="paymentmethod" value="online"
                                                        class="custom-control-input">
                                                    <label class="custom-control-label" for="online">Pay Online

                                                </div>
                                            </div>
                                            <div class="payment-method-details" data-method="online">
                                                <p>Pay via RazorPay; you can pay with your credit card if you don’t have
                                                    a
                                                    RazorPay account.</p>
                                            </div>
                                        </div>
                                        <div class="summary-footer-area">
                                            <div class="custom-control custom-checkbox mb-20">
                                                <input type="checkbox" class="custom-control-input"
                                                    name="Terms&Conditions" id="Terms&Conditions" checked>
                                                <label class="custom-control-label" for="Terms&Conditions">I have read
                                                    and
                                                    agree to
                                                    the website <a href="index.html">Terms & conditions.</a></label>
                                                <span class="ml-2 text-danger">
                                                    @error('Terms&Conditions')
                                                        {{ $message }}
                                                    @enderror
                                                </span>

                                            </div>


                                        </div>
                                        <button type="submit" class="btn btn-sqr">Place Order</button>

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
                    <a class="btn btn-sqr " href="{{ route('9gemhome') }}" role="button">View Order Details</a>
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
                            <div class="col-lg-8 mx-auto text-left">



                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="single-input-item">
                                            <label for="country" class="required">Country</label>
                                            <input type="text" name="country" id="country" placeholder="country">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="single-input-item ">
                                            <label for="State" class="required">State</label>
                                            <input type="text" name="state" id="nState" placeholder="State">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="single-input-item ">
                                            <label for="City" class="required">City</label>
                                            <input type="text" name="city" id="nCity" placeholder="City">
                                        </div>
                                    </div>



                                </div>




                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="single-input-item ">
                                            <label for="Town" class="required">Town</label>
                                            <input type="text" name="town" id="Town" placeholder="Town">
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="single-input-item">
                                            <label for="address_type" class="required">Address Type</label>

                                            <select name="address_type_id" id="address_type">
                                                @foreach ($AddressTypes as $addressType)
                                                    <option value="{{ $addressType['id'] }}">
                                                        {{ $addressType['name'] }}
                                                    </option>
                                                @endforeach


                                            </select>
                                            <span class="text-danger">
                                                @error('Address')
                                                    {{ $message }}
                                                @enderror
                                            </span>



                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="single-input-item ">
                                            <label for="naddress" class="required">Address</label>
                                            <input type="address" name="address" id="naddress" placeholder="Address"
                                                required="">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="single-input-item ">
                                            <label for="locality" class="required">Locality</label>
                                            <input type="text" name="locality" id="locality" placeholder="Locality"
                                                required="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="single-input-item ">
                                            <label for="landmark" class="required">Landmark</label>
                                            <input type="text" name="landmark" id="landmark" placeholder="landmark"
                                                required="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="single-input-item ">
                                            <label for="pincode" class="required">Pincode</label>
                                            <input type="number" name="pincode" id="pincode" placeholder="pincode"
                                                required="">
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-hero">Submit</button>






                            </div>
                        </div>



                    </form>

                    <p class="pb-1 text-muted"><small>Your address is safe with us. We won't spam.</small></p>
                    <div class="bottom-strip" style="z-index: 1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
