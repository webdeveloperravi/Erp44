<div class="card">
  <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Cheques</h5>
	</div> 
	<div class="card-body">
    <div class="table-responsive">
      <table class="table" id="table_id2" style="width:100">
	<thead>
		<tr>
        <th>UID</th> 
        <th>Number</th> 
        <th>Amount</th> 
        <th>Issued To</th> 
		<th>Cleared</th>
        <th>Action</th> 
      </tr>
    </thead>
    <tbody>
      @foreach($cheques as $cheque)
      <tr> 
        <td>{{$cheque->id}}</td> 
        <td>{{$cheque->number}}</td> 
        <td>{{$cheque->amount}}</td> 
		<td>
			@if ($cheque->in_stock)
			No
			@else
			@php
			 $rUser =	App\Helpers\StoreHelper::getChequeOwner($cheque->id) ?? false;
			  
			@endphp
			@if (in_array($rUser->type ?? "",$storeUserTypesAll))
			{{$rUser->name ?? ""}} <br>
			({{$rUser->parentStore->company_name ?? ""}})
			@else
			{{$rUser->name ?? ""}}  <br>
			({{$rUser->company_name ?? ""}})
		@endif 
			@endif
		</td>
		<td>
			@if ($cheque->cleared)
			@if (in_array($cheque->ledger->userReceipt->type,$storeUserTypesAll))
			{{$cheque->ledger->userReceipt->name ?? ""}} <br>
			({{$cheque->ledger->userReceipt->parentStore->company_name ?? ""}})
			@else
			{{$cheque->ledger->userReceipt->name ?? ""}}  <br>
			({{$cheque->ledger->userReceipt->company_name ?? ""}})
		@endif 
			@else
			No	
			@endif
		</td>  
		<td>
			@if ($cheque->in_stock)
			<button class="btn btn-warning btn-sm " onclick="edit('{{$cheque->id}}')">Edit</button> 
			@else
			@endif
			@if (!$cheque->in_stock && $cheque->cleared)
			
			<button class="btn btn-inverse btn-sm " ><i class="fa fa-check text-success"></i> Cleared </button>	
			@endif
		</td> 
		
      </tr>
      @endforeach 
    </tbody>
    <tfoot>
      <tr>
		<th>UID</th> 
        <th>Number</th> 
        <th>Amount</th> 
        <th>Issued To</th> 
		<th>Cleared</th>
        <th>Action</th> 
      </tr>
    </tfoot>
  </table>
  </div>
</div>
</div>
@if (!count($cheques))
	<h1>Empty</h1>
@endif
<script>
  $(document).ready(function() {
	$('#table_id2 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Bank Accounts";
   var columns = [0, 1, 2];
	// DataTable
	var authUserId = "{{ auth('store')->user()->id ?? __}}";
	var authUserName = "{{ auth('store')->user()->name ?? __}}";
	var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
	var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
	var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
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
