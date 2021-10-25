@extends('layouts.front.app')

@section('page_title')User Wishlist @endsection
@section('page_description') account page description @endsection
@section('content')
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
                                <li class="breadcrumb-item active" aria-current="page">my-wishlist</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <div class="head my-4">
        <h2 class="text-center text-uppercase text-hero" style="color:#c29958">Wish List <i class='fa fa-heart'
                aria-hidden='true'></i></h2>
    </div>
    <div class="container">
        <div class="col-lg-12 col-md-12 mx-auto ">
            <div class="tab-content" id="myaccountContent">

                @if (count($items) > 0)
                    <!-- Single Tab Content Start -->
                    <div class="tab-pane fade active show" id="orders" role="tabpanel">
                        <div class="myaccount-content">






                            <div class="myaccount-table table-responsive text-center">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Product Item Name</th>
                                            <th>Product Category</th>
                                            <th>Product Name</th>
                                            <th>Product price</th>

                                            <th>View Product</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($items as $item)

                                            @php
                                                $item = \App\Model\Warehouse\InvoiceDetailGradeProduct::find($item->product_item_id);
                                                
                                                $rateProfileId = App\Helpers\Helper::getRateProfile($item->product_id, $item->grade_id);
                                                $productPrice = App\Helpers\Helper::getProductPrice($item->weight, $rateProfileId);
                                                
                                                // dd($grandTotal);
                                                
                                            @endphp
                                            <tr>
                                                <td>{{ $item->product->alias }}
                                                    -
                                                    {{ $item->productGrade->alias }} -
                                                    {{ $item->ratti->rati_standard }}+</td>

                                                <td>{{ $item->productCategory->name }}
                                                </td>
                                                <td>{{ $item->product->name }}
                                                </td>
                                                <td>INR. {{ $productPrice }}
                                                </td>




                                                <td><a href="{{ route('9gem_product_details', ['product_name' => $item->product->name, 'product_item_id' => $item->id]) }}"
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
                @else
                    <div class="jumbotron text-center">
                        <h2 class="text-center text-capitalize my-4">Nothing is in your wishlist</h2>

                        <p class="lead">

                            <a class="btn btn-sqr " href="{{ route('9gemhome') }}" role="button">Continue to
                                Homepage</a>

                        </p>
                    </div>
                @endif



            </div>


        </div>
    </div>

    </div>

@endsection
