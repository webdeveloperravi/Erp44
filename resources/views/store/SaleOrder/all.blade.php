 
@if (count($saleOrders))
 
        <div class="table-responsive">
          <table class="table" id="table_id4" style="width:100">
              <thead>
                <tr>
                  <th>UID</th>
                <th>So-No.</th>
                <th>Po-No.</th> 
                <th>Date</th>
                <th>Account</th>
                <th>Created By</th>
                <th>Total Qty</th>
                <th>Status</th>
                <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($saleOrders as $order)
                <tr class="text-center"> 
                  <td>{{ $order->id }}</td>
                  <td>{{ $order->so_number ? 'SO'.'-'.$order->seller_store_id.'-'.$order->so_number : "X"}}</td>  
                  <td>{{ $order->po_number ? 'PO'.'-'.$order->buyer_store_id.'-'.$order->po_number : "X" }}</td>  
                <td>{{  Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->isoFormat('DD-MM-YYYY') }}</td> 
                <td>{{ $order->buyerStoreName->company_name ?? ""}}</td>  
                <td>{{ $order->createdBy->name ?? ""}}</td>  
                <td>{{ $order->getTotalPurchaseOrderQty($order->id) }}</td>   
                <td> 
                  @if ($order->ledger_id != null)
               Prepared 
                @elseif($order->approved)
                Approved
                @else
                Pending-Approval 
               @endif
         </td>
                <td colspan="2"><a href="{{ route('saleOrder.view',$order->id) }}" class="btn btn-sm btn-primary">View</button>
                  </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>UID</th>
              <th>So-No.</th>
              <th>Po-No.</th> 
              <th>Date</th>
              <th>Account</th>
              <th>Created By</th>
              <th>Total Qty</th>
              <th>Prepared</th>
              <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div> 
  @else 
  <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2> 
  @endif
<script> 
  function viewSaleOrder(id){
       var url = "{{ route('saleOrder.view',['/']) }}/"+id;
       $.get(url,function(data){
            $("#saleOrderView").html(data);
       });
  }

    $(document).ready(function() {
	$('#table_id4 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "All Sale Orders";
   var columns = [0, 1, 2, 3, 4, 5];
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
		// 	orientation: 'landscape',
		// 	pageSize: 'a4',
		// 	messageTop: messageTop2
		// }, {
		// 	extend: 'print',
		// 	exportOptions: {
		// 		columns: columns,
    //      },
    //      title: cardTitle,
    //      messageTop: `<div class="ml-2"></div>`+messageTop
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