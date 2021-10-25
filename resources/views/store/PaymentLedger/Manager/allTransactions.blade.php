{{-- @if (count($paymentLedgers) > 0)
 
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
                    <th>Naration</th>
                </tr>
            </thead>
            <tbody> 
                @foreach($paymentLedgers as $ledger)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
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
                    <td>{{$ledger->getDebitAmount($authUser->id,$ledger->id)}}</td> 
                    <td>{{$ledger->getCreditAmount($authUser->id,$ledger->id)}}</td> 
                    <td>{{$ledger->getBalanace($authUser->id,$ledger->id)}}</td> 
                    
                    <td>{{$ledger->comment}}</td>  
                </tr> 
                @endforeach
                <tr class="text-center"> 
                    <td></td>
                    <td></td>
                    <td></td> 
                    <td></td>  
                    <td>Total</td>
                    <td>{{ $ledger->getTotalDebit($authUser->id) }}</td>  
                      <td>{{ $ledger->getTotalCredit($authUser->id) }}</td> 
                    <td>{{ $ledger->getTotalBalance($authUser->id) }}</td>
                </tr>
            </tbody>
        </table>
    </div> 
</div> 
@else
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Transactions</h2>
@endif 
    
          <h1>Saab</h1> --}}


          @if(in_array($account->type,$storeUserTypesAll))
@php
$userApprovalLedgers =  App\Services\Trial\GetUserLedger::getApprovalLedgers($account->id);
$userFinalLedgers = App\Services\Trial\GetUserLedger::getFinalLedgers($account->id);
$userInvoiceLedgers = App\Services\Trial\GetUserLedger::getInvoiceLedgers($account->id);
$userCashLedgers = App\Services\Trial\GetUserLedger::getCashLedgers($account->id);
@endphp 
{{-- User Approval Ledgers --}}
@if (count($userApprovalLedgers) > 0)
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Approval ({{ $account->name ?? "" }})
    </h5>
    </div>
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
                @foreach($userApprovalLedgers as $ledger)
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
                    $debit = App\Services\Trial\GetUserLedger::countDebitAmount($account->id,$ledger->from,$ledger->total_amount);
                    $credit = App\Services\Trial\GetUserLedger::countCreditAmount($account->id,$ledger->to,$ledger->total_amount);
                    $bal = App\Services\Trial\GetUserLedger::getApprovalLedgerBalance($account->id,$ledger->id); 
                    @endphp
                    <td>{{ $debit ? number_format((float)$debit, 2, '.', '') : ""}}</td>  
                    <td>{{ $credit ? number_format((float)$credit, 2, '.', '') : ""}}</td>  
                    <td>{{number_format((float)$bal['amount'], 2, '.', '')}} {{ $bal['type'] }}</td> 
                    
                    
                    {{-- <td>{{number_format((float)App\Services\GetUserLedger::countDebitAmountUserLedger($account->id,$ledger->from,$ledger->total_amount), 2, '.', '')}}</td> 
                     <td>{{number_format((float)App\Services\GetUserLedger::countCreditAmountUserLedger($account->id,$ledger->to,$ledger->total_amount), 2, '.', '')}}</td>  
                     <td>{{number_format((float)App\Services\GetUserLedger::getUserApprovalLedgerDebitCreditBalance($account->id,$ledger->id), 2, '.', '')}}</td>    --}}
                     <td>{{$ledger->comment}}</td>  
                     
                </tr> 
                @endforeach
                <tr class="text-center"> 
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td> 
                    <td>Total</td>  
                    {{-- <td>{{number_format((float)$total['debit'], 2, '.', '')}}</td>   
                    <td>{{number_format((float)$total['credit'], 2, '.', '')}}</td>    
                    <td>{{ number_format((float)$total['bal'], 2, '.', '') }}</td> --}}
                    @php
                     $total = App\Services\Trial\GetUserLedger::getApprovalLedgerTotal($account->id);
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
</div>
@endif
    {{-- User Final Ledgers --}}
    
@if (count($userFinalLedgers) > 0)
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Final  ({{ $account->name ?? "" }})
    </h5>
    </div>
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
                @foreach($userFinalLedgers as $ledger)
                <tr class="text-center"> 
                    @php
                    if(!isset($ledger->userReceipt)){
                        dd($ledger);
                    }

                @endphp
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
                    $debit = App\Services\Trial\GetUserLedger::countDebitAmount($account->id,$ledger->from,$ledger->total_amount);
                    $credit = App\Services\Trial\GetUserLedger::countCreditAmount($account->id,$ledger->to,$ledger->total_amount);
                    $bal = App\Services\Trial\GetUserLedger::getFinalLedgerBalance($account->id,$ledger->id); 
                    @endphp
                    <td>{{ $debit ? number_format((float)$debit, 2, '.', '') : ""}}</td>  
                    <td>{{ $credit ? number_format((float)$credit, 2, '.', '') : ""}}</td>  
                    <td>{{number_format((float)$bal['amount'], 2, '.', '')}} {{ $bal['type'] }}</td> 
                    
                    
                    {{-- <td>{{number_format((float)App\Services\GetUserLedger::countDebitAmountUserLedger($account->id,$ledger->from,$ledger->total_amount), 2, '.', '')}}</td>  
                    <td>{{number_format((float)App\Services\GetUserLedger::countCreditAmountUserLedger($account->id,$ledger->to,$ledger->total_amount), 2, '.', '')}}</td> 
                    <td>{{number_format((float)App\Services\GetUserLedger::getUserFinalLedgerDebitCreditBalance($account->id,$ledger->id), 2, '.', '')}}</td>   --}}
                     <td>{{$ledger->comment}}</td>  
                     
                </tr> 
                @endforeach
                <tr class="text-center"> 
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td> 
                    <td>Total</td> 
                    {{-- <td>{{number_format((float)$total['debit'], 2, '.', '')}}</td>   
                    <td>{{number_format((float)$total['credit'], 2, '.', '')}}</td>    
                    <td>{{ number_format((float)$total['bal'], 2, '.', '') }}</td> --}}

                    @php
                   $total = App\Services\Trial\GetUserLedger::getFinalLedgerTotal($account->id);
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
</div>  
    @endif   
    {{-- User Invoice Ledgers --}}
    
@if (count($userInvoiceLedgers) > 0)
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Invoice  ({{ $account->name ?? "" }})
    </h5>
    </div>
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
                @foreach($userInvoiceLedgers as $ledger)
                <tr class="text-center"> 
                    @php
                    if(!isset($ledger->userReceipt)){
                        dd($ledger);
                    }

                @endphp
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
                    $debit = App\Services\Trial\GetUserLedger::countDebitAmount($account->id,$ledger->from,$ledger->total_amount);
                    $credit = App\Services\Trial\GetUserLedger::countCreditAmount($account->id,$ledger->to,$ledger->total_amount);
                    $bal = App\Services\Trial\GetUserLedger::getInvoiceLedgerBalance($account->id,$ledger->id); 
                    @endphp
                    <td>{{ $debit ? number_format((float)$debit, 2, '.', '') : ""}}</td>  
                    <td>{{ $credit ? number_format((float)$credit, 2, '.', '') : ""}}</td>  
                    <td>{{number_format((float)$bal['amount'], 2, '.', '')}} {{ $bal['type'] }}</td> 
                    
                    
                    {{-- <td>{{number_format((float)App\Services\GetUserLedger::countDebitAmountUserLedger($account->id,$ledger->from,$ledger->total_amount), 2, '.', '')}}</td>  
                    <td>{{number_format((float)App\Services\GetUserLedger::countCreditAmountUserLedger($account->id,$ledger->to,$ledger->total_amount), 2, '.', '')}}</td> 
                    <td>{{number_format((float)App\Services\GetUserLedger::getUserFinalLedgerDebitCreditBalance($account->id,$ledger->id), 2, '.', '')}}</td>   --}}
                     <td>{{$ledger->comment}}</td>  
                     
                </tr> 
                @endforeach
                <tr class="text-center"> 
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td> 
                    <td>Total</td> 
                    {{-- <td>{{number_format((float)$total['debit'], 2, '.', '')}}</td>   
                    <td>{{number_format((float)$total['credit'], 2, '.', '')}}</td>    
                    <td>{{ number_format((float)$total['bal'], 2, '.', '') }}</td> --}}

                    @php
                   $total = App\Services\Trial\GetUserLedger::getInvoiceLedgerTotal($account->id);
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
</div>  
    @endif   
    {{-- User Cash Ledgers --}}
    
@if (count($userCashLedgers) > 0)
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Cash  ({{ $account->name ?? "" }})
    </h5>
    </div>
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
                @foreach($userCashLedgers as $ledger)
                <tr class="text-center"> 
                    @php
                    if(!isset($ledger->userReceipt)){
                        dd($ledger);
                    }

                @endphp
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
                    $debit = App\Services\Trial\GetUserLedger::countDebitAmount($account->id,$ledger->from,$ledger->total_amount);
                    $credit = App\Services\Trial\GetUserLedger::countCreditAmount($account->id,$ledger->to,$ledger->total_amount);
                    $bal = App\Services\Trial\GetUserLedger::getCashLedgerBalance($account->id,$ledger->id); 
                    @endphp
                    <td>{{ $debit ? number_format((float)$debit, 2, '.', '') : ""}}</td>  
                    <td>{{ $credit ? number_format((float)$credit, 2, '.', '') : ""}}</td>  
                    <td>{{number_format((float)$bal['amount'], 2, '.', '')}} {{ $bal['type'] }}</td> 
                    
                    
                    {{-- <td>{{number_format((float)App\Services\GetUserLedger::countDebitAmountUserLedger($account->id,$ledger->from,$ledger->total_amount), 2, '.', '')}}</td>  
                    <td>{{number_format((float)App\Services\GetUserLedger::countCreditAmountUserLedger($account->id,$ledger->to,$ledger->total_amount), 2, '.', '')}}</td> 
                    <td>{{number_format((float)App\Services\GetUserLedger::getUserFinalLedgerDebitCreditBalance($account->id,$ledger->id), 2, '.', '')}}</td>   --}}
                     <td>{{$ledger->comment}}</td>  
                     
                </tr> 
                @endforeach
                <tr class="text-center"> 
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td> 
                    <td>Total</td> 
                    {{-- <td>{{number_format((float)$total['debit'], 2, '.', '')}}</td>   
                    <td>{{number_format((float)$total['credit'], 2, '.', '')}}</td>    
                    <td>{{ number_format((float)$total['bal'], 2, '.', '') }}</td> --}}

                    @php
                   $total = App\Services\Trial\GetUserLedger::getCashLedgerTotal($account->id);
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
</div>  
    @endif   
    @endif   

@if (count($userApprovalLedgers) == 0 && count($userFinalLedgers) == 0 ) 
        
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Transactions</h2>
    @endif