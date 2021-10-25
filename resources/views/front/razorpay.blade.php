<!DOCTYPE html>
<html>

<head>
    <title>How To Integrate Razorpay Payment Gateway In Laravel - websolutionstuff.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Error!</strong> {{ $message }}
                    </div>
                @endif
                {!! Session::forget('error') !!}
                @if ($message = Session::get('success'))
                    <div class="alert alert-info alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Success!</strong> {{ $message }}
                    </div>
                @endif
                {!! Session::forget('success') !!}
                <div class="panel panel-default" style="margin-top: 30px;">
                    <h3>Razor pay gateway</h3><br>
                    <div class="panel-heading">
                        <h2>Pay With Razorpay</h2>

                        <!-- <div class="panel-body text-center"> -->
                        <form action="{{ route('razorpay_post') }}" method="POST">
                            @csrf
                            <button>Pay now</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
