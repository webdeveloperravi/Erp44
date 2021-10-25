@extends('layouts.store.app')
@section('content')
@php
    // dd($purchaseOrders);
@endphp
@if ($purchaseOrders->count() > 0)
    
<div class="container-fluid">
  <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Order Requests</h5>
  </div> 





      <div class="row">
        @foreach ($purchaseOrders as $order)
            
       
        <div class="col-sm-12">
            <div class="card card-border-primary">
            <div class="card-header p-3">
            <h5>Order Number : {{"#".$order->number }}</h5>
            
            <div class="dropdown-secondary dropdown f-right">
            <button class="btn btn-primary btn-mini dropdown-toggle waves-effect waves-light" type="button" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Overdue</button>
            <div class="dropdown-menu" aria-labelledby="dropdown1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
            <a class="dropdown-item waves-light waves-effect" href="#!"><span class="point-marker bg-danger"></span>Pending</a>
            <a class="dropdown-item waves-light waves-effect" href="#!"><span class="point-marker bg-warning"></span>Paid</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item waves-light waves-effect active" href="#!"><span class="point-marker bg-success"></span>On Hold</a>
            <a class="dropdown-item waves-light waves-effect" href="#!"><span class="point-marker bg-info"></span>Canceled</a>
            </div>
            
            <span class="f-left m-r-5 text-inverse">Status : </span>
            </div>
            </div>
            <div class="card-block">
            <div class="row">
            <div class="col-sm-6">
            <ul class="list list-unstyled">
            <li><span class="bold-text-new">Vendor #:</span> &nbsp;{{ $order->store->parentStore->name }}</li>
            {{-- <li>{{ $order->created_at }}</li> --}}
            {{-- Trick Date --}}
            <li> <span class="bold-text-new">Placed on:</span> <span class="text-semibold">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->toDayDateTimeString()}}</span></li>
            </ul>
            </div>
            <div class="col-sm-6">
            <ul class="list list-unstyled text-right">
            <li>$8,750</li>
            <li>Method: <span class="text-semibold">SWIFT</span></li>
            </ul>
            </div>
            </div>
            </div>
            <div class="card-footer">
            {{-- <div class="task-list-table">
            <p class="task-due"><strong> Due : </strong><strong class="label label-primary">23 hours</strong></p>
            </div> --}}
            <div class="task-board m-0">
            <a href="{{route('store.dashboard.purchase.order.detail.complete.view',$order->id)}}" class="btn btn-info btn-mini b-none"><i class="icofont icofont-eye-alt m-0"></i></a> 
            
            <div class="dropdown-secondary dropdown">
            <button class="btn btn-info btn-mini dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown14" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
            <div class="dropdown-menu" aria-labelledby="dropdown14" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
            <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-ui-alarm"></i> Print Invoice</a>
            <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-attachment"></i> Download invoice</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-spinner-alt-5"></i> Edit Invoice</a>
            <a class="dropdown-item waves-light waves-effect" href="#!"><i class="icofont icofont-ui-edit"></i> Remove Invoice</a>
            </div>
            
            </div>
            
            </div>
            
            </div>
            
            </div>
            </div>
            @endforeach
    </div>




















      {{-- <div class="table-responsive">
            <table   id="example" class="table  table-bordered table-hover" style="width:100">
              <thead >
                     <tr class="table-active">
                       <th>Sr.No</th>
                       <th>Buyer Name</th>
                       <th>Purchase Order Number</th>
                       <th>Date</th>
                         <th>Action</th>
                        </tr>
                      </thead>
                 <tbody>
                   @foreach($purchaseOrders as $order)
                   <tr class="text-center">
                     <td >{{'#'.$loop->iteration}}</td>
                   	<td >{{$order->buyerStoreName->name ?? ""}}</td>
                     <td >{{$order->number}}</td>
                     <td>
                     @if ($order->created_at)
                      {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$order->created_at)->toDayDateTimeString()}}
                      @endif
                    </td> 
                 
                   	<td>  <a href="{{route('store.dashboard.purchase.order.detail.complete.view',$order->id)}}" class="btn btn-sm btn-primary waves-effect waves-light f-right mr-3" >View</a>
                      
                   	</td>
                   	 
                  </tr>
                   @endforeach
                 </tbody>
                </table>
              </div> --}}
 

</div>

@endif
@section('script')
<script type="text/javascript">
	
	function viewOrder(id) {
	 var url ="{{route('store.dashboard.purchase.order.detail.complete.view',['/'])}}/"+id;
	 $.get(url,function(data){
	   $("#view").html(data);
      });
	}
</script>

@endsection
  


@endsection