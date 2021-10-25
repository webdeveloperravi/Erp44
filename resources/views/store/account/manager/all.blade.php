 <div class="card">
   <div class="card-footer p-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Manager Accounts List</h5> 
   </div>

    <div class="card-body">
       <div class="table-responsive">
          <table class="table" id="table_id2" style="width:100">
             <thead>
                <tr> 
                   <th>UID</th>
                   <th>Name</th>
                   <th>Store Name</th>
                   <th>Manager Role</th>
                   <th>Email</th>
                   <th>Phone</th>
                   <th>Created By</th>
                   <th>Status</th>
                   <th>Action</th> 
                </tr>
             </thead>
             <tbody>
                 @foreach ($accounts as $account)
                 <tr class="text-center"> 
                    <td>{{ $account->id }}</td>
                     <td>{{$account->name ?? ""}}</td>
                     <td>{{$account->store->company_name ?? ""}}</td>
                     <td>{{$account->managerRole->name ?? ""}}</td>
                     <td>{{$account->email ?? ""}}</td>
                     <td>{{$account->phone ?? ""}}</td> 
                     <td>{{ $account->createdBy->name ?? "" }}</td>
                     <td>
                        @if ($account->status == 1)
                        <button class="btn btn-success btn-sm" onclick="changeManagerAccountStatus({{ $account->id }})">Active</button>
                        @else
                        <button class="btn btn-danger btn-sm" onclick="changeManagerAccountStatus({{ $account->id }})">Inactive</button>
                        @endif
                     </td>
                    <td><a href="{{ route('manager.view.index',$account->id) }}" class="btn btn-warning p-1 mr-1">View</a></td> 
                  </tr>
                @endforeach 
             </tbody>
             <tfoot>
                <tr> 
                  <th>UID</th>
                   <th>Name</th>
                   <th>Store Name</th>
                  <th>Manager Role</th>
                   <th>Email</th>
                   <th>Phone</th>
                   <th>Created By</th>
                   <th>Status</th>
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
   var cardTitle = "Manager Accounts List";
   var columns = [0, 1, 2, 3, 4, 5, 6];
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

