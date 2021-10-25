@extends('layouts.front.app')

@section('page_title') Order Accepted @endsection
@section('page_description') Order Accepted @endsection
@section('content')

    <div class="jumbotron text-center">
        <h1 class="display-3">Order Accepted!</h1>
        <p class="lead"><strong>Thank You </strong> for shopping from us , your order will be delivered soon.
            <hr>
        <p>
            Having trouble? <a href="{{ route('9gemhome') }}">Contact us</a>
        </p>
        <p class="lead">
            <a class="btn btn-sqr " href="{{ route('9gemhome') }}" role="button">Continue to homepage</a>
            <a class="btn btn-sqr " href="{{ route('9gem_user_order_details', session('order_id')) }}" role="button">View
                Order Details</a>
        </p>
    </div>
@endsection
