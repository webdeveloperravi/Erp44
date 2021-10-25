@if(count($orderDetails))
<div class="table-responsive">
   <table class="table" id="table_id2" style="width:100">
      <thead>
         <tr>
         <th>Sr.</th> 
         <th>Product</th>
         <th>Grade</th>
         <th>Ratti Standard</th> 
         <th>Qty.</th> 
         <th>Action</th> 
         </tr>
      </thead>
      <tbody>
         @foreach ($orderDetails as $detail)
         <tr class="text-center">
            <td>{{$loop->iteration}}</td> 
            <td>{{$detail->product->name ?? " "}}</td>  
            <td>{{$detail->grade->grade ?? " "}}</td>  
            <td>{{$detail->ratti->rati_standard . "+" }}</td>  
            <td>{{$detail->quantity ?? ""}}</td>  
            <td colspan="2">
                  {{-- <Button onclick="editDetail('{{$detail->id }}')">Edit</Button> --}}
                  <Button onclick="deleteDetail('{{$detail->id }}')">Delete</Button>
               </td>  
         </tr>
         @endforeach
	  </tbody>
	  <tfoot>
		<tr>
			<th>Sr.</th> 
			<th>Product</th>
			<th>Grade</th>
			<th>Ratti Standard</th> 
			<th>Qty.</th> 
			<th>Action</th> 
			</tr>
	  </tfoot>
   </table>
</div>
<div class="card-footer" >
<button class="f-right btn btn-sm btn-inverse"  onclick="placeOrder()" >Place Order</button>
</div> 
@else 
@endif  
<script>  
   $(document).ready(function() {
	$('#table_id2 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Order Details";
   var columns = [0, 1, 2, 3, 4];
	// DataTable
	var authUserId = "{{ auth('store')->user()->id ?? __}}";
	var authUserName = "{{ auth('store')->user()->name ?? __}}";
	var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
	var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
	var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
var messageTop2 =`Report from UID : ` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
	var table = $('#table_id2').DataTable({
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excelHtml5',
			exportOptions: {
				columns: columns,
			},
			text: 'Export Excel',
			title: cardTitle,
		}, {
			extend: 'pdfHtml5',
			download: 'open',
			exportOptions: {
				columns: columns,
			},
			text: 'Export Pdf',
			title: cardTitle,
			orientation: 'landscape',
			pageSize: 'a4',
			messageTop: messageTop2
		}, {
			extend: 'print',
			exportOptions: {
				columns: columns,
         },
         title: cardTitle,
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

 

    