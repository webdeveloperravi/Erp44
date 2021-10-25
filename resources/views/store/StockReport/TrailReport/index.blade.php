@extends('layouts.store.app')
@section('content') 
<div class="card">
   <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Trial Report</h5>
   </div>
   <div class="card-body">
      
      <a href="{{ route('trialStockReport.printReport') }}">Print</a>
      @if(count($accounts))
      <div class="table-responsive">
         <table class="table" id="table_id2" style="width:100">
            <thead>
               <tr>
                  <th id="click">UID</th>
                  <th> Name</th>
                  <th>Debit</th>
                  <th>Credit</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               @php
               $authUserId = auth('store')->user()->id;
               $authUserStoreId = App\Helpers\StoreHelper::getStoreId();
               $totalDebit = 0;
               $totalCredit = 0;
               @endphp

               @php
               $result = App\Services\Trial\UserDebitCreditAmount::getUserDebitCreditAmount(App\Helpers\StoreHelper::getStoreId());
               $account = App\Model\Guard\UserStore::find(App\Helpers\StoreHelper::getStoreId());
               if($result['bal'] != 0){
               $show = true;
               if($result['type'] == 'debit'){
               $totalDebit += $result['bal'];
               }else{
               $totalCredit += $result['bal'];
               }
               }else{
               $show = false;
               }
               @endphp
               @if($show)
               <tr class="text-center">
                  <td>{{ $account->id }}</td>
                  <td>
                  {{ $account->name ?? "" }}
                  </td>
                  <td>{{$result['type'] == 'debit' ? $result['bal'] : ''}}</td>
                  <td>{{ $result['type'] == 'credit' ? $result['bal'] : '' }}</td>
                  <td><a target="_blank" href="{{ route('trialStockReport.currentView') }}">View</a></td>
               </tr>
               @endif
               @foreach($accountGroups as $group) 
               <tr class="table-active"><td colspan="5">{{ $group->name }} </td></tr>
               @foreach($accounts[$group->id] as $account)
               @if ($account->org_id == $authUserStoreId && in_array($account->type,$storeUserTypesAll))
               @php
               $result = App\Services\Trial\UserDebitCreditAmount::getUserDebitCreditAmount($account->id);
               if($result['bal'] != 0){
               $show = true;
               if($result['type'] == 'debit'){
               $totalDebit += $result['bal'];
               }else{
               $totalCredit += $result['bal'];
               }
               }else{
               $show = false;
               }
               @endphp
               @if($show)
               <tr class="text-center">
                  <td>{{ $account->id }}</td>
                  <td>
                     {{-- @if($account->type == 'user' ||$account->type == 'bank') --}}
                     @if(in_array($account->type,$storeUserTypesAll))
                     {{ $account->name}}
                     @endif
                  </td>
                  <td>{{$result['type'] == 'debit' ? $result['bal'] : ''}}</td>
                  <td>{{ $result['type'] == 'credit' ? $result['bal'] : '' }}</td>
                  <td><a target="_blank" href="{{ route('trialStockReport.view',$account->id) }}">View</a></td>
               </tr>
               @endif 
               @endif 
               @if ($account->org_id == $authUserStoreId && in_array($account->type,$storeTypesAll))
               @php
               $result = App\Services\Trial\StoreDebitCreditAmount::getStoreDebitCreditAmount($account->id);
               if($result['bal'] != 0){
               $show = true;
               if($result['type'] == 'debit'){
               $totalDebit += $result['bal'];
               }else{
               $totalCredit += $result['bal'];
               }
               }else{
               $show = false;
               }
               @endphp
               @if($show)
               <tr class="text-center">
                  <td>{{ $account->id }}</td>
                  <td>
                     @if(in_array($account->type,$storeTypesAll) )
                     {{ $account->company_name }} - {{ $account->headOfficeAddress->city->name ?? "" }}
                     @endif
                  </td>
                  <td>{{$result['type'] == 'debit' ? $result['bal'] : ''}}</td>
                  <td>{{ $result['type'] == 'credit' ? $result['bal'] : '' }}</td>
                  <td><a target="_blank" href="{{ route('trialStockReport.view',$account->id) }}">View</a></td>
               </tr>
               @endif
               @endif
               @endforeach 
               @endforeach
               <tr  class="text-center">
                  <td></td>
                  <td>Total</td>
                  <td> 
                     {{ $totalDebit }}
                  </td>
                  <td> 
                     {{ $totalCredit }}
                  </td>
               </tr>
               <tr  class="text-center">
                  <td></td>
                  <td>Difference</td>
                  <td> 
                     {{ $totalCredit - $totalDebit }}
                  </td>
                  <td>  
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
      @else
      <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
      @endif
   </div>
</div>
@endsection 