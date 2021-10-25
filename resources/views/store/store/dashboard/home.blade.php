@extends('layouts.store.app')
@section('content')
<div class="row"> 
    <div class="col-xl-3 col-md-6">
        <a href="{{ route('saleOrder.index') }}" class="">
    <div class="card">
    <div class="card-block">
    <div class="row align-items-center">
    <div class="col-8">
    <h4 class="text-c-yellow f-w-600"></h4>
    <h6 class="text-muted m-b-0">Order Requests</h6>
     </div>
    <div class="col-4 text-right">
    <i class="feather icon-bar-chart f-28"></i>
    </div>
    </div>
    </div>
    <div class="card-footer bg-c-green ">
    <div class="row align-items-center">
    <div class="col-12">
        <p class="text-white m-b-0">Product Purchase Orders</p>
    </div>
 
    </div>
    </div>
    </div>
        </a>
    </div>
    @php
        // dump($users);
    @endphp
@endsection