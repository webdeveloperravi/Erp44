@extends('layouts.store.app')
@section('content')  
 @php
    $buyerManager = App\Helpers\StoreHelper::getUserStoreById($purchaseOrderRequest->created_by); 
    $buyerStore =  App\Helpers\StoreHelper::getUserStoreById($purchaseOrderRequest->buyer_store_id);
    $sellerStore =  App\Helpers\StoreHelper::getUserStoreById($purchaseOrderRequest->seller_store_id);
 @endphp
 <div class="row">
  <div class="col">
    <a href="{{route('purchaseOrderRequest.index')}}" class="btn btn-inverse btn-sm  m-2">Back</a>
  </div>
  </div>  
<div class="card"> 
<div class="card-footer p-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">
      Order Request Details :  </h5> 
</div>
<div class="card-body">
  <div class="row">

    <div class="col col-md-12">

    <div class="row">
      
      <div class="col-md-4">
      <h6><strong>To Store :  </strong> <span>{{ $sellerStore->company_name ?? "" }}</span></h6>
      <h6><strong>From Manager : </strong> <span>{{ $buyerManager->name ?? ''}}</span></h6>
      <h6><strong>From Store : </strong> <span>{{ $buyerStore->company_name ?? ''}}</span></h6>
     </div>
    <div class="col-md-4">
      <h6><strong>Date : </strong><span>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $purchaseOrderRequest->created_at)->isoFormat('DD-MM-YYYY') }}</span></h6>
      <h6><strong> Purchase Order No. : </strong>#<span>{{$purchaseOrderRequest->po_number ?? ''}}</span></h6>
      
      @if ($purchaseOrderRequest->approved)
      <h6><strong> Sale Order No. : </strong>#<span>{{$purchaseOrderRequest->so_number ?? ''}}</span></h6>
      
@endif
    </div>
    <div class="col-md-4"> 
      
@if ($purchaseOrderRequest->approved)
      <h6><strong> Approved :  </strong><span class="text-success">Yes</span></h6>
      <h6><strong> Approved By :  </strong><span >{{ $purchaseOrderRequest->approvedBy->name ?? "" }}</span></h6>
@endif
      @if ($purchaseOrderRequest->ledger_id != null)
      <h6><strong> Preapred Challan :  </strong><span class="text-success">Sale Challan Created</span></h6>
      @endif
      
    </div>

     </div>
    </div>
 </div>
 @if (!$purchaseOrderRequest->approved)
     
 <form  onsubmit="event.preventDefault();" id="detailForm">

  <section id="basic-input">
           <div class="row">
             @csrf  
             <input type="hidden" name="orderId" value="{{ $purchaseOrderRequest->id }}">
           <div class="col-xl-2 col-md-4 col-12 mb-1">
             <div class="form-group" id="products">
               <label for="parentId">Select Product</label>
               <select class="form-control" name="product" id="productId" aria-readonly="true" onchange="getGrades(this.value)">
                   <option value="0">Select Product</option>
                  @foreach ($products as $product)
                  <option value="{{ $product->id }}">{{ $product->name ?? "" }}</option>    
                  @endforeach
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
           @if ($buyerStore->role->unit->id == 2) 
           <div class="col-xl-2 col-md-4 col-12 mb-1">
             <div class="form-group" id="products">
               <label for="parentId">Select Standard Ratti</label>
               <select class="form-control" name="ratti" id="rattiId" aria-readonly="true"> 
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
             </div>
           </div> 
           <div class="col-xl-1 col-md-4 col-12 mb-1">
             <div class="form-group">
               <label for="parentId" class="invisible d-block">Hidden</label>
               <button class="btn btn-inverse btn-sm" onclick="saveDetail()">Add</button>
             </div>
           </div>  
           </div>
      
  </section>
 </form>
 
 @endif
  <div class="row" id="viewDetail">
    
    </div>
  </div>
</div>
<div id="editQty"></div>
@endsection
@section('script')
<script type="text/javascript">
 
 viewDetail();

 function viewDetail(){
   
  var url = "{{ route('purchaseOrderRequest.viewDetail',['/']) }}/"+"{{ $purchaseOrderRequest->id }}";
      $.get(url,function(data){
         $("#viewDetail").html(data);
      });
 }
 
function editQty(id){ 
  var url = "{{ route('purchaseOrderRequest.editQty',['/']) }}/"+id;
      $.get(url,function(data){
         $("#editQty").html(data);
      });
}


function updateQty()
{ 
  $.ajax({
      url : "{{route('purchaseOrderRequest.updateQty')}}",
      method : "POST",
      data : $("#editQtyForm").serialize() ,
      success :  function(data){
        notify('Quantity Updated','success');
        $("#editQty").html('');
        viewDetail();
      }
  });
}

function removeDetail(id){ 
    swal({
			title: "Confirm to Delete !",
			text: '',
			type: "info",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		 }, function () { 
      var url = "{{route('purchaseOrderRequest.deleteDetail',['/'])}}/"+id;
         $.get(url,function(data){  
               viewDetail(); 
         }); 
         swal.close();
		}
  );
}

function approveOrder(){ 
    swal({
			title: "Confirm to Approve !",
			text: 'This action cannot be undone',
			type: "info",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		 }, function () { 
      var url = "{{route('purchaseOrderRequest.approve')}}";
      $.ajax({
      url : url,
      method : "POST",
      data : $("#approveForm").serialize() ,
      success :  function(data){
        notify('Order Approved Successfully','success');  
        location.reload();
      }
  });
         swal.close();
		}
  );
}


function getGrades(productId){

var url ="{{route('purchaseorder.getGrades',['/'])}}/"+productId;
$.get(url,function(data){
    $("#grades").html(data);
});
}

function saveDetail(){
  hideErrors();
  $.ajax({
      url : "{{route('purchaseOrderRequest.saveDetail')}}",
      method : "POST",
      data : $("#detailForm").serialize() ,
      success :  function(data){
        if(data.errors){
               $.each(data.errors,function(field_name,error){
                  $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
             }); 
        }else{
            notify('Succcessfully Saved','success'); 
            viewDetail();
        }
      }
  });
}

   
</script> 
@endsection