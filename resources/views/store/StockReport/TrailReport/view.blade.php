@extends('layouts.store.app')
@section('content')  
@if(in_array($account->type,$storeTypesAll))
@php
$storeApprovalLedgers =  App\Services\Trial\GetStoreLedger::getApprovalLedgers($account->id);
$storeFinalLedgers = App\Services\Trial\GetStoreLedger::getFinalLedgers($account->id);
$storeInvoiceLedgers = App\Services\Trial\GetStoreLedger::getInvoiceLedgers($account->id);
$storeCashLedgers = App\Services\Trial\GetStoreLedger::getCashLedgers($account->id);
$storeBankLedgers = App\Services\Trial\GetStoreLedger::getBankLedgers($account->id);
$storeOthersLedgers = App\Services\Trial\GetStoreLedger::getOthersLedgers($account->id);
@endphp    
{{-- Store Approval Ledgers --}}
@if (count($storeApprovalLedgers) > 0)
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Approval ({{ $account->company_name ?? "" }})
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
                @foreach($storeApprovalLedgers as $ledger)
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
                       $debit = App\Services\Trial\GetStoreLedger::countDebitAmount($account->id,$ledger->from,$ledger->total_amount);
                       $credit = App\Services\Trial\GetStoreLedger::countCreditAmount($account->id,$ledger->to,$ledger->total_amount);
                       $bal = App\Services\Trial\GetStoreLedger::getApprovalLedgerBalance($account->id,$ledger->id); 
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
                        $total = App\Services\Trial\GetStoreLedger::getApprovalLedgerTotal($account->id);
                        $debit = $total['debit'];
                        $credit = $total['credit'];
                        $bal = $total['amount'];
                        $type = $total['type'];
                    @endphp 
                <td>{{number_format((float)$credit, 2, '.', '')}}</td>  
                <td>{{number_format((float)$debit, 2, '.', '')}}</td> 
                <td>{{number_format((float)$bal, 2, '.', '')}} {{ $type }}</td>  
                </tr>
            </tbody>
        </table>
    </div> 
</div>
</div>
@endif
    {{-- Store Final Ledgers --}}
@if (count($storeFinalLedgers) > 0)
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Final ({{ $account->company_name ?? "" }})
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
                @foreach($storeFinalLedgers as $ledger)
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
                    $debit = App\Services\Trial\GetStoreLedger::countDebitAmount($account->id,$ledger->from,$ledger->total_amount);
                    $credit = App\Services\Trial\GetStoreLedger::countCreditAmount($account->id,$ledger->to,$ledger->total_amount);
                    $bal = App\Services\Trial\GetStoreLedger::getFinalLedgerBalance($account->id,$ledger->id); 
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
</div>
    @endif 
{{-- Store Invoice Ledgers --}}
@if (count($storeInvoiceLedgers) > 0)
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Invoice ({{ $account->company_name ?? "" }})
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
                @foreach($storeInvoiceLedgers as $ledger)
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
                    $debit = App\Services\Trial\GetStoreLedger::countDebitAmount($account->id,$ledger->from,$ledger->total_amount);
                    $credit = App\Services\Trial\GetStoreLedger::countCreditAmount($account->id,$ledger->to,$ledger->total_amount);
                    $bal = App\Services\Trial\GetStoreLedger::getInvoiceLedgerBalance($account->id,$ledger->id); 
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
                        $total = App\Services\Trial\GetStoreLedger::getInvoiceLedgerTotal($account->id);
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
{{-- Store Cash Ledgers --}}
@if (count($storeCashLedgers) > 0)
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Cash ({{ $account->company_name ?? "" }})
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
                @foreach($storeCashLedgers as $ledger)
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
                    $debit = App\Services\Trial\GetStoreLedger::countDebitAmount($account->id,$ledger->from,$ledger->total_amount);
                    $credit = App\Services\Trial\GetStoreLedger::countCreditAmount($account->id,$ledger->to,$ledger->total_amount);
                    $bal = App\Services\Trial\GetStoreLedger::getCashLedgerBalance($account->id,$ledger->id); 
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
                        $total = App\Services\Trial\GetStoreLedger::getCashLedgerTotal($account->id);
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
{{-- Store Bank Ledgers --}}
@if (count($storeBankLedgers) > 0)
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Bank ({{ $account->company_name ?? "" }})
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
                @foreach($storeBankLedgers as $ledger)
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
                    $debit = App\Services\Trial\GetStoreLedger::countDebitAmount($account->id,$ledger->from,$ledger->total_amount);
                    $credit = App\Services\Trial\GetStoreLedger::countCreditAmount($account->id,$ledger->to,$ledger->total_amount);
                    $bal = App\Services\Trial\GetStoreLedger::getBankLedgerBalance($account->id,$ledger->id); 
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
                        $total = App\Services\Trial\GetStoreLedger::getBankLedgerTotal($account->id);
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
{{-- Store Others Ledgers --}}
@if (count($storeOthersLedgers) > 0)
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Others ({{ $account->company_name ?? "" }})
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
                @foreach($storeOthersLedgers as $ledger)
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
                    $debit = App\Services\Trial\GetStoreLedger::countDebitAmount($account->id,$ledger->from,$ledger->total_amount);
                    $credit = App\Services\Trial\GetStoreLedger::countCreditAmount($account->id,$ledger->to,$ledger->total_amount);
                    $bal = App\Services\Trial\GetStoreLedger::getOthersLedgerBalance($account->id,$ledger->id); 
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
                        $total = App\Services\Trial\GetStoreLedger::getOthersLedgerTotal($account->id);
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

@endsection
