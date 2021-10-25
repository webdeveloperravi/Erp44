@extends('layouts.front.app')

@section('page_title') User Registration @endsection
@section('page_description') description @endsection

@section('content')

    <div class="head">
        <h2 class="text-center">Singup</h2>
        <hr class="w-25 mx-auto">
    </div>


    <div class="container my-5">
        <div class="login-reg-form-wrap sign-up-form col-8 mx-auto">
            <form action="{{ route('9gem_user_register_post') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="name" class="required">Full Name</label>
                            <input type="text" placeholder="Full Name" name="name" required="" value="{{ old('name') }}">
                        </div>
                        <span class="text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-lg-4">

                        <div class="single-input-item">
                            <label for="name" class="required">Email</label>
                            <input type="email" placeholder="Email" name="email" required="" value="{{ old('email') }}">
                        </div>
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="company_name">Company name <span class="text-gray">(optional)</span></label>
                            <input type="text" placeholder="Company name" name="company_name"
                                value="{{ old('company_name') }}">
                        </div>
                        <span class="text-danger">
                            @error('company_name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>






                <div class="row">

                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="Country" class="required">Country</label>
                            <select class="form-control" name="Country" id="countrySelect" value="{{ old('Country') }}">
                                <option value="" selected>Select a country</option>
                                @foreach ($countries as $key => $Country)


                                    <option value="{{ $key }}" {{ old('Country') == $key ? 'selected' : ' ' }}>
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

                            <select class="form-control" name="State" id="statesSelect">
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
                            <select class="form-control" name="City" id="citySelect">

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
                            <select class=" form-control"
                                name="Address-Type">

                                @foreach ($addressTypes as $key => $type)
                                    <option value="{{ $key }}"
                                        {{ old('Address-Type') == $key ? 'selected' : ' ' }}>{{ $type }}
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
                            <label for="Full-Address" class="required">Full Address</label>
                            <input type="text" placeholder="FUll Address" name="Full-Address"
                                value="{{ old('Full-Address') }}">
                        </div>
                        <span class="text-danger">
                            @error('Full-Address')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-lg-4">
                        <div class="single-input-item">
                            <label for="Town" class="required">Town</label>
                            <select class="form-control" name="Town" id="townSelect">

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
                            <input type="text" placeholder="Locality" name="Locality" value="{{ old('Locality') }}">
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
                            <input type="text" placeholder="Landmark" name="Landmark" value="{{ old('Landmark') }}">
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
                            <input type="number" placeholder="Pincode" name="Pincode" value="{{ old('Pincode') }}">
                        </div>
                        <span class="text-danger">
                            @error('Pincode')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>



                </div>
                <div class="row">

                    <div class="col-lg-6 mb-1 single-input-item">

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
                                <input type="text" placeholder="Phone No" name="phone" required=""
                                    value="{{ old('phone') }}">


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
                    <div class="col-lg-6 mb-1 single-input-item">
                        <label for="basicInput">WhatsApp No <span class="text-gray">(optional)</span></label>
                        <div class="row">
                            <div class="col-xl-3 col-3 pr-0">
                                <select class="form-control" name="whats_app_country_code_id">

                                    @foreach ($phoneCodes as $key => $code)
                                        <option value="{{ $key }}"
                                            {{ old('whats_app_country_code_id') == $key ? 'selected' : ' ' }}>
                                            +{{ $code }}</option>
                                    @endforeach



                                </select>
                            </div>
                            <div class="col-xs-9 col-9 pl-1">
                                <input type="number" placeholder="Whatsapp no" name="whats_app"
                                    value="{{ old('whats_app') }}">


                            </div>
                            <span class="text-danger pl-3">
                                @error('whats_app_country_code_id')
                                    {{ $message }}
                                @enderror

                                @error('whats_app')
                                    {{ $message }}
                                @enderror

                            </span>



                        </div>
                    </div>


                </div>

                <div class="single-input-item">
                    <div class="g-recaptcha" data-sitekey="6LfKh5IcAAAAAHVNXkMVpqU79iNPmiqiUtiL1d_m" style="width: 100%">
                    </div>
                    <span class="text-danger">
                        @error('g-recaptcha-response')
                            {{ 'Please fill reCaptcha field .' }}
                        @enderror
                    </span>
                </div>



                <div class="single-input-item">
                    <button class="btn btn-sqr" id="submitBtn">Register</button>
                </div>
            </form>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer>
    </script>
    {{-- <script src='https://www.google.com/recaptcha/api.js'></script> --}}
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
