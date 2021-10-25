@extends('layouts.warehouse.app')
@section('css')
<style>
.alert{
margin-bottom: 4px;
}
 body {
     background-color: #f9f9fa
 }

 .flex {
     -webkit-box-flex: 1;
     -ms-flex: 1 1 auto;
     flex: 1 1 auto
 }

 @media (max-width:991.98px) {
     .padding {
         padding: 1.5rem
     }
 }

 @media (max-width:767.98px) {
     .padding {
         padding: 1rem
     }
 }

 .padding {
     padding: 5rem
 }

 .card {
     box-shadow: none;
     -webkit-box-shadow: none;
     -moz-box-shadow: none;
     -ms-box-shadow: none
 }

 .pl-3,
 .px-3 {
     padding-left: 1rem !important
 }

 .card {
     position: relative;
     display: flex;
     flex-direction: column;
     min-width: 0;
     word-wrap: break-word;
     background-color: #fff;
     background-clip: border-box;
     border: 1px solid #d2d2dc;
     border-radius: 0
 }

 .card .card-title {
     color: #000000;
     margin-bottom: 0.625rem;
     text-transform: capitalize;
     font-size: 0.875rem;
     font-weight: 500
 }

 .card .card-description {
     margin-bottom: .875rem;
     font-weight: 400;
     color: #76838f
 }

 p {
     font-size: 0.875rem;
     margin-bottom: .5rem;
     line-height: 1.5rem
 }

 .table-responsive {
     display: block;
     width: 100%;
     overflow-x: auto;
     -webkit-overflow-scrolling: touch;
     -ms-overflow-style: -ms-autohiding-scrollbar
 }

 .table,
 .jsgrid .jsgrid-table {
     width: 100%;
     max-width: 100%;
     margin-bottom: 1rem;
     background-color: transparent
 }

 .table thead th,
 .jsgrid .jsgrid-table thead th {
     border-top: 0;
     border-bottom-width: 1px;
     font-weight: 500;
     font-size: .875rem;
     text-transform: uppercase
 }

 .table td,
 .jsgrid .jsgrid-table td {
     font-size: 0.875rem;
     padding: .875rem 0.9375rem
 }

 .badge {
     border-radius: 0;
     font-size: 12px;
     line-height: 1;
     padding: .375rem .5625rem;
     font-weight: normal
 }
</style>
@endsection
@section('content')
<div class="page-content page-container" id="page-content">
    <div class=" ">
        <div class="row container d-flex justify-content-center">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        {{-- <a class="btn btn-success btn-sm float-left" href="{{url()->previous()}}">Back</a>  --}}
                           <h4 class="float-left ml-3">Invoice Number :  {{$invoice->invoice_number}}</h4>
                           <div class="float-right"> 
                               <h4 class="mb-4">Invoice Date : {{date_format($invoice->created_at,'d-m-Y')}}</h4>
                           </div>
                        {{-- <p class="card-description"> Basic table with card </p> --}}
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sr. </th>
                                        <th>Product </th> 
                                        <th>Weight </th> 
                                        <th>Pieces</th>
                                        <th>Rate</th> 
                                        <th>Amount</th> 
                                        <th>Gradesort</th> 
                                    </tr>
                                </thead>
                                <tbody> 
                                  @if (empty($invoice))
           
                                    @else
                                    @foreach ($invoice->invoiceDetail as $detail)
                                    <tr class="text-center">
                                     @php
                                        //  dd($detail->product->name);
                                     @endphp
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ $detail->carat }}</td>
                                        <td>{{ $detail->piece }}</td>
                                        <td>{{ $detail->rate }}</td>
                                        <td>{{ $detail->amount }}</td> 
                                        <td>{{ $detail->amount }}</td> 
                                        @php 
                                        
                                        @endphp 
                                    </tr>
                                    @endforeach
                                    @endif  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="container-fluid">
  <div class="card">
    <div class="card-header">
      <h4>All invoices</h4> 
    </div>
    <div class="card-block table-border-style">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Invoice Number</th>
              <th>Organiazation</th>
              <th>Date</th>
              <th>Total Amount</th>
              <th>View</th>
            </tr>
          </thead>
          <tbody>
            @foreach($invoices as $invoice)
            <tr class="table-active">
              <th scope="row">1</th>
              <td>{{$invoice->number}}</td>  
              <td>{{$invoice->total_amount}}</td> 
            </tr> 
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div> --}}
<!--Container End-->
@endsection