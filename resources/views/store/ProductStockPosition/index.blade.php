@extends('layouts.store.app')
@section('content') 
<div class="card">
   <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Product Stock Availability</h5>
   </div>
   <div class="card-body"> 
      <form id="createForm" onsubmit="event.preventDefault();">
        @csrf
         <div class="row"> 
              <div class="col-xl-3 col-md-6 col-12 mb-1" id="managerRoles">
                  <div class="form-group" id="state">
                    <label for="parentId">Select Product</label>
                    <select class="form-control" name="product" onchange="getProductProperties(this.value)">
                     <option value="0">All</option>
                      @foreach ($products as $product) 
                      <option value="{{ $product->id }}">{{ $product->name }}</option> 
                      @endforeach
                    </select>
                  </div> 
              </div>  
         </div>
             <div id="productProperties" class="row">

             </div>
             <div class="row">
               <div class="col-xl-2 col-md-4 col-12 my-auto">
                  <div class="form-group mt-lg-4"> 
                     <button class="btn btn-primary" onclick="getReport()">Get Products</button> 
                  </div>
               </div>
             </div>
             <div id="view" class="row">

             </div>

           </form> 
         </div>

</div>
@endsection
@section('script')
<script> 
 function getProductProperties(productId){
    var url = "{{ route('productStockPosition.getProductProperties',['/']) }}/"+productId;
    $.get(url,function(data){
             $("#productProperties").html(data);
 
    });
 }

    function getReport(){
      $.ajax({
         url : "{{ route('productStockPosition.getReport') }}",
         method : "POST",
         data : $("#createForm").serialize(),
         success: function(data){ 
            $("#view").html(data); 
         }
      });
   }

</script> 

@endsection