<form  onsubmit="event.preventDefault();" id="createForm">

 <section id="basic-input">
          <div class="row">
            @csrf
            <div class="col-xl-4 col-md-4 col-12 mb-1"> 
              <div class="form-group">
                <label for="parentId">Select Company</label> 
                 <select class="js-example-basic-single col-sm-12" name="vendor" >
                  <option value="0">Select Company</option>  
                  @foreach ($parentStores as $store) 
                  @continue($store->id == auth('store')->user()->id) 
                  <option value="{{ $store->id }}">{{ $store->company_name ?? "" }} - {{ $store->headOfficeAddress->city->name ?? "" }}</option>   
                  @endforeach 
                </select> 
                <div id="vendorError"></div>
              </div> 
            </div> 
          <div class="col-xl-3 col-md-4 col-12 mb-1">
            <div class="form-group">
              <label for="parentId">Product Category</label>
              <input type="hidden" name="product_category" value="2">
              <select class="form-control" name="product_category" id="productCategoryId" onchange="getProducts(this.value)" disabled>
                <option value="0">Select Product Category</option>
                @foreach ($productCategories as $category)
                 <option value="{{ $category->id }}" {{$category->id == 2 ? 'selected' : '' }}>{{ $category->name }}</option>   
                @endforeach)
              </select>
            </div> 
          </div> 
          
          <div class="col-xl-4 col-md-4 col-12 mb-1">
          </div>
          <div class="col-xl-2 col-md-4 col-12 mb-1">
            <div class="form-group" id="products">
              <label for="parentId">Select Product</label>
              <select class="form-control" name="product" id="productId" aria-readonly="true" onchange="getGrades(this.value)">
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
          @if (App\Helpers\StoreHelper::getUserStoreById(App\Helpers\StoreHelper::getStoreId())->role->unit->id == 2)
{{--               
          @endif
          @if (auth('store')->user()->role->unit->id ?? 2 == 2) --}}
          <div class="col-xl-2 col-md-4 col-12 mb-1">
            <div class="form-group" id="products">
              <label for="parentId">Select Standard Ratti</label>
              <select class="form-control" name="ratti" id="rattiId" aria-readonly="true">
                  <option value="0">Select Ratti</option>
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
              <button class="btn btn-primary" onclick="storePurchaseOrderDetail()">Add</button>
            </div>
          </div>  
          </div>
     
 </section>
</form>
    <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/pages/advance-elements/select2-custom.js"></script>

<script>
 


  $(document).ready(function(){
  
   $("#productCategoryId").trigger("change");

  })
  function getProducts(productCategoryId){
    var url ="{{ route('purchaseorder.getproducts',['/']) }}/"+productCategoryId;
    // alert(url);
    $.get(url,function(data){
       $("#products").html(data);
    });
  }

function quantityChecker(){
  
  const qty=$("#quantity").val();
  if(qty >15){
    alert("Enter Quantity should be 15 less than");
  }

}


</script>
