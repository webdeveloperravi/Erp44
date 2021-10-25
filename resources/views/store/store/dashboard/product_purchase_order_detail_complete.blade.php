@extends('layouts.store.app')
@section('content')
 
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-footer p-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Order Details</h5>
       </div>
       <div class="card-block p-0">
        @if (!empty($purchaseOrder))
            
        
        <div class="table-responsive ">
          <table class="table table-bordered table-hover ">
              <thead>
                     <tr class="table-active">
                         <th>Sr.No</th>
                         <th>Product Category</th>
                         <th>Product</th>
                         <th>Grade</th>
                         <th>Ratti</th>
                         <th>Quantity</th>
                         {{-- <th>Action</th> --}}
                     </tr>
                 </thead>
                 <tbody>
                  @foreach($purchaseOrder->purchaseOrderDetail as $orderDetail)
                   <tr class="text-center">
                    <td>{{'#'.$loop->iteration}}</td>
                    <td>{{$orderDetail->productCategory->name}}</td>
                    <td>{{$orderDetail->product->name}}</td>
                    <td>{{$orderDetail->grade->grade}}</td>
                    <td>{{$orderDetail->ratti->rati_standard}}</td>
                    <td> 
        <input type="hidden" name="orderDetailId" value="{{$orderDetail->id}}"><input type="text" name="quantity" value="{{$orderDetail->quantity}}" onfocusOut="updateQuantity({{$orderDetail->id}},this.value)"></td>
        
                   </tr>
                   @endforeach
                 </tbody>
             </table>
         </div>
         
         <button type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right mr-3" onclick="issueStock()">
          Stock Issue
          </button>
          @endif
</div>  
</div>
</div>

<div class="col-md-12" id="stockIssueIndex">

</div>
</div>
  

@section('script')
<script type="text/javascript">
 
 function issueStock(){
   var orderId = "{{ $purchaseOrder->id ?? "" }}";
   var url = "{{ route('stock.issue.index',['/']) }}/"+orderId;
   $.get(url,function(data){
      $("#stockIssueIndex").html(data);
   });
 }



  function updateQuantity(id,qty)
  {
    $.ajax({
    
        url : "{{route('store.dashboard.purchase.order.detail.complete.update')}}",
        method : "POST",
        data : {
          _token : "{{csrf_token()}}",
          id : id,
          qty : qty

        },
        success :  function(data){
          
          swal("Update Record",'', "success");
        }
    });
  }
  

</script>
@endsection
@endsection
