@extends('layouts.store.app')
@section('content') 
 <div class="card" id="form">
   <!--Header ---->
   <div class="card-footer p-0" style="background-color: #04a9f5">
     <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">My Product Stock</h5>
    </div>
   
   <div class="card-body"> 
   <form id="createForm" onsubmit="event.preventDefault();">
     @csrf
    <div class="row"> 
           <div class="col-xl-3 col-md-6 col-12 mb-1" id="managerRoles">
               <div class="form-group" id="state">
                 <label for="parentId">Select Product</label>
                 <select class="form-control" name="product_id">
                  <option value="0">All</option>
                   @foreach ($products as $product) 
                   <option value="{{ $product->id }}">{{ $product->name }}</option> 
                   @endforeach
                 </select>
               </div> 
           </div>  
           <div class="col-xl-3 col-md-6 col-12 mb-1" id="managerRoles">
               <div class="form-group" id="state">
                 <label for="parentId">Select Grade</label>
                 <select class="form-control" name="grade_id">
                  <option value="0">All</option>
                   @foreach ($grades as $grade) 
                   <option value="{{ $grade->id }}">{{ $grade->alias }}</option> 
                   @endforeach
                 </select>
               </div> 
           </div>   
           <div class="col-xl-3 col-md-6 col-12 mb-1" id="managerRoles">
               <div class="form-group" id="state">
                 <label for="parentId">Select Ratti</label>
                 <select class="form-control" name="ratti_id">
                  <option value="0">All</option>
                   @foreach ($rattis as $ratti) 
                   <option value="{{ $ratti->id }}">{{ $ratti->rati_standard }}</option> 
                   @endforeach
                 </select>
               </div> 
            </div> 
              <div class="col-xl-2 col-md-4 col-12 my-auto">
                <div class="form-group mt-lg-4"> 
                  <button class="btn btn-primary" onclick="getProducts()">Get Products</button> 
                </div>
           </div>  
          </div>
        </form>
        {{-- <div id="productsView"></div> --}}
        <div id="all"></div>
      </div>
    </div> 
 
    
@endsection
@section('script')
        
  
 <script> 
   function getProducts(){
      $.ajax({
         url : "{{ route('myStock.getProducts') }}",
         method : "POST",
         data : $("#createForm").serialize(),
         success: function(data){
            // $("#productsView").show();
            $("#all").html(data);
            // $("#productsView").html(data);
         }
      });
   } 
     function backToView(){
        $("#all").html("");
        $("#productsView").show();
     }
    
     

   
 </script>

@endsection

