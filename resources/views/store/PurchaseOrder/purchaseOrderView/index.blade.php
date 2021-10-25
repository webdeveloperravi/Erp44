 @extends('layouts.store.app')
@section('css')
<style>
   th {
   text-align: left !important;
   }
</style>
@endsection
@section('content')
<div class="row">
<div class="col">
  <a href="{{route('purchaseorder.index')}}" class="btn btn-inverse btn-sm  m-2">Back</a>
</div>
</div>  
<div class="card">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{$order->buyerStoreName->name ?? ''}}</h5>
     </div>
    
    <div class="card-body"> 
    <div class="row">

    <div class="col col-md-6">

    <div class="row">
      
      <div class="col col-md-3">
        <img src="{{ asset('public/images/lead-images/abc.jpg') }}" alt="" class="img-fluid img-thumbnail" width="100">
      </div>

      <div class="col-md-9">
      <h6>To : <span>{{$order->store->name ?? ''}}</span></h6>
      <h6>Date : <span>  {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->isoFormat('DD-MM-YYYY') }}</span></h6>
      <h6>Order No. : #<span>{{$order->po_number ?? ''}}</span></h6>
    
      </div>

     </div>
    </div>
 </div>

  <ul class="nav nav-tabs m-2" role="tablist" >
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#nav_orderDetails"  onclick="orderDetails()">OrdreDetails</a>
    </li>
   
   
  </ul>

 
  <div class="tab-content">
    <div id="nav_orderDetails" class="container tab-pane active"><br>
    <div id="details">
    

    </div>
</div>
    

  </div>



</div><!---card Body Div close-->
</div><!--Card Div Close-->

 
@endsection
@section('script')
<script>
$(document).ready(function(){
  orderDetails();
})
function orderDetails(){
  
  var url = "{{route('purchaseorder.view.orderDetail',['/'])}}/"+"{{$order->id}}";
  $.get(url,function(data){
    $("#details").html(data);
  })

}
  
</script>

@endsection





















































