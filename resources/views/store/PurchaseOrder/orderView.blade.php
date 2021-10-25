@extends('layouts.store.app')
@section('content')
<div class="row"> 
<div class="col-md-12">
          <div class="card">
            <div class="card-footer p-0" style="background-color: #04a9f5">
              <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Order No. {{ "#" .$order->number }}</h5>
             </div>
             <div class="card-bloc">
              <div class="table-responsive ">
                <table class="table table-bordered table-hover ">
                    <thead>
                        <tr class="table-active">
                            <th>S.No</th>
                            <th>Product Category</th>
                            <th>Product</th>
                            <th>Grade</th>
                            <th>Ratti</th> 
                            <th>Qty.</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->purchaseOrderDetail as $detail)
                        <tr class="text-center">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$detail->productCategory->name}}</td>  
                            <td>{{$detail->product->name}}</td>  
                            <td>{{$detail->grade->grade}}</td>  
                            <td>{{$detail->ratti->rati_standard."+"}}</td>  
                            <td>{{$detail->quantity}}</td>  
                        </tr> 
                        @endforeach
                    </tbody>
                </table>
                </div>
               {{-- <button class="float-right" onclick="placeOrder()">Place Order</button> --}}
            </div>
        </div>
      </div> 
      </div> 
<div class="row" id="allView">
  
</div>

 
        
@endsection
@section('script')
<script>
$(document).ready(function(){
   allView();
 });
 
 function allView(){
   var url = "{{ route('purchaseorder.order.viewAll',['/']) }}/"+"{{ $id }}";
      $.get(url,function(data){
         $("#allView").html(data);
      });
 }
</script>
@endsection     
      
 
