@extends('layouts.front.app')

@section('page_title') User login @endsection

@section('page_description') user login @endsection

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
                                    <li class="breadcrumb-item active" aria-current="page">login</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->
        @if (session('message'))

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>
                    <h4 class="text-center">{{ session('message') }}!</h4>
                </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="head mt-5">
            <h2 class="text-center text-uppercase">User Login </h2>
            <hr class="w-25 mx-auto">
        </div>

        <!-- login register wrapper start -->
        <div class="login-register-wrapper section-padding my-4">
            <div class="container">
                <div class="member-area-from-wrap">
                    <div class="row">
                        <!-- Login Content Start -->
                        <div class="col-lg-6 mx-auto">
                            <div class="login-reg-form-wrap">

                                <form action="" method="">
                                    @csrf

                                    <div class="single-input-item otp_block" style="display: none">
                                        <input type="number" name="otp" placeholder="ENTER OTP" required="">
                                        <span id="otp_msg" class="text-success text-uppercase text-center d-block"></span>
                                        <span id="otp_error" class="text-danger text-uppercase text-center d-block"></span>
                                    </div>

                                    <div class="single-input-item user_auth_block">
                                        <input type="number" name="phone" placeholder="ENTER MOBILE NO" id="phone">
                                        <span id="phone_error"
                                            class="text-danger text-uppercase text-center d-block"></span>
                                    </div>


                                    <div class="single-input-item user_auth_block">
                                        <button class="btn btn-sqr text-uppercase d-block" style="width: 100%" type="button"
                                            onclick="userAuth()">GET
                                            Otp
                                        </button>


                                    </div>

                                    <div class="single-input-item otp_block" style="display: none">
                                        <button class="btn btn-sqr text-uppercase d-block" style="width: 100%" type="button"
                                            onclick="checkOtp()">Verify
                                            Otp</button>

                                        <div>
                                            <button class="btn btn-sqr text-uppercase mt-2 text-center"
                                                style="display: none" id="resend_otp" type="button" onclick="resendOtp()">
                                                Resend OTP</button>
                                            <p id="timer_container" style="display: none"
                                                class="text-danger text-uppercase text-center">Resend
                                                Otp
                                                in <span id="count">
                                                </span></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Login Content End -->


                    </div>
                </div>
            </div>
        </div>
        <!-- login register wrapper end -->
    </main>

@endsection

@section('scripts')
    <script>
        function clearMsgs() {
            setTimeout(() => {
                $('#otp_error').text(' ');
                $('#phone_error').text(' ');
                $('#otp_msg').text(' ');
            }, 3000);
        }

        function showResendOtp() {

            var count = 30;
            $('#resend_otp').fadeOut();
            $('#timer_container').show();
            var timer = setInterval(() => {
                count = count - 1;
                $('#count').text(count + 's');
            }, 1000);

            setTimeout(() => {
                clearInterval(timer)
                $('#timer_container').hide();
                $('#resend_otp').fadeIn();
            }, 30000);

        }


        function userAuth() {

            var phone = $('#phone').val();


            $('#phone_error').text('Please wait...');


            $.ajax({
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "phone": phone
                },
                url: "{{ route('9gem_user_login_post') }}",
                success: function(response) {
                    $('#phone_error').text(' ');
                    $('#otp_error').text(' ');

                    if (response.msg_type == "error") {
                        var msg = response.msg;
                        for (let key in msg) {
                            $('#' + key + '_error').text(msg[key]);

                        }

                    } else {
                        $('.user_auth_block').hide();
                        $('.otp_block').show();
                        $('#otp_error').text(' ');
                        $('#otp_msg').text(response.msg);

                        showResendOtp();
                    }

                    // do whatever you want with the response 
                }
            });

            clearMsgs();
        }

        function checkOtp() {
            let otp = $('.otp_block input').val();
            $('#otp_error').text('Please wait...');


            $.ajax({
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "otp": otp
                },
                url: "{{ route('9gem_user_login_verify_otp') }}",
                success: function(response) {

                    if (response.msg_type == "error") {
                        var msg = response.msg;
                        $('#otp_error').text(msg.otp);
                    } else {
                        $('#otp_error').text(' ');
                        $('#otp_msg').text('Authentication successfull...');
                        window.location.href = "{{ route('9gemhome') }}";

                    }
                }


            });

            clearMsgs();

        }




        function resendOtp() {

            $.get("{{ route('9gem_resend_otp') }}", (res) => {

                if (res.type == 'success') {
                    showResendOtp();
                    $('#otp_msg').text('Otp resend successfully!');

                } else {
                    $('#otp_msg').text('Error while resending Otp!');
                }

            })


            clearMsgs();
        }
    </script>

@endsection
