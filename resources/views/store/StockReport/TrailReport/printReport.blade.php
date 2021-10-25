<!doctype html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Trial Report {{ $myAccount->company_name ?? "" }}</title>
      {{-- 
      <link href="http://fonts.cdnfonts.com/css/sugarcubes" rel="stylesheet">
      --}}
      {{-- 
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Hepta+Slab:wght@200;300;400&display=swap" rel="stylesheet">
      --}}
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      {{-- 
      <link href="https://fonts.googleapis.com/css2?family=Hepta+Slab:wght@300;400;500;600&display=swap" rel="stylesheet">
      --}}
      <style type="text/css">
         @page {
         margin: 0px;
         }
         body {
         margin: 20px; 
         font-size: xx-small;
         }
         * {
         font-family: Verdana, Arial, sans-serif;
         /* font-family: 'Hepta Slab', serif; */
         /* font-family: sans-serif; */
         }
         a {
         color: #fff;
         text-decoration: none;
         }
         table {
         /* font-size: x-small; */
         /* font-size:xx-small; */
         }
         tfoot tr td {
         font-weight: bold;
         /* font-size: x-small; */
         /* font-size:xx-small; */
         }
         .invoice table {
         margin: 15px;
         }
         .invoice h3 {
         margin-left: 15px;
         }
         .information {
         /* background-color: #60A7A6; */
         /* color: #FFF; */
         }
         .information .logo {
         margin: 5px;
         }
         .information table {
         padding: 10px;
         }
         /* Custom */
         .heading{
         /* font-family: 'Sugarcubes', sans-serif; */
         }
         hr {
         border: 1px dashed #000;
         border-style: none none dashed; 
         color: #fff; 
         background-color: #fff;
         }
         .custom-table {
         border:none;
         border-collapse: collapse;
         }
         .custom-table td {
         border-left: 1px solid #000;
         border-right: 1px solid #000;
         padding-left: 5px;
         padding-right: 5px;
         border-width: thin;
         }
         .custom-table td:first-child {
         /* border-left: none; */
         }
         .custom-table td:last-child {
         border-right: none;
         }
      </style>
   </head>
   <body> 
           
      <div class="information" style="">
        <table width="100%">
           <tr>
              <td align="center" style="width: 100%; font-size:small; font-family:Helpta Slab; font-weight:600">Trial Report {{ $myAccount->company_name ?? "" }}</td>
           </tr> 
        </table>
     </div>
      <div class="information">
         <table width="100%"  style="padding:0%" class="custom-table">
            <tr>
               {{-- 1 --}}
               <td align="left" style="width:25%; font-size:xx-small; font-weight:600;">UID.</td>
               {{-- 2 --}}
               <td align="left" style="width:25%; font-size:xx-small; font-weight:600;">Name</td>
               {{-- 3 --}}
               <td align="left" style="width:25%; font-size:xx-small; font-weight:600;">Debit</td>
               {{-- 4 --}}
               <td align="left" style="width:25%; font-size:xx-small; font-weight:600;">Credit</td> 
 
            </tr>
            <tr>
               <td  colspan="14">
                  <hr >
               </td>
            </tr>


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
                   <td style="text-align: right; ">{{$result['type'] == 'debit' ? $result['bal'] : ''}}</td>
                   <td style="text-align: right;">{{ $result['type'] == 'credit' ? $result['bal'] : '' }}</td>
                   {{-- <td><a target="_blank" href="{{ route('trialStockReport.currentView') }}">View</a></td> --}}
                </tr>
                @endif
                @foreach($accountGroups as $group) 
                <tr>
                    <td  colspan="14"  style="border:0;">
                       <hr >
                    </td>
                 </tr>
                <tr class="table-active">
                    <td colspan="4" style="font-weight: 600; background-color: #808080!important;">{{ $group->name }} </td>
                </tr>
                <tr>
                    <td  colspan="14"  style="border:0;">
                       <hr >
                    </td>
                 </tr>
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
                   <td style="text-align: right;">{{$result['type'] == 'debit' ? $result['bal'] : ''}}</td>
                   <td style="text-align: right;">{{ $result['type'] == 'credit' ? $result['bal'] : '' }}</td>
                   {{-- <td><a target="_blank" href="{{ route('trialStockReport.view',$account->id) }}">View</a></td> --}}
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
                   <td style="text-align: right;">{{$result['type'] == 'debit' ? $result['bal'] : ''}}</td>
                   <td style="text-align: right;">{{ $result['type'] == 'credit' ? $result['bal'] : '' }}</td>
                   {{-- <td><a target="_blank" href="{{ route('trialStockReport.view',$account->id) }}">View</a></td> --}}
                </tr>
                @endif
                @endif
                @endforeach 
                @endforeach
                <tr  class="text-center">
                   <td></td>
                   <td style="font-weight:600;">Total</td>
                   <td style="text-align: right;"> 
                      {{ $totalDebit }}
                   </td>
                   <td style="text-align: right;"> 
                      {{ $totalCredit }}
                   </td>
                </tr>
                <tr  class="text-center">
                   <td></td>
                   <td style="font-weight:600;">Difference</td>
                   <td style="text-align: right;"> 
                     @php
                     $difference=$totalCredit-$totalDebit;
                     $difference=amountFormat($difference);
                     @endphp
                     {{ $difference }}
                   </td>
                   <td>  
                   </td>
                </tr>
            
           
            
         </table>
      </div>
       
   </body>
</html>