 

<div class="md-modal md-effect-1 md-show editModal" id="modal-1">
  <div class="modal-dialog" role="document">
    <form  onsubmit="event.preventDefault();" id="updateForm">
    <div class="modal-content">
      <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Update Detail </h5>
       </div>
      <div class="modal-body">
          <div class="row">
            @csrf
            <input type="hidden" name="order_id" value="{{$detailEdit->id}}"> 
          <div class="col-xl-6 mb-1">
            <div class="form-group" id="products">
              <label for="parentId">Select Product</label>
              <select class="form-control" name="product" id="productId" aria-readonly="true">
                  <option value="0">Select Product</option>
                   @foreach ($products as $product)
                  <option value="{{ $product->id }}" {{$product->id ==$detailEdit->product_id ? 'selected' : ''}}> {{$product->name }}</option>   
                 @endforeach)
              </select> 
            </div> 
          </div> 
          <div class="col-xl-6 mb-1">
            <div class="form-group" id="products">
              <label for="parentId">Select Grade</label>
              <select class="form-control" name="grade" id="gradeId" aria-readonly="true">
                  <option value="0">Select Grade</option>
                  @foreach ($grades as $grade)
                  <option value="{{ $grade->id }}" {{$grade->id==$detailEdit->grade_id ? 'selected' : ''}}>{{ $grade->alias }}</option>  
                  @endforeach
              </select> 
            </div> 
          </div> 
          @if (auth('store')->user()->role->unit->id == 2)
          <div class="col-xl-6 mb-1">
            <div class="form-group" id="products">
              <label for="parentId">Select Standard Ratti</label>
              <select class="form-control" name="ratti" id="rattiId" aria-readonly="true">
                  <option value="0">Select Ratti</option>
                  @foreach ($ratties as $ratti)
                  <option value="{{ $ratti->id}}" {{$ratti->id==$detailEdit->ratti_id ? 'selected' : ''}}>{{ $ratti->rati_standard."+" }}</option>  
                  @endforeach
              </select> 
            </div> 
          </div> 
            @else
          <div class="col-xl-6 mb-1">
            <div class="form-group" id="products">
              <label for="parentId">Select Big Ratti</label>
              <select class="form-control" name="ratti" id="rattiId" aria-readonly="true">
                  <option value="0">Select Big Ratti</option>
                  @foreach ($ratties as $ratti)
                  <option value="{{ $ratti->id}}" {{$ratti->id==$detailEdit->ratti_id ? 'selected' : ''}}>{{ $ratti->rati_big."+" }}</option>  
                  @endforeach
              </select> 
            </div> 
          </div> 
          @endif
          <div class="col-xl-6 mb-1">
            <div class="form-group">
              <label for="basicInput">Quantity</label>
              <select class="form-control" name="quantity" id="">
                @for ($i = 1; $i <= 20; $i++)
                @if ($i == $detailEdit->quantity)
                <option value="{{ $i }}" selected>{{ $i }}</option>
                @else
                <option value="{{ $i }}">{{ $i }}</option>
                @endif
                @endfor
              </select> 
            </div>
          </div> 
          
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="updatePurchaseOrderDetail()">Update</button> 
          <button type="button" class="btn btn-secondary" onclick="$('#editPurchaseOrderPage').html('')">Close</button>
        </div>
      </div>
        
    </div>
  </form>    
</div>
</div>

 <div class="md-overlay"></div>
<script> 
 
 function getProducts(productCategoryId){
   var url ="{{ route('purchaseorder.getproducts',['/']) }}/"+productCategoryId;
   // alert(url);
   $.get(url,function(data){
      $("#products").html(data);
   });
 }

</script> 
 