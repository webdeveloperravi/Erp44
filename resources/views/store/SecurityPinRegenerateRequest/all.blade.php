<div class="card">
  <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Security Pin Regenerate Requests</h5>
	</div> 
	<div class="card-body">
    <div class="table-responsive">
      <table class="table" id="table_id2" style="width:100">
	<thead>
		<tr>
        <th>UID</th>
        <th>Name</th>  
        <th>Created On</th> 
        <th>Resolved On</th> 
        <th>Resolved By</th> 
        <th>Action</th> 
      </tr>
    </thead>
    <tbody> 
      @foreach($requests as $request)  
	  @php
		//   dd($request->security_pin_regenerate_requests->company_name);
	  @endphp
      <tr class="text-center"> 
	  <td>{{ $request->id ?? "" }}</td>
        <td>{{ $request->security_pin_regenerate_requests->name ?? "" }}</td> 
		<td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->created_at)->isoFormat('DD-MM-YYYY') }}</td>
		
		@if ($request->resolved_by == null)
		<td>No</td>
		<td>No</td>
		
		<td><Button class=" btn btn-inverse" onclick="regenerateNow({{ $request->id }})">Regenerate</Button></td>
		@else
		<td>
			{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $request->updated_at)->isoFormat('DD-MM-YYYY') }}	
		</td>
		<td>{{ $request->resolvedBy->name ?? "" }}</td>
		<td><Button class=" btn btn-success" onclick="(swal('Already generated'))">Regenerated</Button></td>
		@endif
		
      </tr>
      @endforeach 
    </tbody>
    <tfoot>
      <tr>
        <th>UID</th>
        <th>Name</th>  
        <th>Created On</th> 
        <th>Resolved On</th> 
        <th>Resolved By</th> 
        <th>Action</th> 
      </tr>
    </tfoot>
  </table>
  </div>
</div>
</div>
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
