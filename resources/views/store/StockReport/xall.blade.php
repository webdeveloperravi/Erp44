@if (count($stockLedgers))
<div class="table-responsive">
    <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
        <thead>
            <tr class="text-center">
                {{-- <th>From Voucher</th> --}}
                <th>Voucher</th>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Naration</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 
            @foreach($stockLedgers as $ledger)
            <tr class="text-center">
                {{-- <td>{{$ledger->voucher_number ?? ""}}</td> --}}
                <td>{{$ledger->voucher_number ?? ""}}</td>
                <td>{{$ledger->userIssue->name ?? ""}}</td>
                <td>{{$ledger->userReceipt->name ?? ""}}</td>
                <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YYYY') }}    </td> 
                <td>{{$ledger->comment}}</td> 
                {{-- <td>{{$ledger->debit_by}}</td>  --}}
                <td>{{$ledger->getDebitAmount($accountId,$ledger->id)}}</td> 
                <td>{{$ledger->getCreditAmount($accountId,$ledger->id)}}</td> 
                <td>{{$ledger->getValues($accountId,$ledger->id)}}</td> 
                <td><button onclick="stockTransactionDetail({{ $ledger->id }})">View</button></td> 
                 
            </tr> 
            @endforeach
            <tr class="text-center"> 
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total</td>
                <td>{{ $ledger->getTotalDebit($accountId) }}</td>
                <td>{{ $ledger->getTotalCredit($accountId) }}</td>
                <td>{{ $ledger->getTotalBalance($accountId) }}</td>
            </tr>
        </tbody>
    </table>
</div>
@else
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Transactions</h2>
@endif 
    
          