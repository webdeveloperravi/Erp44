@if (count($stockLedgers))
<div class="table-responsive">
    <table class="table" id="table_id1" style="width:100">
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
                <td>{{$ledger->voucher_number ?? ""}}</td>
                <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YYYY') }}   </td>  
                <td>
                @if ($ledger->userIssue->type == 'user')
                {{$ledger->userIssue->name ?? ""}} <br>
                ({{$ledger->userIssue->parentStore->company_name ?? ""}})
                @else
                {{$ledger->userIssue->name ?? ""}} <br>
                ({{$ledger->userIssue->company_name ?? ""}})
                @endif
                </td> 
                <td>
                @if ($ledger->userReceipt->type == 'user')
                {{$ledger->userReceipt->name ?? ""}} <br>
                ({{$ledger->userReceipt->parentStore->company_name ?? ""}})
                @else
                {{$ledger->userReceipt->name ?? ""}}  <br>
                ({{$ledger->userReceipt->company_name ?? ""}})
                @endif
                </td>  
                <td>
                    {{$ledger->getCreditPiece($accountId2,$ledger->id)}} <br>
                {{ $ledger->getCreditAmount($accountId2,$ledger->id) }}
                </td> 
                <td>
                    {{$ledger->getDebitPiece($accountId2,$ledger->id)}} <br>
                    {{$ledger->getDebitAmount($accountId2,$ledger->id)}}
                </td> 
                <td>
                    {{$ledger->getBalanacePiece($accountId2,$ledger->id)}} <br>
                    {{$ledger->getBalanaceAmount($accountId2,$ledger->id)}}
                </td> 
                {{-- <td>{{$ledger->getCreditAmount($accountId2,$ledger->id)}}</td> 
                <td>{{$ledger->getDebitAmount($accountId2,$ledger->id)}}</td> 
                <td>{{$ledger->getBalanace($accountId2,$ledger->id)}}</td>  --}}
                <td><button onclick="stockTransactionDetail({{ $ledger->id }})">View</button></td> 
            </tr> 
            @endforeach
            <tr class="text-center">   
                <td></td>
                <td></td>
                <td></td>
                <td>Total</td> 
                <td>
                    {{ $ledger->getTotalCreditPiece($accountId2) }} <br>
                    {{ $ledger->getTotalCreditAmount($accountId2) }}
                </td>
                <td>
                    {{ $ledger->getTotalDebitPiece($accountId2) }} <br>
                    {{ $ledger->getTotalDebitAmount($accountId2) }}
                </td>
                <td>
                    {{ $ledger->getTotalBalancePiece($accountId2) }} <br>
                    {{ $ledger->getTotalBalanceAmount($accountId2) }}
                </td>
                {{-- <td>{{ $ledger->getTotalCredit($accountId2) }}</td>
                <td>{{ $ledger->getTotalDebit($accountId2) }}</td>
                <td>{{ $ledger->getTotalBalance($accountId2) }}</td> --}}
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

<script>
     $(document).ready(function() {
	$('#table_id1 tfoot th').each(function() {
		var title = $(this).text();
		$(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });
   var cardTitle = "Store Stock Ledger";
   var columns = [0, 1, 2, 3, 4, 5, 6,7,8,9,10];
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
    
          