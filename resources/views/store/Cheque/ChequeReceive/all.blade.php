<div class="card-footer p-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Last Received Transactions (
        @if (in_array($authUser->type,$storeUserTypesAll))
        {{ $authUser->name ?? ""  }}
        @endif
        @if (in_array($authUser->type,$storeTypesAll))
        {{ $authUser->company_name ?? ""  }}
        @endif
    )</h5>
 </div>
@if (count($ledgers))
<div class="table-responsive">
    <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
        <thead>
            <tr class="text-center">
                {{-- <th>From Voucher</th> --}}
                <th>Date</th>
                <th>Voucher No.</th>
                <th>From</th>
                <th>To</th>
                <th>Amount</th> 
                <th>Naration</th>
                {{-- <th>Balance</th>  --}}
            </tr>
        </thead>
        <tbody> 
            @foreach($ledgers as $ledger)
            <tr class="text-center"> 
                <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YYYY') }}   </td> 
                <td>{{$ledger->voucher_number ?? ""}}</td>
                <td> @if ($ledger->userIssue->type == 'user' || $ledger->userIssue->type == 'bank')
                  {{$ledger->userIssue->name ?? ""}} <br>
                  ({{$ledger->userIssue->parentStore->company_name ?? ""}})
                  @else
                  {{$ledger->userIssue->name ?? ""}} <br>
                  ({{$ledger->userIssue->company_name ?? ""}})
                  @endif</td>  
          <td>  @if ($ledger->userReceipt->type == 'user' || $ledger->userReceipt->type == 'bank')
                  {{$ledger->userReceipt->name ?? ""}} <br>
                  ({{$ledger->userReceipt->parentStore->company_name ?? ""}})
                  @else
                  {{$ledger->userReceipt->name ?? ""}}  <br>
                  ({{$ledger->userReceipt->company_name ?? ""}})
                  @endif</td>  
				  <td>{{ $ledger->total_amount ?? "" }}</td>  
				  <td>{{$ledger->comment}}</td>  
                {{-- <td>{{$ledger->getBalanace($authUser->id,$ledger->id)}}</td>   --}}
                 
            </tr> 
            @endforeach
            {{-- <tr class="text-center"> 
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total</td>
                <td>{{ $ledger->getTotalDebit($authUser->id) }}</td>
                <td>{{ $ledger->getTotalCredit($authUser->id) }}</td>
                <td>{{ $ledger->getTotalBalance($authUser->id) }}</td>
            </tr> --}}
        </tbody>
    </table>
</div>
@else
<h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; No Transactions</h2>
@endif 

    