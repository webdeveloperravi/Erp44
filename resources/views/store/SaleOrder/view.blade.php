@extends('layouts.store.app')
@section('content') 
@php
$buyerManager = App\Helpers\StoreHelper::getUserStoreById($saleOrder->created_by); 
$buyerStore =  App\Helpers\StoreHelper::getUserStoreById($saleOrder->buyer_store_id);
$sellerStore =  App\Helpers\StoreHelper::getUserStoreById($saleOrder->seller_store_id);

$savedChallan  = \App\Helpers\Helper::challanSaved($saleOrder->id);
@endphp

<div class="row">
  <div class="col-6">
    <a href="{{route('saleOrder.index')}}" class="btn btn-inverse btn-sm  m-2">Back</a>
  </div>
  <div class="col-6 text-right">
     
    @if ($saleOrder->ledger_id == null && $saleOrder->approved)
    <a class="btn btn-dark text-right" href="{{ route('store.saleOrderPrepare.index',$saleOrder->id) }}">Prepare Order</a>
    @endif
  </div>
  </div> 
<div class="card"> 
<div class="card-footer p-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Sale Order Details &nbsp; &nbsp;&nbsp;{{ $saleOrder->buyerStoreName->company_name ?? ''}}</h5> 
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
        <h6><strong>Date : </strong><span>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $saleOrder->created_at)->isoFormat('DD-MM-YYYY') }}</span></h6>
        <h6><strong> Purchase Order No. : </strong>#<span>{{$saleOrder->po_number ?? ''}}</span></h6>
        
        @if ($saleOrder->approved)
        <h6><strong> Sale Order No. : </strong>#<span>{{$saleOrder->so_number ?? ''}}</span></h6>
        
  @endif
      </div>
      <div class="col-md-4"> 
        
  @if ($saleOrder->approved)
        <h6><strong> Approved :  </strong><span class="text-success">Yes</span></h6>
        <h6><strong> Approved By :  </strong><span >{{ $saleOrder->approvedBy->name ?? "" }}</span></h6>
  @endif
        @if ($saleOrder->ledger_id != null)
        <h6><strong> Preapred Challan :  </strong><span class="text-success">Sale Challan Created</span></h6>
        @endif
        
      </div>
  
       </div>
    </div>
 </div>
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
      </tr>
  </thead>
  <tbody>
   @foreach($saleOrder->purchaseOrderDetail as $orderDetail)
    <tr class="text-center">
     <td>{{'#'.$loop->iteration}}</td> 
     <td>{{$orderDetail->product->alias}}</td>
     <td>{{$orderDetail->grade->grade}}</td>
     <td>{{$orderDetail->ratti->rati_standard}}</td>
     <td>{{$orderDetail->quantity}}</td> 
     <td>{{$orderDetail->confirmed_qty}}</td> 
 
    </tr>
    @endforeach
    </tbody> 
  </table>
</div>
   
</div>
@endsection
@section('script')
<script type="text/javascript">
 


 function updateQuantity(orderId)
  {
  
    let qty = $("#quantity").val(); 
    $.ajax({
        url : "{{route('saleOrder.update')}}",
        method : "POST",
        data : {
          _token : "{{csrf_token()}}",
          id : orderId,
          qty : qty
        },
        success :  function(data){
          notify('Quantity Updated','success');
         location.reload();
        }
    });
  }
  
  $(document).ready(function() {
	$('#table_id2 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Sale Order Details";
   var columns = [0, 1, 2, 3, 4, 5];
	// DataTable
	var authUserId = "{{ auth('store')->user()->id ?? __}}";
	var authUserName = "{{ auth('store')->user()->name ?? __}}";
	var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
	var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
	var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
	var table = $('#table_id2').DataTable({
		dom: 'Bfrtip',
		buttons: [
    //   {
		// 	extend: 'excelHtml5',
		// 	exportOptions: {
		// 		columns: columns,
		// 	},
		// 	text: 'Export Excel',
		// 	title: cardTitle,
		// }, {
		// 	extend: 'pdfHtml5',
		// 	download: 'open',
		// 	exportOptions: {
		// 		columns: columns,
		// 	},
		// 	text: 'Export Pdf',
		// 	title: cardTitle,
		// 	orientation: 'landscape',
		// 	pageSize: 'a4',
		// 	messageTop: messageTop
		// },
     {
			extend: 'print',
			exportOptions: {
				columns: columns,
         },
         title: `<h4 class="ml-2">`+cardTitle+`</h4>`,
         messageTop: `<div class="ml-2"></div>`+messageTop
		}, ],
		"order": [],
		"aaSorting": [],
		initComplete: function() {
			this.api().columns().every(function() {
				var that = this;
				$('input', this.footer()).on('keyup change clear', function() {
					if(that.search() !== this.value) {
						that.search(this.value).draw();
					}
				});
			});
		}
	});
});

</script> 
@endsection