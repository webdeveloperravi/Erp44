@extends('layouts.store.app')
@section('content')
<div class="row">
   <div class="col">
      <div class="row">
         <div class="col-md-6">
            <input class="form-control" type="text" id="voucherNumber" placeholder="Enter Voucher Number"  onkeypress="javascript: if(event.keyCode == 13) findOpeningStock($('#voucherNumber').val());">
         </div>
         <div class="col-md-4">
            <button class="btn btn-inverse btn-sm" onclick="findOpeningStock($('#voucherNumber').val())">Search</button> 
         </div>
      </div>
      
      
   </div>
   <div class="col">
      <a class="btn btn-dark float-right mb-3" href="{{ route('store.openingStock.create') }}">Create Opening Stock</a>
   </div>
</div>
<div  id="findView"> 
    
</div>
@if(!empty($ledgers)) 
<div class="card"> 
<div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Opening Stocks</h5>

</div>
<div class="card-body">
  
    <div class="table-responsive">
       <table class="table" id="table_id2" style="width:100">
       <thead>
                <tr>
               <td>UID</td>
               <th>Date</th>
               <th>OS-Number</th>
               <th>Total Stock</th>
               <th>Left Stock</th>
               <th>Total Amount</th>
               <th>Left Amount</th>
               <th>Print</th>
               <th>Action</th>
                    </tr>
                 </thead>
                 <tbody>
                  @foreach($ledgers as $ledger)
                  <tr class="text-center">
                     <td>{{$ledger->id }}</td>
                       <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YY') }}</td> 
                       <td>{{$ledger->voucher_number}}</td>
                       <td>{{$ledger->qty_total}}</td>
                       <td>{{$ledger->left_qty}}</td> 
                       <td>{{$ledger->total_amount}}</td> 
                       <td>{{ $ledger->left_amount ?? 0}}</td>
                       <td> <div class="dropdown-inverse dropdown open">
                        <button class="btn btn-inverse dropdown-toggle waves-effect waves-light " type="button" id="dropdown-7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Print</button>
                        <div class="dropdown-menu" aria-labelledby="dropdown-7" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <a target="_blank" class="dropdown-item waves-light waves-effect" href="{{ route('openingStock.printReport',['challanId'=>$ledger->id,'type'=> 'scan']) }}">Scan Sort</a>
                        <a target="_blank" class="dropdown-item waves-light waves-effect" href="{{ route('openingStock.printReport',['challanId'=>$ledger->id,'type'=> 'pgr']) }}">PGR Sort</a> 
                        </div>
                        </div></td>
                       <td><a class="btn btn-sm btn-inverse" href="{{ route('store.openingStock.view',$ledger->id) }}">View Stock</a></td> 
                     </tr>
                  @endforeach
                
                  </tbody>
                  <tfoot>
                    <tr>
                        <th>UID</th>
                        <th>Date</th>
                        <th>OS-Number</th>
                        <th>Total Stock</th>
                        <th>Left Stock</th>
                        <th>Total Amount</th>
                        <th>Left Amount</th>
                        <th>Print</th>
                        <th>Action</th>
                             </tr>

                  </tfoot>
                </table>
              
            @else 
      <div class="card-body">
       <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
      </div>
   </div>
 </div>
</div>
@endif 
{!! $ledgers->links() !!}
 
<div id="voucherDetail">
</div>
@endsection
@section('script')
<script>
  $(document).ready(function() {
	$('#table_id2 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Opening Stocks";
   var columns = [0, 1, 2, 3, 4, 5, 6];
	// DataTable
	var authUserId = "{{ auth('store')->user()->id ?? __}}";
	var authUserName = "{{ auth('store')->user()->name ?? __}}";
	var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
	var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
	var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
var messageTop2 =`Report from UID : ` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
	var table = $('#table_id2').DataTable({
      "paging": false,
		// dom: 'Bfrtip',
		// buttons: [
      //    {
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
      //    },
      //    title: cardTitle,
      //    messageTop: `<div class="ml-2"></div>`+messageTop
		// },
      //  ],
		"order": [],
      "lengthMenu": [50, 75, 100 ],
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
function findOpeningStock(voucherNumber){
   var url  = "{{ route('openingStock.find',['/']) }}/"+voucherNumber;
   $.get(url,function(data){
       $("#findView").html(data);
   });
}
</script> 
@endsection