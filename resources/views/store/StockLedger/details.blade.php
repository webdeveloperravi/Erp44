<div class="card" id="form">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Transaction Voucher No.{{ $ledger->voucher_number }}</h5>
	 </div>
 
 <div class="card-body">
@if (count($ledger->ledgerDetails))
<div class="table-responsive">
    <table class="table" id="table_id5" style="width:100">
        <thead>
            <tr class="text-center">
                <th>Sr.</th>
                <th>Gin</th>
                <th>Product</th>
                <th>Grade</th> 
                <th>Ratti</th> 
                <th>Amount</th> 
            </tr>
        </thead>
        <tbody> 
            @foreach($ledger->ledgerDetails as $detail)
            <tr class="text-center">
                <td>{{$loop->iteration}}</td> 
                <td>{{ $detail->productStock->gin }}</td>  
                <td>{{ $detail->productStock->product->name }}</td>  
                <td>{{ $detail->productStock->productGrade->grade }}</td>  
                <td>{{ $detail->productStock->ratti->rati_standard }}</td>  
                <td>{{ $detail->total_amount }}</td>  
            </tr> 
            @endforeach
        </tbody>
        <tfoot>
            <tr class="text-center">
                <th>Sr.</th>
                <th>Gin</th>
                <th>Product</th>
                <th>Grade</th> 
                <th>Ratti</th> 
                <th>Amount</th> 
            </tr>
        </tfoot>
    </table>
</div>
@else
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Transactions</h2>
@endif
</div> 
</div>
<script>
      $(document).ready(function() {
	$('#table_id5 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });

   var cardTitle = "Transaction Voucher No.{{ $ledger->voucher_number }}";
   var columns = [0, 1, 2, 3, 4];
	// DataTable
	var authUserId = "{{ auth('store')->user()->id ?? __}}";
	var authUserName = "{{ auth('store')->user()->name ?? __}}";
	var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
	var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
	var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
	var table = $('#table_id5').DataTable({
                stateSave: true,
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
			messageTop: messageTop
		}, {
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