@if (count($receiveChallans))
        <div class="table-responsive">
           <table class="table" id="table_id2" style="width:100">
           <thead>
             <tr>
             <th>UID</th>
             <th>Challan No.</th>
             <th>Date</th>
             <th>Pieces</th>
             <th>From</th>
             <th>To</th>
             <th>Print</th>
             <th>Action</th>
             </tr>
           </thead>
           <tbody>
            @foreach ($receiveChallans as $challan)
            <tr class="text-center">
            <td>{{$challan->id ?? ''}}</td>  
            <td>{{$challan->voucher_number ?? ''}}</td>  
            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $challan->created_at)->isoFormat('DD-MM-YY') }}</td> 
            <td>{{ $challan->qty_total }}</td>  
            <td> @if ($challan->userIssue->type == 'user')
                    {{$challan->userIssue->name ?? ""}} <br>
                    ({{$challan->userIssue->parentStore->company_name ?? ""}})
                    @else
                    {{$challan->userIssue->name ?? ""}} <br>
                    ({{$challan->userIssue->company_name ?? ""}})
                    @endif</td>  
            <td>  @if ($challan->userReceipt->type == 'user')
                    {{$challan->userReceipt->name ?? ""}} <br>
                    ({{$challan->userReceipt->parentStore->company_name ?? ""}})
                    @else
                    {{$challan->userReceipt->name ?? ""}}  <br>
                    ({{$challan->userReceipt->company_name ?? ""}})
                    @endif</td>  
                    {{-- <td> <a target="_blank" class="btn" href="{{ route('saleChallan.printReport',$challan->id) }}"><i class="fa fa-print text-inverse"></i></a> </td> --}}
                    <td> <div class="dropdown-inverse dropdown open">
                      <button class="btn btn-inverse dropdown-toggle waves-effect waves-light " type="button" id="dropdown-7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Print</button>
                      <div class="dropdown-menu" aria-labelledby="dropdown-7" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                      <a target="_blank" class="dropdown-item waves-light waves-effect" href="{{ route('saleChallan.printReport',['challanId'=>$challan->id,'type'=> 'scan']) }}">Scan Sort</a>
                      <a target="_blank" class="dropdown-item waves-light waves-effect" href="{{ route('saleChallan.printReport',['challanId'=>$challan->id,'type'=> 'pgr']) }}">PGR Sort</a> 
                      </div>
                      </div></td>
            <td>
              @if ($challan->to == auth('store')->user()->id)
              <a href="{{ route('receiveChallanUpdate.index',$challan->id) }}" class="btn btn-sm btn-warning">Edit</a>
              @else
              <button href="#" class="btn btn-sm btn-danger" disabled>Edit</button>
              @endif
              <a href="{{ route('receiveChallan.view',$challan->id) }}" class="btn btn-sm btn-primary">View</a> 
            </td>
            </tr>
            @endforeach
         </tbody>
         <tfoot>
             <tr>
             <th>UID</th>
             <th>Challan No.</th>
             <th>Date</th>
             <th>Pieces</th>
             <th>From</th>
             <th>To</th>
             <th>Print</th>
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
   var cardTitle = "Sale Challans All";
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