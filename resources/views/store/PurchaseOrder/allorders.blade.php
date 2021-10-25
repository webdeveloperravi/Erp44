 <div class="card"> 
    <div class="card-footer p-0" style="background-color: #04a9f5">
       <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Purchase Orders</h5>
    </div>
 <div class="card-body">
      @if($orders->isNotEmpty())
       <div class="table-responsive">
          <table class="table" id="table_id4" style="width:100">
             <thead>
                <tr>
                   <th>UID</th>
                <th>Po-No.</th>
                <th>So-No.</th>
                <th>Date</th>
                <th>Vendor</th> 
                <th>Total Qty</th> 
                <th>Status</th>
               <th>Action</th> 
                </tr>
             </thead>
             <tbody>
               @foreach ($orders as $order)
                <tr class="text-center"> 
                <td>{{ $order->id }}</td>
                <td>{{ $order->po_number ? 'PO'.'-'.$order->buyer_store_id.'-'.$order->po_number : "X" }}</td>  
                <td>{{ $order->so_number ? 'SO'.'-'.$order->seller_store_id.'-'.$order->so_number : "X"}}</td>  
                <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->isoFormat('DD-MM-YYYY') }}</td> 
                <td>{{$order->store->company_name ?? '' }}</td> 
                <td>{{$order->getTotalPurchaseOrderQty($order->id) }}</td>
                <td> 
               @if ($order->ledger_id != null)
               Prepared 
                @elseif($order->approved)
                Approved
                @else
                Pending-Approval 
               @endif
                 
                </td>
                    <td><a href="{{route('purchaseorder.order.detail',$order->id)}}" class="btn btn-sm btn-info ">View</Button></td>  
                </tr>
                @endforeach
             </tbody>
             <tfoot>
               <tr>
                  <th>UID</th>
               <th>Po-No.</th>
               <th>So-No.</th>
               <th>Date</th>
               <th>Vendor</th> 
               <th>Total Qty</th> 
               <th>Status</th>
              <th>Action</th> 
               </tr>
             </tfoot>
          </table>
       </div>
        @else
        <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
        @endif 
        </div>
 </div>


 <script> 
   

   $(document).ready(function() {
	$('#table_id4 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "All Purchase Orders";
   var columns = [0, 1, 2, 3, 4];
	// DataTable
	var authUserId = "{{ auth('store')->user()->id ?? __}}";
	var authUserName = "{{ auth('store')->user()->name ?? __}}";
	var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
	var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
	var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
var messageTop2 =`Report from UID : ` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
	var table = $('#table_id4').DataTable({
		// dom: 'Bfrtip',
		// buttons: [{
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
		// 	// orientation: 'landscape',
		// 	pageSize: 'a4',
		// 	messageTop: messageTop2
		// }, {
		// 	extend: 'print',
		// 	exportOptions: {
		// 		columns: columns,
      //    },
      //    title: cardTitle,
      //    messageTop: `<div class="ml-2"></div>`+messageTop
		// }, ],
      "lengthMenu": [50, 75, 100 ],
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
