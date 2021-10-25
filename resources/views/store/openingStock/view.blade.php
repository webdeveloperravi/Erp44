@extends('layouts.store.app')
@section('content')
<div class="row">
   <div class="col">
      <a href="{{route('store.openingStock.index')}}" class="btn btn-inverse btn-sm  m-2">Back</a>
   </div>
</div>
<div class="card">
   <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Opening Total Stock Details- {{ $ledger->voucher_number ?? ''}}</h5>
   </div> 
   <div class="card-body">
      @if(!empty($ledger->ledgerDetails)) 
      <div class="table-responsive">
         <table class="table" id="table_id2" style="width:100">
            <thead>
               <tr class="text-left">
                  <th>Gin</th>
                  <th>Product</th>
                  <th>Grade</th>
                  <th>Ratti</th>
                  <th>Amount</th> 
                  <th>In-Stock</th> 
               </tr>
            </thead>
            <tbody>
               @foreach($ledger->ledgerDetails as $product)
               @if ($loop->even)
               <tr class="text-left " style="background-color: rgba(0,0,0,.075)">
                  <td>{{$product->gin}}</td>
                  <td>{{$product->productStock->product->alias ?? ""}}</td>
                  <td>{{$product->productStock->productGrade->alias ?? ""}}</td>
                  <td>{{$product->productStock->ratti->rati_standard ?? ""}}+</td>
                  <td>{{$product->product_amount}}</td> 
                  <td class="text-center">
                     @if($product->new_ledger_id == null)
                     <i class="fa fa-check text-success"></i>
                     @else
                     <i class="fa fa-times text-danger"></i>
                   
                  @endif
                  </td>
               </tr>
               @else
                  <tr class="text-left">
                     <td>{{$product->gin}}</td>
                     <td>{{$product->productStock->product->alias ?? ""}}</td>
                     <td>{{$product->productStock->productGrade->alias ?? ""}}</td>
                     <td>{{$product->productStock->ratti->rati_standard ?? ""}}+</td>
                     <td>{{$product->product_amount}}</td> 
                   <td class="text-center">
                     @if($product->new_ledger_id == null)
                     <i class="fa fa-check text-success"></i>
                     @else
                     <i class="fa fa-times text-danger"></i>
                   
                  @endif
                   </td>
                  </tr>

               @endif
               @endforeach
            </tbody>
            <tfoot>
               <tr>
                  <th>Gin</th>
                  <th>Product</th>
                  <th>Grade</th>
                  <th>Ratti</th>
                  <th>Amount</th> 
                  <th>In-Stock</th> 
               </tr>
            </tfoot>
         </table>
         @else 
         <div class="card-body">
            <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
         </div>
      </div>
      @endif 
   </div>
</div>




<div class="">  
   <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Images</h5>
   </div>
   <div class="row">
      @if($ledger->mediaImages->count() == 0)
       <div class="col-lg-12 col-sm-12">
       <div class="jumbotron text-center">
         <h2 class="text-center "><i class="fa fa-inbox "></i>&nbsp; Empty</h2>
          <a class="btn btn-dark mt-3" href="{{ route('ledgerMedia.index',$ledger->id) }}">Click to Upload Images</a>
       </div>
      </div>
      @else
       @foreach ($ledger->mediaImages as $image)
       <div class="col-lg-3 col-md-3 col-sm-6">
           <div class="thumbnail">
            <div class="thumb"> 
               <a href="{{ asset('public/'.$image->url.$image->name) }}" data-lightbox="1" data-title="">
                   <img src="{{ asset('public/'.$image->url.$image->name) }}" alt="" class="img-fluid img-thumbnail">
                   </a>
           </div>
           </div>
           
           </div>
       @endforeach 
       <div class="col-md-12">
         <div class="jumbotron p-3 mb-0 text-center"> 
            <a class="btn btn-dark mt-3 mt-0" style="margin-top: 0" href="{{ route('ledgerMedia.index',$ledger->id) }}">Click to Upload More Images</a>
         </div>
       </div>
       @endif
</div> 
</div> 

@endsection
@section('script')
<script type="text/javascript"> 

   $(document).ready(function() {
	$('#table_id2 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Opening Total Stock Details-{{$ledger->voucher_number ?? ''}}";
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
		buttons: [
      // {
			// extend: 'excelHtml5',
			// exportOptions: {
			// 	columns: columns,
			// },
		// 	text: 'Export Excel',
		// 	title: cardTitle,
		// },
      //  {
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
      // },
      {
      text: 'Print',
      action: function ( e, dt, button, config ) {
         window.open("{{ route('openingStock.detailsPrint',['/']) }}/"+"{{ $ledger->id }}", '_blank');
      //   window.location = "{{ route('openingStock.detailsPrint',['/']) }}/"+"{{ $ledger->id }}";
      }        
    },   ],
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
@endsection