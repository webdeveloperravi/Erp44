<div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Challan Details #{{$receiveChallan->voucher_number ?? ''}}</h5>
   </div>
  
  <div class="card-body"> 
  <div class="row">

  <div class="col col-md-6">

  <div class="row">
    
    <div class="col col-md-3">
      <img src="{{ asset('public/images/lead-images/abc.jpg') }}" alt="" class="img-fluid img-thumbnail" width="100">
    </div>

    <div class="col-md-9">
    <h6>To : <span>{{$receiveChallan->userReceipt->name ?? ''}}</span></h6>
    <h6>Date : <span>  {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$receiveChallan->created_at)->isoFormat('DD-MM-YYYY') }}</span></h6>
  
    </div>

   </div>
  </div>
</div>
<form onsubmit="event.preventDefault(0)" id="createForm">
    @csrf
    <div class="row">
        <!--  <input type="hidden" name="temp_number" value="{{Session::get('temp_challan_number')}}"> -->
        <div class="col col-xl-3 col-md-3"> 
          <div class="form-group">
              <input type="hidden" name="ledger_id" value="{{ $receiveChallan->id }}">
        <label for="parentId">GIN Number:</label>
        <input type="text" class="form-control" id="gin" placeholder="Enter Gin" name="gin">
        </div>
      </div>
        <div class="col col-xl-3 col-md-3"> 
        <div class="form-group">
      <label for="parentId">&nbsp;</label>
        <button type="button" class="btn btn-primary btn-sm form-control" onclick="addProduct()">Add</button>
        </div>
        </div>
</div>
</form>
<ul class="nav nav-tabs m-2" role="tablist" >
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#nav_orderDetails"  onclick="orderDetails()">OrdreDetails</a>
  </li>
 
 
</ul>


<div class="tab-content">
  <div id="nav_orderDetails" class="container tab-pane active"><br>
      <div class="card-body">
          @if (!empty($receiveChallan->ledgerDetails))
   <div class="table-responsive">
   <table class="table" id="example" style="width:100">
       <thead>
       <tr>
           <th>Sr.</th> 
           <th>GIN</th> 
           <th>Product</th>
           <th>Grade</th>
           <th>Exact Ratti</th>
           <th>Amount</th> 
           <th>Action</th> 
       </tr>
   </thead>
   <tbody>
   @foreach($receiveChallan->ledgerDetails as $product)
   <tr>
       <td>{{$loop->iteration}}</td> 
       <td>{{ $product->productStock->gin }}</td>  
       <td>{{ $product->productStock->product->alias }}</td>  
       <td>{{ $product->productStock->productGrade->alias }}</td>  
       <td>{{ $product->product_unit_qty }}</td> 
       <td>{{ amountFormat($product->total_amount)}}</td>
       <td><button onclick="deleteProduct({{ $product->id }})">Delete</button></td>
   </tr>
   @endforeach
   <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Total Amount</td>
    <td>{{ amountFormat($receiveChallan->total_amount) }}</td> 
  </tr>
   </tbody>
   </table>
</div>
@else 
<div class="card-body">
    <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
</div>
@endif
</div>
</div>
  

</div>



</div><!---card Body Div close-->