 <div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
       <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{ ucfirst($msg) ?? "ALL Stores" }} </h5>
    </div>
    <div class="card-body">
       {{-- @if (count($stores))   --}}
         <div class="table-responsive">
            <table class="table" id="table_id3" style="width:100">
            <thead>
                <tr>
                   <th>S.No</th>
                   <th>Store Name</th>
                   <th>District</th>
                   <th>Town</th>
                   <th>Role</th>
                   <th>Retail Model</th>
                   <th>Retail Type</th>
                   <th>Actions</th>
                </tr>
             </thead>
             <tbody>
                @foreach($stores as $store)
                <tr class="text-left">
                   <td><label>{{$store->id}}</label></td>
                   <td>
                    {{$store->company_name ?? ""}} <br>
                    ({{$store->name ?? ""}} - {{$store->role->retailModel->discount->rate ?? ""}})
                    </td>  
                   <td>{{$store->headOfficeAddress->city->name ?? ""}}</td>
                    <td>{{$store->headOfficeAddress->town->name ?? ""}}</td> 
                   <td><label>{{$store->role->name ?? ""}}</label></td>
                   <td><label>{{$store->role->retailModel->name}}</label></td> 
                   <td><label>{{$store->role->retailModel->retailType->name}}</label></td> 
                   @if ($store->role->retailModel->retailType->id == 1)
                   <td> <button class="btn btn-primary btn-sm" onclick="editStoreRole({{$store->id}})">Edit Store Role</button> 
                  <button class="btn btn-primary btn-sm" onclick="attachZonesIndex({{$store->id}})">View Zones</button></td>
                   @else
                   <td> <button class="btn btn-primary btn-sm" onclick="editStoreRole({{$store->id}})">Edit Store Role</button> 
                   <button class="btn btn-primary btn-sm" onclick="alertConverToDistributor()">View Zones</button></td>
                   @endif
                </tr>
                @endforeach 
             </tbody>
             <tfoot>
                <tr>
                   <th>S.No</th>
                   <th>Store Name</th>
                   <th>District</th>
                   <th>Town</th>
                   <th>Role</th>
                   <th>Retail Model</th>
                   <th>Retail Type</th>
                   <th>Actions</th>
                </tr>
             </tfoot>
          </table>
       </div>
       {{-- @else --}}
       {{-- <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2> --}}
       {{-- @endif --}}
    </div>
 </div>
 <div class="" id="attachZoneIndex"></div>

 
  <script> 
  $(document).ready(function() {
	$('#table_id3 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Manager Accounts List";
   var columns = [0, 1, 2, 3, 4];
	// DataTable
	var authUserId = "{{ auth('store')->user()->id ?? __}}";
	var authUserName = "{{ auth('store')->user()->name ?? __}}";
	var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
	var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
	var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
var messageTop2 =`Report from UID : ` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
	var table = $('#table_id3').DataTable({
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
    
 