@extends('layouts.store.app')
@section('content')
<div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Trial Report : 
        @if($user->type =='user')
        {{ $user->parentStore->name}}
          @endif
          @if($user->type == 'org' || $user->type == 'lab')
          {{ $user->company_name }}
          @endif 
    </h5>
    </div>
    <div class="card-body">
    @if(count($vouchers))
    <div class="table-responsive">
    <table class="table" id="table_id2" style="width:100">
            <thead>
                <tr>
                    <th id="click">UID</th>
                    <th>Voucher Name</th> 
                    <th>Debit</th>
                    <th>Credit</th> 
                    <th>Bal</th> 
                    <th>Action</th> 
                </tr>
            </thead>
            <tbody> 
            @php
                $authUserId = auth('store')->user()->id;
                $totalDebit = 0;
                $totalCredit = 0;
                 
            @endphp
            @foreach($vouchers as $voucher)
                @php
                  $result = $ledger->getTotalDebitCreditAmountByVoucher($accountId,$authUserId,$voucher->id);
                //   $totalDebit += $result['debit'];
                //   $totalCredit += $result['credit'];
                @endphp
                @if ($result['debit'] > 0 || $result['credit'] > 0  || (int)ltrim($result['bal'], 'A..z: ') > 0)
                <tr class="text-center">
                    <td>{{ $voucher->id }}</td>
                    <td>{{$voucher->name}}</td>  
                    <td>{{$result['credit']}}</td>  
                    <td>{{$result['debit']}}</td>  
                    <td>{{$result['bal']}}</td>
                    <td><a class=" btn btn-inverse" href="{{ route('trialStockReport.viewStock',['accountid' => $user->id,'voucherTypeId' => $voucher->id]) }}">View Stock</a></td>  
                </tr> 
                @endif 
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
    @endif
     </div>
    </div>
     @endsection
 