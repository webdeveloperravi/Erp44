 
 <div class="card">
   <div class="card-footer p-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Store Accounts List</h5> 
   </div>

    <div class="card-body">
       <div class="table-responsive">
          <table class="table" id="table_id2" style="width:100">
             <thead>
                <tr> 
                    <th>UID</th>
                   <th>Name</th>
                   <th>Store Name</th>
                   <th>Email</th>
                   <th>Phone</th>
                   <th>Action</th> 
                </tr>
             </thead>
             <tbody>
                 @foreach ($accounts as $account)
                 <tr class="text-center"> 
                     <td>{{ $account->id ?? "" }}</td>
                     <td>{{$account->name ?? ""}}</td>
                     <td>{{$account->company_name ?? ""}}</td>
                     <td>{{$account->email ?? ""}}</td>
                     <td>{{$account->phone ?? ""}}</td> 
                     <td><button  onclick="viewAccount({{$account->id}})">view</button></td> 
                  </tr>
                @endforeach
             </tbody>
             <tfoot>
                <tr> 
                   <th>UID</th>
                   <th>Name</th>
                   <th>Store Name</th>
                   <th>Email</th>
                   <th>Phone</th>
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
   var cardTitle = "Store Accounts List";
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

function getAccounts(){

var url = "{{route('store.getStoreAccounts')}}";
$.get(url,function(data){

  $("#all").html(data);
})

}
  </script>

