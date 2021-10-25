@if (count($saleReturns))
        <div class="table-responsive">
           <table class="table" id="table_id2" style="width:100">
           <thead>
            <tr>
                <th>Return No.</th>
                <th>Date</th>
                <th>Pieces</th>
                <th>From</th>
                <th>To</th>
                <th>Action</th>
                </tr>
           </thead>
           <tbody>
            @foreach ($saleReturns as $return)
            <tr class="text-center">
            <td>{{$return->voucher_number ?? ''}}</td>  
            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $return->created_at)->isoFormat('DD-MM-YY') }}</td> 
            <td>{{ $return->qty_total }}</td>  
            <td> @if ($return->userIssue->type == 'user')
                    {{$return->userIssue->name ?? ""}} <br>
                    ({{$return->userIssue->parentStore->company_name ?? ""}})
                    @else
                    {{$return->userIssue->name ?? ""}} <br>
                    ({{$return->userIssue->company_name ?? ""}})
                    @endif</td>  
            <td>  @if ($return->userReceipt->type == 'user')
                    {{$return->userReceipt->name ?? ""}} <br>
                    ({{$return->userReceipt->parentStore->company_name ?? ""}})
                    @else
                    {{$return->userReceipt->name ?? ""}}  <br>
                    ({{$return->userReceipt->company_name ?? ""}})
                    @endif</td>  
            <td><a href="{{ route('saleReturn.view',$return->id) }}" class="btn btn-sm btn-primary">View</a>
              <a target="_blank" class="btn btn-inverse btn-sm" href="{{ route('saleReturn.printReport',['ledgerId'=>$return->id]) }}">Print</a>
            </td>
            </tr>
            @endforeach
         </tbody>
         <tfoot>
            <tr>
                <th>Return No.</th>
                <th>Date</th>
                <th>Pieces</th>
                <th>From</th>
                <th>To</th>
                <th>Action</th>
                </tr>
         </tfoot>
       </table>
     </div>
     @else
     <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
     @endif 
     <script>
       $(document).ready(function() {
	$('#table_id2 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Sale returns All";
   var columns = [0, 1, 2, 3, 4, 5];
	// DataTable
	var authUserId = "{{ auth('store')->user()->id ?? __}}";
	var authUserName = "{{ auth('store')->user()->name ?? __}}";
	var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
	var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
	var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
var messageTop2 =`Report from UID : ` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
	var table = $('#table_id2').DataTable({
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