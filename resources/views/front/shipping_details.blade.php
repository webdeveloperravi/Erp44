@extends('layouts.front.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10 mx-auto">
                <h2 class=" checkout-title text-hero text-center" style="font-weight: 450">Enter Shipping Details</h2>

                <div class="row">

                    <!-- Checkout Billing Details -->

                    <div class="col-lg-10 mx-auto">
                        <div class="checkout-billing-details-wrap">
                            <div class="billing-form-wrap">
                                <form action="{{ route('9gem_user_order_shipping_details_post') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_slug" value="{{ $order_slug }}">
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
                                                <label for="Address-Type" class="">Address Type</label>
                                                <select class="form-control" name="Address-Type">

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

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')

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



@endsection
