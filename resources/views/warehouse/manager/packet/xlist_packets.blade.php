@extends('layouts.warehouse.app')
@section('content')
<div class="page-header">
  <div class="row align-items-end">
  <div class="col-lg-8">
  <div class="page-header-title">
  <div class="d-inline">
  <h4>Invoice Packets</h4>
  {{-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> --}}
  </div>
  </div>
  </div>
  <div class="col-lg-4">
  <div class="page-header-breadcrumb">
  <ul class="breadcrumb-title">
  <li class="breadcrumb-item">
  <a href="index.html"> <i class="feather icon-home"></i> </a>
  </li>
  <li class="breadcrumb-item"><a href="#!">Widget</a> </li>
  </ul>
  </div>
  </div>
  </div>
  </div>
<div class="invoiceView"><div class="card"><!--Card Start-->
  {{-- <div class="card-header"><!--Card header Start--> 
  <h5 class="text-left ">Product Category : {{ $packets[0]->invoiceDetailGrade->invoiceDetail->assign_product->name }} </h5><br>
  <h5 class="text-left ">Product  : {{ $packets[0]->invoiceDetailGrade->invoiceDetail->product->name }} </h5><br>
  <h5 class="text-left ">Invoice Number : {{ $packets[0]->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }} </h5><br> --}}
  </div><!--Card header End-->
<div class="card-body">
  <div class="table-responsive ">
  <table class="table table-bordered table-hover ">
  <thead class="table-dark">
  <tr>
  <th>S.No</th> 
  <th>Invoice</th>
  <th>Number</th>
  <th>Grade</th>
  <th>Pieces</th>
  <th>Ratti</th> 
  <th>Actions</th> 
  </tr>
  </thead>
  <tbody> 
    @foreach ($packets as $packet)
        @php
            // dump($packet->invoiceDetailGrade);
        @endphp
  
      <tr class="text-center">
        <td>{{ $loop->iteration }}</td>
      <td><label>{{ $packet->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }}</label></td>
      <td><label>{{ $packet->number }}</label></td>
      <td><label>{{$packet->invoiceDetailGrade->grade->grade }}</label></td>
      <td><label>{{ $packet->total_piece }}</label></td>
      <td><label>{{ $packet->ratti->rati_standard }}</label></td> 
      @if ($packet->return_to_super == '1')

      <td> <button class="btn btn-sm btn-dark">Returned To Super</a></td> 
      @else     
      <td> <a href="{{ route('packet.return',$packet->id) }}" class="btn btn-sm btn-primary">Return To Super</a></td> 
      @endif

      </tr>  
   @endforeach
  </tbody>
  </table>
  </div>
</div>
</div><!--Card End-->

<!--Modal Part-->
<div class="modal-part"></div>


</div>


@endsection