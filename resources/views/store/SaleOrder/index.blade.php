@extends('layouts.store.app')
@section('content') 
<div class="row"> 
  <div class="col">
   <a class="btn btn-inverse float-right mb-3 text-white" href="{{ route('saleOrder.create') }}">Create Sale Order</a>
   </div>
</div>
<div id="create"></div> 
<div class="card"> 
<div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Sale Orders</h5>

</div>
 <div class="card-body">
   <div class="row">
     <div class="col col-md-4"> 
           <div class="form-group"> 
              <label for="ifscCode">Select Account</label>
              <select class="form-control" id="userId" onchange="allSaleOrders()">  
                 <option value="all">All</option>
                 <option value="{{ auth('store')->user()->id }}" selected>Current Only</option>
                 @foreach ($managers as $manager)  
                 <option value="{{ $manager->id }}">{{ $manager->name }}</option> 
                 @endforeach
              </select>
           </div> 
     </div>
  </div> 
   <div id="all"></div>
   
</div>
</div>


 
@endsection
@section('script')
<script>
  $(document).ready(function () {
    allSaleOrders();
  });
function allSaleOrders(){
  var userId =$("#userId").val();
  var url = "{{ route('saleOrder.all',['/']) }}/"+userId;
      $.get(url,function(data){
         $("#all").html(data);
      });
}

function createSaleOrder(){

var url ="{{route('saleOrder.create')}}";
$.get(url,function(data){
    $("#create").html(data);
});
}
  
</script>

@endsection