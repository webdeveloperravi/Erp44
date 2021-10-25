@if (count($paymentLedgers))
<div class="table-responsive">
    <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
        <thead>
            <tr class="text-center">
                {{-- <th>From Voucher</th> --}}
                <th>Date</th>
                <th>Voucher No.</th>
                <th>From</th>
                <th>To</th>
                <th>Naration</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody> 
            @foreach($paymentLedgers as $ledger)
            <tr class="text-center"> 
                <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YYYY') }}   </td> 
                <td>{{$ledger->voucher_number ?? ""}}</td>
                <td>{{$ledger->userIssue->name ?? ""}}</td>
                <td>{{$ledger->userReceipt->name ?? ""}}</td>
                <td>{{$ledger->comment}}</td>  
                <td>{{$ledger->getDebitAmount($managerId,$ledger->id)}}</td> 
                <td>{{$ledger->getCreditAmount($managerId,$ledger->id)}}</td> 
                <td>{{$ledger->getBalanace($managerId,$ledger->id)}}</td> 
                <td><button onclick="stockTransactionDetail({{ $ledger->id }})">View</button></td> 
                 
            </tr> 
            @endforeach
            <tr class="text-center"> 
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total</td>
                <td>{{ $ledger->getTotalDebit($managerId) }}</td>
                <td>{{ $ledger->getTotalCredit($managerId) }}</td>
                <td>{{ $ledger->getTotalBalance($managerId) }}</td>
            </tr>
        </tbody>
    </table>
</div>
@else
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Transactions</h2>
@endif 
    
          