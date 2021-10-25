<div class="card">
  <form  onsubmit="event.preventDefault();" id="createForm">
  <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class=" text-white m-b-0" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> 
       <span class="text-right">Temp Order No. #{{ Session::get('temp_number') }}</span></h5>
   </div>
   <div class="card-block">

 <section id="basic-input">
  <div class="row">
    <div class="col-md-12">  
            <div class="row">
              @csrf
              <div class="col-xl-4 col-md-4 col-12 mb-1"> 
                 <div class="form-group">
                             <label for="parentId">Buyer Store</label>
                             <select class="js-example col-sm-12" name="buyer_id" id="buyerId"> 
                              <option value="0">Select Buyer Store</option>    
                              @foreach ($buyers as $buyer)
                               @continue($buyer->id == auth('store')->user()->id) 
                               <option value="{{ $buyer->id }}">{{ $buyer->company_name }} - {{ $buyer->headOfficeAddress->city->name }}</option>
                               @endforeach
                             </select>
                             
                           </div>
              </div> 
            <div class="col-xl-3 col-md-4 col-12 mb-1">
              <div class="form-group">
                <label for="parentId">Product Category</label>
                <select class="form-control" name="product_category" id="productCategoryId" onchange="getProducts(this.value)" readonly> 
                  @foreach ($productCategories as $category)
                  @if($category->id == 2)
                  <option value="{{ $category->id }}" selected>{{ $category->name }}</option>   
                  @else 
                   @endif   
                  @endforeach)
                </select>
              </div> 
            </div> 
            
            <div class="col-xl-4 col-md-4 col-12 mb-1">
            </div>
            <div class="col-xl-2 col-md-4 col-12 mb-1">
              <div class="form-group" id="products">
                <label for="parentId">Select Product</label>
                <select class="form-control" name="product" id="productId" aria-readonly="true">
                    <option value="0">Select Product</option>
                </select> 
              </div> 
            </div> 
            <div class="col-xl-2 col-md-6 col-12 mb-1">
              <div class="form-group" id="grades">
                <label for="parentId">Select Grade</label>
                <select class="form-control" name="grade" id="gradeId" aria-readonly="true">
                    <option value="0">Select Grade</option> 
                </select> 
              </div> 
            </div> 
            @if (App\Helpers\Helper::getStoreRoleUnitId() == 2)
            <div class="col-xl-2 col-md-4 col-12 mb-1">
              <div class="form-group" id="products">
                <label for="parentId">Select Standard Ratti</label>
                <select class="form-control" name="ratti" id="rattiId" aria-readonly="true">
                    <option value="0">Select Standard Ratti</option>
                    @foreach ($ratties as $ratti)
                    <option value="{{ $ratti->id}}">{{ $ratti->rati_standard."+" }}</option>  
                    @endforeach
                </select> 
              </div> 
            </div> 
              @else
            <div class="col-xl-2 col-md-4 col-12 mb-1">
              <div class="form-group" id="products">
                <label for="parentId">Select Big Ratti</label>
                <select class="form-control" name="ratti" id="rattiId" aria-readonly="true">
                    <option value="0">Select Big Ratti</option>
                    @foreach ($ratties as $ratti)
                    <option value="{{ $ratti->id}}">{{ $ratti->rati_big."+" }}</option>  
                    @endforeach
                </select> 
              </div> 
            </div> 
            @endif 
            <div class="col-xl-1 col-md-4 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Quantity</label>
                <select class="form-control" name="quantity" id="">
                  @for ($i = 1; $i <= 20; $i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                  @endfor
                </select>
                {{-- <input name="quantity" type="number" class="form-control" id="quantity" onkeyup="quantityChecker()" /> --}}
              </div>
            </div> 
            <div class="col-xl-1 col-md-4 col-12 mb-1">
              <div class="form-group">
                <label for="parentId" class="invisible d-block">Hidden</label>
                <button class="btn btn-sm btn-dark"onclick="storePurchaseOrderDetail()">Add</button> 
              </div>
            </div>  
            </div>
       
    </div>
  </div>
</section> 
     
     
    
   </div>
  </form> 
  <div id="saleOrderDetails">
     
  </div>
</div> 
{{-- <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/pages/advance-elements/select2-custom.js"></script> --}}
<script>
  $(document).ready(function(){ 
  // $("#productCategoryId").trigger('change');
  getProducts(2);
});
$('.js-example').select2({
  placeholder: 'Select an option'
});
  function getProducts(productCategoryId){
    var url ="{{ route('saleOrder.getproducts',['/']) }}/"+productCategoryId;
    // alert(url);
    $.get(url,function(data){
       $("#products").html(data);
    });
  }
</script>
