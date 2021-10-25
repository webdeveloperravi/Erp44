@if (count($stockLedgers))
<div class="table-responsive">
    <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
        <thead>
            <tr class="text-center">
                <th>Store UID</th>
                <th>Voucher Type</th>
                <th>Date</th>
                <th>Voucher Type</th>
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
            @foreach($stockLedgers as $ledger)
            <tr class="text-center"> 
                <td>{{app\Helpers\StoreHelper::getStoreId()}}</td>
                <td>{{$ledger->voucher->name}}</td>
                <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YYYY') }}   </td> 
                <td>{{ $ledger->voucher_type ?? "" }}</td>
                <td>{{$ledger->voucher_number ?? ""}}</td>
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
                      
                <td>{{$ledger->comment}}</td>  
                <td>{{$ledger->getDebitAmount($accountId2,$ledger->id)}}</td> 
                <td>{{$ledger->getCreditAmount($accountId2,$ledger->id)}}</td> 
                <td>{{$ledger->getBalanace($accountId2,$ledger->id)}}</td> 
                <td><button onclick="stockTransactionDetail({{ $ledger->id }})">View</button></td> 
                 
            </tr> 
            @endforeach
            <tr class="text-center"> 
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total</td>
                <td>{{ $ledger->getTotalDebit($accountId2) }}</td>
                <td>{{ $ledger->getTotalCredit($accountId2) }}</td>
                <td>{{ $ledger->getTotalBalance($accountId2) }}</td>
            </tr>
        </tbody>
    </table>
</div>
@else
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Transactions</h2>
@endif 
    
          