 {{-- <div class="card">
<div class="card-footer p-0" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Social Medias </h5>
</div>
<div class="card-body"> --}}
@if(count($socials))
<div class="table-responsive">
<table class="table" id="table_id23" style="width:100">
        <thead>
            <tr>
                <th id="click">UID</th>
                <th>Media Type</th>
                <th>Link</th> 
                <th>Action</th>   
            </tr>
        </thead>
        <tbody> 
        @foreach($socials as $type)
            <tr class="text-left">
                <td>{{ $type->id }}</td>
                <td>{{$type->mediaType->name}}</td> 
                <td><a target="_blank" href="{{url($type->link)}}">{{ $type->link }}</a></td>  
                <td><button onclick="editSocial({{ $type->id }})">Edit</button></td>
            </tr> 
            @endforeach
        </tbody>
          <tfoot>
                <tr> 
                    <th id="click">UID</th>
                    <th>Media Type</th>
                    <th>Link</th> 
                    <th>Action</th>    
                </tr>
             </tfoot>
    </table>
</div>
@else
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
@endif
{{-- </div>
 </div> --}}
<script> 

    $(document).ready(function() {
	$('#table_id23 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "All Social Medias";
   var columns = [0, 1, 2];
	// DataTable
	var authUserId = "{{ auth('store')->user()->id ?? __}}";
	var authUserName = "{{ auth('store')->user()->name ?? __}}";
	var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
	var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
	var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
var messageTop2 =`Report from UID : ` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
	var table = $('#table_id23').DataTable({
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
 