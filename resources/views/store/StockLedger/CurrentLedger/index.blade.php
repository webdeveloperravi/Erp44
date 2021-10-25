@extends('layouts.store.app')
@section('content') 
<div class="card" id="form">
   <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Current Stock Ledger</h5>
   </div>  
   <div class="card-body"> 
      @if (count($stockLedgers))
      <div class="table-responsive">
         <table class="table" id="table_id1" style="width:100%">
              <thead>
                  <tr class="text-center"> 
                     <th>Voucher No.</th>
                      <th>Date</th>
                      <th>From</th>
                      <th>To</th> 
                      <th>Debit</th>
                      <th>Credit</th>
                      <th>Balance</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody> 
                  @foreach($stockLedgers as $ledger)
                  <tr class="text-center">  
                      {{-- <td>{{$ledger->voucher->name}}</td> --}}
                     <td>{{$ledger->voucher_number ?? ""}}</td>
                      <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YYYY') }}   </td> 
                      <td>{{$ledger->userIssue->name ?? ""}}</td>
                      <td>{{$ledger->userReceipt->name ?? ""}}</td>  
                      <td>
                            {{-- {{$ledger->from == $authUser->id ? $ledger->qty_total : '' }} <br> --}}
                             {{$ledger->getDebitPiece($authUser->id,$ledger->id)}} <br>
                             {{$ledger->getDebitAmount($authUser->id,$ledger->id)}}
                           </td> 
                           <td>
                              {{-- {{$ledger->to == $authUser->id ? $ledger->qty_total : '' }} <br> --}}
                        {{$ledger->getCreditPiece($authUser->id,$ledger->id)}} <br>
                  {{ $ledger->getCreditAmount($authUser->id,$ledger->id) }}
                  </td> 
                  <td>
                        {{$ledger->getBalanacePiece($authUser->id,$ledger->id)}} <br>
                        {{$ledger->getBalanaceAmount($authUser->id,$ledger->id)}}
                  </td> 
                      <td><button onclick="stockTransactionDetail({{ $ledger->id }})">View</button></td> 
                       
                  </tr> 
                  @endforeach 
                  <tr class="text-center">   
                     <td></td>
                     <td></td>
                     <td></td>
                     <td>Total</td> 
                     <td>
                        {{ $ledger->getTotalCreditPiece($authUser->id) }} <br>
                        {{ $ledger->getTotalCreditAmount($authUser->id) }}
                    </td>
                    <td>
                        {{ $ledger->getTotalDebitPiece($authUser->id) }} <br>
                        {{ $ledger->getTotalDebitAmount($authUser->id) }}
                    </td>
                    <td>
                        {{ $ledger->getTotalBalancePiece($authUser->id) }} <br>
                        {{ $ledger->getTotalBalanceAmount($authUser->id) }}
                    </td>
                     <td></td>
                 </tr>
              </tbody>
              <tfoot>
               <tr class="text-center"> 
                  <th>Voucher No.</th>
                  <th>Date</th>
                  <th>From</th>
                  <th>To</th> 
                  <th>Debit</th>
                  <th>Credit</th>
                  <th>Balance</th>
                  <th>Action</th>
              </tr>
              </tfoot>
          </table>
      </div>
      @else
      <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Transactions</h2>
      @endif 
   </div>
</div>
<div class="row">
   <div class="col col-md-12">
      <div id="stockTransactionDetail"></div>
   </div>
</div>
@endsection
@section('script')
<script>   
   function stockTransactionDetail(id){
      var url = "{{ route('currentStockLedger.details',['/']) }}/"+id;
      $.get(url,function(data){
         $("#stockTransactionDetail") .html(data);  
         $('html, body').animate({
        scrollTop: $("#stockTransactionDetail").offset().top
    }, 2000);   
      });
   } 

   $(document).ready(function() {
	$('#table_id1 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Current Stock Ledger";
   var columns = [0, 1, 2, 3, 4, 5, 6,7,8,9];
	// DataTable
	var authUserId = "{{ auth('store')->user()->id ?? __}}";
	var authUserName = "{{ auth('store')->user()->name ?? __}}";
	var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
	var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
	var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
	var table = $('#table_id1').DataTable({
                stateSave: true,
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
            // var footer = $("#filterFooter");
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