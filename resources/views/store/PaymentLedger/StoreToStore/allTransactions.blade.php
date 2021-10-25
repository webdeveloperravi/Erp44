@if (count($paymentLedgers) > 0)
 
    <div class="card-body"> 
    <div class="table-responsive">
        <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
            <thead>
                <tr class="text-center">
                    
                    <th>Sr.</th> 
                    <th>Date</th> 
                    <th>Voucher/No.</th> 
                    <th>From</th>
                    <th>To</th> 
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Balance</th>
                    {{-- <th>Action</th> --}}
                    <th>Naration</th>
                </tr>
            </thead>
            <tbody> 
                @foreach($paymentLedgers as $ledger)
                <tr class="text-center"> 
                    
                    <td>{{$loop->iteration}}</td>
                    <td>{{ App\Helpers\StoreHelper::getFormattedDate($ledger->created_at) }}</td> 
<td>{{$ledger->voucher->name}}-{{$ledger->voucher_number ?? ""}}</td>
                    
                    <td>
                    @if (in_array($ledger->userIssue->type,$storeUserTypesAll))
                    {{$ledger->userIssue->name ?? ""}} <br>
                    ({{$ledger->userIssue->parentStore->company_name ?? ""}})
                    @else
                    {{$ledger->userIssue->name ?? ""}} <br>
                    ({{$ledger->userIssue->company_name ?? ""}})
                    @endif
                    </td> 
                    <td>
                    @if (in_array($ledger->userReceipt->type,$storeUserTypesAll))
                    {{$ledger->userReceipt->name ?? ""}} <br>
                    ({{$ledger->userReceipt->parentStore->company_name ?? ""}})
                    @else
                    {{$ledger->userReceipt->name ?? ""}}  <br>
                    ({{$ledger->userReceipt->company_name ?? ""}})
                    @endif
                    </td>  
                    @php
                    $debit = App\Services\PaymentLedger\StoreToStorePaymentLedger::debit($account->id,$ledger->from,$ledger->total_amount);
                    $credit = App\Services\PaymentLedger\StoreToStorePaymentLedger::credit($account->id,$ledger->to,$ledger->total_amount);
                    $bal = App\Services\PaymentLedger\StoreToStorePaymentLedger::getFinalLedgerBalance($account->id,$ledger->id); 
                    @endphp
                    <td>{{ $credit ? number_format((float)$credit, 2, '.', '') : ""}}</td>  
                    <td>{{ $debit ? number_format((float)$debit, 2, '.', '') : ""}}</td>  
                    <td>{{number_format((float)$bal['amount'], 2, '.', '')}} {{ $bal['type'] }}</td> 
                     <td>{{$ledger->comment}}</td>  
                     
                </tr> 
                @endforeach
                <tr class="text-center"> 
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td> 
                    <td>Total</td>
                    @php
                        $total = App\Services\Trial\GetStoreLedger::getFinalLedgerTotal($account->id);
                        $debit = $total['debit'];
                        $credit = $total['credit'];
                        $bal = $total['amount'];
                        $type = $total['type'];
                    @endphp 
                <td>{{number_format((float)$debit, 2, '.', '')}}</td> 
                <td>{{number_format((float)$credit, 2, '.', '')}}</td>  
                <td>{{number_format((float)$bal, 2, '.', '')}} {{ $type }}</td> 
                </tr>
            </tbody>
        </table>
    </div> 
</div> 
@else
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Transactions</h2>
@endif 
    
          