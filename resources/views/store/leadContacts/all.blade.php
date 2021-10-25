 
     <div class="card-body">
        @if($lead->leadContacts()->count() > 0)
        <div class="table-responsive">
             <table class="table"  id="table_id2" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
                 <thead>
                     <tr>
                         <th>Sr.No</th>
                         <th>Name</th>
                         <th>Email</th>
                         <th>Phone</th> 
                         <th>Whats App</th> 
                         <th>Action</th>
                     </tr>
                 </thead>
                 <tbody>
                     @php
                         // dd($managers);
                     @endphp
                   @foreach($lead->leadContacts as $contact)
                     <tr class="text-center">
                         <td>{{$loop->iteration}}</td>
                         <td>{{$contact->name}}</td> 
                         <td>{{$contact->email}}</td> 
                         <td>{{$contact->phone}}</td> 
                         <td>{{$contact->whats_app ?? 'No'}}</td> 
                        <td>    @if($lead->converted_to_store == 0)
                            <button class="btn btn-warning btn-sm" onclick="edit('{{$contact->id}}')">Edit</button>
                        @endif</td> 
                        
                     </tr> 
                     @endforeach
                 </tbody>
             </table>
         </div>
         @else
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
                        @endif
     </div>
 
<script>
    

$(document).ready(function() {
	$('#table_id2 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Lead Contacts";
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
 