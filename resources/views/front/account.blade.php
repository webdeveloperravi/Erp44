@extends('layouts.front.app')


@section('page_title') My Account @endsection

@section('page_description') Account page description @endsection


@section('styles')
    <style>
        /***********************************************/
        /***************** Packages ********************/
        /***********************************************/
        @import url('https://fonts.googleapis.com/css?family=Tajawal');
        @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

        #subscribeModal .modal-content {
            overflow: hidden;
        }

        #subscribeModal .modal-content form {
            overflow: hidden;
        }

        a.h2 {
            color: #007b5e;
            margin-bottom: 0;
            text-decoration: none;
        }


        #subscribeModal .btn {
            border-top-right-radius: 30px;
            border-bottom-right-radius: 30px;
            padding-right: 20px;
            background: #007b5e;
            border-color: #007b5e;
        }

        #subscribeModal .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #007b5e;
            outline: 0;
            box-shadow: none;
        }



        #subscribeModal .top-strip {
            height: 155px;
            background: #007b5e;
            transform: rotate(141deg);
            margin-top: -106px;
            margin-right: 457px;
            margin-left: -328px;
            border-bottom: 65px solid #4CAF50;
            border-top: 10px solid #4caf50;
        }

        #subscribeModal .bottom-strip {
            height: 155px;
            background: #007b5e;
            transform: rotate(145deg);
            margin-top: -115px;
            margin-right: -694px;
            margin-left: 421px;
            border-bottom: 65px solid #4CAF50;
            border-top: 10px solid #4caf50;
        }

        /****** extra *******/
        #Reloadpage {
            cursor: pointer;
        }

    </style>
@endsection

@section('content')


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
                                    <li class="breadcrumb-item active" aria-current="page">my-account</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->
        @if ($errors->any())

            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong class="d-flex justify-content-center align-items-center">
                        <img src="{{ asset('public/front/icons/warning-sign.png') }}" alt="" height="30"
                            class="mr-2">
                        <h4 class="text-center"> {{ $error }}!</h4>
                    </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>



            @endforeach
        @endif
        @if (session('message'))

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('public/front/icons/warning-sign.png') }}" alt="" height="30"
                        class="mr-2">
                    <h4 class="text-center"> {{ session('message') }}!</h4>
                </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @php
            $user = session('user');
            
        @endphp

        <!-- my account wrapper start -->
        <div class="my-account-wrapper section-padding">
            <div class="container">
                <div class="section-bg-color">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- My Account Page Start -->
                            <div class="myaccount-page-wrapper">
                                <!-- My Account Tab Menu Start -->
                                <div class="row">
                                    <div class="col-lg-3 col-md-4">
                                        <div class="myaccount-tab-menu nav" role="tablist">
                                            <a href="#dashboad" class="active show" data-toggle="tab"><i
                                                    class="fa fa-dashboard"></i>
                                                Dashboard</a>
                                            <a href="#orders" data-toggle="tab" class="show"><i
                                                    class="fa fa-cart-arrow-down"></i>
                                                Orders</a>
                                            {{-- <a href="#posts" data-toggle="tab" class="show"><i class="fa fa-th-large"
                                                    aria-hidden="true"></i>
                                                Posts</a> --}}
                                            {{-- <a href="#Uploads" data-toggle="tab" class="show"><i
                                                    class="fa fa-cloud-download"></i>
                                                Uploads</a> --}}

                                            <a href="#payment-method" data-toggle="tab" class=" show"><i
                                                    class="fa fa-credit-card"></i>
                                                Cards</a>
                                            <a href="#address-edit" data-toggle="tab"><i class="fa fa-map-marker"></i>
                                                address </a>
                                            <a href="#account-info" data-toggle="tab"><i class="fa fa-user"></i>
                                                Personal
                                                details
                                            </a>
                                            <a href="#security" data-toggle="tab"><i class="fa fa-user"></i> security
                                            </a>
                                            <a href="{{ route('9gem_user_logout') }}"><i class="fa fa-sign-out"></i>
                                                Logout</a>
                                        </div>
                                    </div>
                                    <!-- My Account Tab Menu End -->

                                    <!-- My Account Tab Content Start -->
                                    <div class="col-lg-9 col-md-8">
                                        <div class="tab-content" id="myaccountContent">
                                            <!-- Single Tab Content Start -->
                                            <div class="tab-pane active fade" id="dashboad" role="tabpanel">
                                                <div class="myaccount-content">
                                                    <h5>Dashboard</h5>
                                                    <div class="welcome">
                                                        <p>Welcome , <strong>
                                                                <h2>{{ $user['name'] }}</h2>
                                                            </strong>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Single Tab Content End -->

                                            <!-- Single Tab Content Start -->
                                            <div class="tab-pane fade" id="orders" role="tabpanel">
                                                <div class="myaccount-content">
                                                    <h5>Orders</h5>
                                                    @php
                                                        $orders = \App\Model\Store\StorePurchaseOrder::where('buyer_store_id', session('user_id'))->get();
                                                        
                                                    @endphp
                                                    @if (count($orders) > 0)
                                                        <div class="myaccount-table table-responsive text-center">
                                                            <table class="table table-bordered">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th>Order Id</th>
                                                                        <th>Grand Total</th>
                                                                        <th>Total Quatity</th>
                                                                        <th>Status</th>
                                                                        <th>Date</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($orders as $order)

                                                                        @php
                                                                            
                                                                            $grandTotal = 0;
                                                                            
                                                                            foreach ($order->purchaseOrderDetail as $purchaseOrderDetail) {
                                                                                $product_item = \App\Model\Warehouse\InvoiceDetailGradeProduct::find($purchaseOrderDetail->product_id);
                                                                                $rateProfileId = App\Helpers\Helper::getRateProfile($product_item->product_id, $product_item->grade_id);
                                                                                $productPrice = App\Helpers\Helper::getProductPrice($product_item->weight, $rateProfileId);
                                                                                $grandTotal += $productPrice * $purchaseOrderDetail->quantity;
                                                                            }
                                                                            
                                                                        @endphp



                                                                        <tr>
                                                                            <td>{{ $order->id }}</td>

                                                                            <td> INR. {{ $grandTotal }}
                                                                            </td>
                                                                            <td>{{ $order->purchaseOrderDetail->sum('quantity') }}
                                                                            </td>
                                                                            <td>{{ $order->status }}</td>
                                                                            <td>{{ $order->updated_at }}</td>
                                                                            <td><a href="{{ route('9gem_user_order_details', $order->id) }}"
                                                                                    class="btn btn-sqr">View</a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach




                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <h2>No orders yet</h2>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Single Tab Content End -->

                                            <!-- Single Tab Content Start -->
                                            {{-- <div class="tab-pane fade" id="posts" role="tabpanel">
                                                <button class="btn btn-sm btn-hero mr-0 my-4"><a
                                                        href="{{ route('9gem_blog_Create') }}" class="text-light">Create
                                                        new</a></button>
                                                <div class="myaccount-content">
                                                    <h5>Posts</h5>
                                                    @if (count($user_posts) > 0)
                                                        <div class="myaccount-table table-responsive text-center">

                                                            <table class="table table-bordered">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th>Title</th>
                                                                        <th>Description</th>
                                                                        <th>Tags</th>
                                                                        <th>Permalink</th>
                                                                        <th>Status</th>
                                                                        <th>Allow_comment</th>
                                                                        <th>Category</th>
                                                                        <th colspan="2">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>



                                                                    @foreach ($user_posts as $post)
                                                                        <tr>
                                                                            <td>{{ $post['title'] }}</td>
                                                                            <td>{{ $post['description'] }}</td>
                                                                            <td>{{ $post['tags'] }}</td>
                                                                            <td>{{ $post['permalink'] }}</td>

                                                                            @if ($post['publish'] == 1)
                                                                                <td>published</td>
                                                                            @else
                                                                                <td>drafted</td>
                                                                            @endif


                                                                            @if ($post['allow_comment'] == 1)
                                                                                <td>Allowed</td>
                                                                            @else
                                                                                <td>Not Allowed</td>
                                                                            @endif

                                                                            <td>{{ $post['category']['name'] }}</td>
                                                                            <td><a
                                                                                    href="{{ route('9gem_blog_delete', $post['id']) }}">Delete</a>
                                                                            </td>
                                                                            <td><a
                                                                                    href="{{ route('9gem_blog_edit', $post['id']) }}">Edit</a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <h2>No Posts Yet</h2>
                                                    @endif
                                                </div>
                                            </div> --}}
                                            <!-- Single Tab Content End -->
                                            <!-- Single Tab Content Start -->
                                            {{-- <div class="tab-pane fade" id="Uploads" role="tabpanel">
                                                    <div class="myaccount-content">
                                                        <h5>Uploads</h5>
                                                        <div class="myaccount-table table-responsive text-center">
                                                            <table class="table table-bordered">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th>username</th>
                                                                        <th>email</th>
                                                                        <th>uploaded_video_id</th>
                                                                        <th>view</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if (count($uploads) > 0)
                                                                        @foreach ($uploads as $video)
                                                                            <tr>
                                                                                <td>{{ $video['username'] }}</td>
                                                                                <td>{{ $video['email'] }}</td>
                                                                                <td>{{ $video['uploaded_video_id'] }}</td>
                                                                                <td><iframe
                                                                                        src="{{ 'https://www.youtube.com/embed/' . $video['uploaded_video_id'] }}"
                                                                                        frameborder="0"></iframe>
                                                                                </td>

                                                                            </tr>
                                                                        @endforeach

                                                                    @endif

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            <!-- Single Tab Content End -->

                                            <!-- Single Tab Content Start -->
                                            <div class="tab-pane fade  show" id="payment-method" role="tabpanel">
                                                <div class="myaccount-content">
                                                    <h5>Payment Method</h5>
                                                    <p class="saved-message">You Can't Saved Your Payment Method yet.
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- Single Tab Content End -->

                                            <!-- Single Tab Content Start -->
                                            <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                                @php
                                                    if (session('user')) {
                                                        $user = session('user');
                                                        $userDetails = \App\Model\Guard\UserStore::with('addresses', 'addresses.addressType', 'addresses.city', 'addresses.state', 'addresses.country')
                                                            ->where('id', $user['id'])
                                                            ->first();
                                                    }
                                                @endphp

                                                <button type="button" class="btn btn-sqr" onclick="addnewAddressModal()">
                                                    Add New
                                                    Address</button>
                                                @if ($userDetails != null)
                                                    <div class="single-input-item">
                                                        <label for="address" class="required"> Your Addresses
                                                            list</label>

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
                                            </div>
                                            <!-- Single Tab Content End -->


                                            <!-- Single Tab Content Start -->

                                            <div class="tab-pane fade" id="security" role="tabpanel">
                                                <div class="myaccount-content">
                                                    <h5>Security</h5>
                                                    <div class="account-details-form">




                                                        <div class="billing-form-wrap">
                                                            <form action="#" method="POST">
                                                                @csrf
                                                                <div class="row">


                                                                    <div class="col-lg-12">

                                                                        <label class="required d-block">Security</label>
                                                                        <div class="input-group single-input-item "
                                                                            id="show_hide_password">

                                                                            <input type="password" name="security_pin"
                                                                                id="password" class="form-control"
                                                                                data-toggle="password"
                                                                                value="{{ $user['security_pin'] }}">
                                                                            <div class="input-group-append cursor-pointer"
                                                                                style="cursor: pointer">
                                                                                <span
                                                                                    class="input-group-text cursor-pointer">
                                                                                    <i class="fa fa-eye"></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="single-input-item">
                                                                            <label for="new-pwd" class="required">New
                                                                                Security Pin</label>
                                                                            <input type="password" id="new-pwd"
                                                                                placeholder="Enter Security Pin"
                                                                                name="new_security_pin">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="single-input-item">
                                                                            <label for="confirm-pwd"
                                                                                class="required">Confirm
                                                                                Security Pin</label>
                                                                            <input type="password" id="confirm-pwd"
                                                                                placeholder="Confirm Security Pin"
                                                                                name="new_security_pin_confirm">
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                                <div class="single-input-item">
                                                                    <button class="btn btn-sqr">Save Changes</button>
                                                                </div>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div> <!-- Single Tab Content End -->
                                            <div class="tab-pane fade" id="account-info" role="tabpanel">
                                                <div class="myaccount-content">
                                                    <h5>Personal
                                                        details</h5>
                                                    <div class="account-details-form">




                                                        <div class="billing-form-wrap">
                                                            <form
                                                                action="{{ route('9gem_user_order_shipping_details_post') }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-lg-6">

                                                                        <div class="single-input-item">
                                                                            <label for="first-name"
                                                                                class="required">User
                                                                                Name</label>
                                                                            <input type="text" id="first-name"
                                                                                placeholder="First Name" name="name"
                                                                                value="{{ $user['name'] }}" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="single-input-item">
                                                                            <label for="email" class="required">Email
                                                                            </label>
                                                                            <input type="email" id="email"
                                                                                placeholder="Email Address" name="email"
                                                                                value="{{ $user['email'] }}">
                                                                        </div>
                                                                    </div>


                                                                </div>



                                                                <div class="single-input-item">
                                                                    <button class="btn btn-sqr">Save Changes</button>
                                                                </div>
                                                            </form>


                                                        </div>


                                                    </div>
                                                </div>
                                            </div> <!-- Single Tab Content End -->
                                        </div>
                                    </div> <!-- My Account Tab Content End -->
                                </div>
                            </div> <!-- My Account Page End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- my account wrapper end -->
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
                                    <input type="text" placeholder="locality" name="locality"
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
                                    <input type="text" placeholder="landmark" name="landmark"
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
                                    <input type="number" placeholder="pincode" name="pincode"
                                        value="{{ old('Pincode') }}">
                                </div>
                                <span class="text-danger">
                                    @error('Pincode')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>



                        </div>



                        <button class="btn btn-hero mx-auto d-block my-4" type="submit">Save Address</button>

                    </form>

                    <p class="pb-1 text-muted"><small>Your address is safe with us. We won't spam.</small></p>
                    <div class="bottom-strip" style="z-index: 1"></div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            $("#show_hide_password span").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script>

    <script>
        function getStates(country_id) {

            $.ajax({
                url: "{{ route('9gem_get_states') }}",
                data: {
                    'country_id': country_id
                }
            }).done(function(res) {
                // console.log(res);

                $.each(res, function(index, value) {

                    var option = '<option value=' + index + ' class="option"> ' + value + ' </option>';
                    var li = '<li data-value=' + index + ' class="option"> ' + value + ' </li>';
                    $('#statesSelect').append(option);
                    $('#statesSelect + div > ul').append(li);

                });
                // $(this).addClass("done");
            });
        }



        $('#countrySelect').on('change', function(e) {

            var country_id = e.currentTarget.value;

            getStates(country_id, '9gem_get_states');


        });


        function getCities(state_id) {

            $.ajax({
                url: "{{ route('9gem_get_cities') }}",
                data: {
                    'state_id': state_id
                }
            }).done(function(res) {
                // console.log(res);

                $.each(res, function(index, value) {

                    var option = '<option value=' + index + ' class="option"> ' + value + ' </option>';
                    var li = '<li data-value=' + index + ' class="option"> ' + value + ' </li>';
                    $('#citySelect').append(option);
                    $('#citySelect + div > ul').append(li);
                    $('#townSelect').append(option);
                    $('#townSelect + div > ul').append(li);

                });
                // $(this).addClass("done");
            });
        }

        $('#statesSelect').on('change', function(e) {

            var state_id = e.currentTarget.value;

            getCities(state_id);


        });
        // get-country-states
    </script>

    <script>
        //modal
        function addnewAddressModal() {
            $('#subscribeModal').modal('show');
        }
    </script>


@endsection
