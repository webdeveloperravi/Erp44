<!doctype html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Invoice{{ $ledger->voucher_number ?? "" }}</title>
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
         margin-left: 20px;
         margin-right: 20px;
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
         border-widtd: tdin;
         }
         .custom-table td:first-child {
         /* border-left: none; */
         }
         .custom-table td:last-child {
         border-right: none;
         }

         @media print{@page {size: landscape}}
      </style>
   </head>
   <body>
 
      <div class="information" style="">
         <table width="100%">
            <tr>
               <td align="center" style="width: 100%; font-size:xx-small; font-weight:500">
                  @if (in_array($authUser->type,$storeUserTypesAll))
                  {{ $authUser->parentStore->company_name ?? "" }}
                  @else
                  {{ $authUser->company_name }}
                  @endif
               </td>
            </tr>
            <tr>
               <td align="center" style="width: 100%; font-size:xx-small">
                  @if (in_array($authUser->type,$storeUserTypesAll))
                  {{ $authUser->parentStore->primaryAddress->address ?? "" }},
                  {{ $authUser->parentStore->primaryAddress->city->name ?? "" }},
                  {{ $authUser->parentStore->primaryAddress->pincode ?? "" }},
                  {{ $authUser->parentStore->primaryAddress->country->name ?? "" }}
                  @else
                  {{ $authUser->primaryAddress->address ?? "" }},
                  {{ $authUser->primaryAddress->city->name ?? "" }},
                  {{ $authUser->primaryAddress->pincode ?? "" }},
                  {{ $authUser->primaryAddress->country->name ?? "" }}  
                  @endif
               </td>
            </tr> 
         </table>
      </div>
      <div class="information">
         <table width="100%"  style="padding:0%">
            <tr>
               <hr>
            </tr>
         </table>
      </div>
      <div class="information" style="padding:0px;">
         <table width="100%"  style="padding:0%">
            <tr>
               <td align="left" style="width: 50%; font-size:xx-small"> Name : {{ $authUser->name ?? "" }}</td>
               <td align="right" style="width: 50%; font-size:xx-small">Report Date : {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now())->isoFormat('DD-MM-YYYY') }}</td>
            </tr>
            <tr>
               <td align="left" style="width: 50%; font-size:xx-small"> Company : 
                  @if (in_array($authUser->type,$storeUserTypesAll))
                  {{ $authUser->parentStore->company_name ?? "" }}
                  @else
                  {{ $authUser->company_name ?? "" }}
                  @endif
               </td>
            </tr>
            <tr>
               <td align="left" style="width: 50%; font-size:xx-small"> Total Products : 
                {{ $totalProducts ?? "" }}
               </td>
            </tr>
         </table>
      </div>
      <div class="information">
         <table width="100%"  style="padding:0%">
            <tr>
               <hr>
            </tr>
         </table>
      </div>
      @foreach ($products as $product)
      @if (!empty($data[$product['id']]))
      <h3>{{ $product->alias }}</h3>
      <div class="information">
         @php
         $rattis = $product->getUniqueRattis($product->id,$productStockIds)
         @endphp
         <table widtd="100%"  style="padding:0%" class="custom-table">
            <tr style="">
                <td  colspan="{{ count($rattis) + 2 }}">
                   <hr >
                </td>
             </tr>
            <tr>
               <td  style="font-weight: 600">G/R</td>
             
               @foreach ($rattis->sortBy('rati_standard') as $ratti) 
               <td  style="font-weight: 600">
                  {{ $ratti->rati_standard }}+          
               </td>
               @endforeach
               <td style="font-weight: 600">Total</td>
            </tr>
            <tr>
               <td  colspan="{{ count($rattis) + 2 }}">
                  <hr >
               </td>
            </tr>
            @foreach ($product->getUniqueGrades($product->id,$productStockIds) as $grade)
            
            <tr>
               <td  style="font-weight: 600">{{ $grade->alias }}</td>
               @if (!empty($data[$product['id']][$grade['id']])) 
               @foreach ($rattis->sortBy('rati_standard') as $ratti) 
               @if (!empty($data[$product['id']][$grade['id']][$ratti['id']]))
               <td  style="font-weight: 600">{{ count($data[$product['id']][$grade['id']][$ratti['id']]) }}</td> 
               @else 
               <td><div style="background-color: #808080!important; ">&nbsp;&nbsp;&nbsp;</div></td>
               @endif
               @endforeach 
               <td style="font-weight: 600">{{ count(Arr::collapse($data[$product['id']][$grade['id']])) }}</td>
               @else 
               <td></td>
               @endif 
            </tr> 
            @if (!$loop->last)
            <tr>
                <td  colspan="{{ count($rattis) + 2 }}">
                   <hr >
                </td>
             </tr>   
            @endif
            @endforeach  
            <tr>
               <td  colspan="{{ count($rattis) + 2 }}">
                  <hr >
               </td>
            </tr> 
            <tr>
               <td style="font-weight: 600">Total</td> 
               @foreach ($rattis->sortBy('rati_standard') as $ratti) 
 
               <td style="font-weight: 600">{{ count($data2[$product['id']][$ratti['id']]) }}</td>  
               @endforeach 
               <td style="font-weight: 600">{{ count(Arr::collapse($data2[$product['id']])) }}</td>
            </tr>
            <tr>
               <td  colspan="{{ count($rattis) + 2 }}"  style="border:0;">
                  <hr >
               </td>
            </tr>
         </table>
      </div>
      @endif
      @endforeach
 
   </body>
</html>