 <div class="row"> 
            <div class="col-md-6">
                <h2>Total Products : {{ count($products) }}</h2> 
            </div>
        </div>
       <div class="table-responsive">
          <table class="table" id="table_id2" style="width:100">
             <thead>
                <tr> 
                   <th>Gin</th>
                   <th>Product</th>
                   <th>Grade</th>
                   <th>Ratti Standard</th> 
                   <th>In Warehouse Stock</th> 
                </tr>
             </thead>
             <tbody>
                 @foreach ($products as $product)
                 <tr class="text-center"> 
                     <td>{{$product->gin ?? ""}}</td>
                     <td>{{$product->product->name ?? ""}}</td>
                     <td>{{$product->productGrade->alias ?? ""}}</td>
                     <td>{{$product->ratti->rati_standard ?? ""}}</td> 
					 <td>
					 @if ($product->in_stock)
					 <i class="fa fa-check text-success"></i> 
					 @else
					 <i class="fa fa-times text-danger"></i> 
					 @endif
					 </td>
                  </tr>
                @endforeach
             </tbody>
             <tfoot>
                <tr> 
                    <th>Gin</th>
                    <th>Product</th>
                    <th>Grade</th>
                    <th>Ratti Standard</th> 
					<th>In Warehouse Stock</th> 
                </tr>
             </tfoot>
          </table>
       </div> 
 <script>  
    $(document).ready(function() {
	$('#table_id2 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Total Products : {{ count($products) }}";
   var columns = [0, 1, 2, 3];
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

