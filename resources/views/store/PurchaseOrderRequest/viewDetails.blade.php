<div class="table-responsive">
    <table class="table" id="" style="width:100">
        <thead>
          <tr>
            <th>Sr.No</th> 
            <th>Product</th>
            <th>Grade</th>
            <th>Ratti</th>
            <th>Request Qty.</th>
            <th>Confirmed Qty.</th>
            @if (!$purchaseOrderRequest->approved)
            <th>Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
     @foreach($purchaseOrderRequest->purchaseOrderDetail as $orderDetail)
      <tr class="text-center">
       <td>{{'#'.$loop->iteration}}</td> 
       <td>{{$orderDetail->product->name}}</td>
       <td>{{$orderDetail->grade->alias}}</td>
       <td>{{$orderDetail->ratti->rati_standard}}</td>
       <td>{{$orderDetail->quantity}}</td> 
       <td>{{$orderDetail->confirmed_qty}}</td> 
       
@if (!$purchaseOrderRequest->approved)
  <td> 
    <button onclick="editQty({{ $orderDetail->id }})">Edit Qty</button> 
    <button onclick="removeDetail({{ $orderDetail->id }})">Remove</button> 
  </td>
  @endif
      </tr>
      @endforeach
      </tbody> 
    </table>
</div>
@if (!$purchaseOrderRequest->approved)
<form  onsubmit="event.preventDefault(0)" id="approveForm">
  @csrf
<input type="hidden" name="orderId" value="{{ $purchaseOrderRequest->id }}"> 
</form>

<div class="row"> 
  <div class="col">
     <button class="btn btn-dark float-right mb-3" onclick="approveOrder()">Approve Order</button>
   </div>
</div>
@else 
@endif
