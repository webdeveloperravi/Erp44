  <div class="card">
      <div class="card-footer p-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Other Accounts List</h5> 
   </div>
   <div class="card-body"> 
      <div class="table-responsive">
         <table class="table" id="table_id2" style="width:100">
            <thead>
               <tr class="text-left" style="text-align:left"> 
                  <th>UID</th> 
                  <th>Other Name</th> 
                  <th>State</th>
                  <th>Country</th>
                  <th>District</th>
                  <th>Town</th> 
                  <th>Address</th> 
                  <th>Locality</th> 
                  <th>Mobile</th> 
                  <th>Whats App</th> 
                  <th>Status</th> 
                  <th>Action</th> 
               </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                <tr class="text-left"> 
                    <td>{{ $account->id ?? "" }}</td> 
                    <td>
                    {{$account->company_name ?? ""}} <br>
                    ({{$account->name ?? ""}} - {{$account->role->retailModel->discount->rate ?? ""}})
                    </td>  
                    <td>{{$account->headOfficeAddress->state->name ?? ""}}</td>
                    <td>{{$account->headOfficeAddress->country->name ?? ""}}</td>
                    <td>{{$account->headOfficeAddress->city->name ?? ""}}</td>
                    <td>{{$account->headOfficeAddress->town->name ?? ""}}</td> 
                    <td>{{$account->headOfficeAddress->address ?? ""}}</td> 
                    <td>{{$account->headOfficeAddress->locality ?? ""}}</td> 
                    <td>{{'+'.$account->getPhoneWithCode($account->id) ?? ""}}</td> 
                    <td>{{'+'.$account->getWhatsAppWithCode($account->id) ?? ""}}</td> 
                    <td>
                     @if ($account->status == 1)
                     <button class="btn btn-success btn-sm" onclick="changeOtherAccountStatus({{ $account->id }})">Active</button>
                     @else
                     <button class="btn btn-danger btn-sm" onclick="changeOtherAccountStatus({{ $account->id }})">Inactive</button>
                     @endif
                   </td>
                    <td><a href="{{route('otherAccount.view',$account->id)}}" class="btn btn-warning btn-sm">View</a></td> 
                 </tr>
               @endforeach
            </tbody>
            <tfoot>
               <tr> 
                  <th>UID</th> 
                  <th>Other Name</th> 
                  <th>State</th>
                  <th>Country</th>
                  <th>District</th>
                  <th>Town</th> 
                  <th>Address</th> 
                  <th>Locality</th> 
                  <th>Mobile</th> 
                  <th>Whats App</th> 
                  <th>Status</th> 
                  <th>Action</th> 
               </tr>
            </tfoot>
         </table>
    </div>
 </div>
     
 </div> 
 <div id="all"></div>
 <script>

 

     $(document).ready(function() {
	$('#table_id2 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Other Accounts List";
   var columns = [0, 1, 2, 3, 4, 5];
	// DataTable
	var authUserId = "{{ auth('store')->user()->id ?? __}}";
	var authUserName = "{{ auth('store')->user()->name ?? __}}";
	var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
	var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
	var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
var messageTop2 =`Report from UID : ` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
	var table = $('#table_id2').DataTable({ 
		dom: 'Bfrtip',
		buttons: [
         {
			extend: 'excelHtml5',
			exportOptions: {
				columns: columns,
			},
			text: 'Export Excel',
			title: cardTitle,
		}, 
      {
			extend: 'pdfHtml5',
			download: 'open',
			exportOptions: {
				columns: columns,
			},
			text: 'Export Pdf',
			title: cardTitle,
			// orientation: 'landscape',
			pageSize: 'a4',
			messageTop: messageTop
		}, 
      {
			extend: 'print',
			exportOptions: {
				columns: columns,
         },
         
         title: cardTitle,
         messageTop: `<div class="ml-2"></div>`+messageTop
		},
       ],
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

