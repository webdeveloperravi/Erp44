@extends('layouts.store.app')
@section('content') 
<div class="card" id="form">
   <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Current Cash Payment Ledger</h5>
   </div> 
   <div class="container"> 
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
                  </tr>
              </thead>
              <tbody> 
                  @foreach($paymentLedgers as $ledger)
                  <tr class="text-center"> 
                      <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YYYY') }}   </td> 
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

{{--                     
                      <td>{{$ledger->userIssue->name ?? ""}}</td>
                      <td>{{$ledger->userReceipt->name ?? ""}}</td> --}}
                      <td>{{$ledger->comment}}</td>  
                      <td>{{$ledger->getDebitAmount($authUser->id,$ledger->id)}}</td> 
                      <td>{{$ledger->getCreditAmount($authUser->id,$ledger->id)}}</td> 
                      <td>{{$ledger->getBalanace($authUser->id,$ledger->id)}}</td>  
                       
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
  
</script>
@endsection