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
               <td align="center" style="width: 100%; font-size:xx-small; font-weight:500">{{ $ledger->storeReceipt->company_name ?? "" }}</td>
            </tr>
            <tr>
               <td align="center" style="width: 100%; font-size:xx-small">
                  {{ $ledger->storeReceipt->primaryAddress->address ?? "" }},
                  {{ $ledger->storeReceipt->primaryAddress->city->name ?? "" }},
                  {{ $ledger->storeReceipt->primaryAddress->pincode ?? "" }},
                  {{ $ledger->storeReceipt->primaryAddress->country->name ?? "" }}
               </td>
            </tr>
            <tr>
               <td align="center" style="width: 100%; font-size:xx-small; font-weight:500">>> {{ $ledger->voucher->name ?? "" }}<< &nbsp;</td>
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
               <td align="left" style="width: 50%; font-size:xx-small">Invoice No : {{ $ledger->voucher_number ?? "" }}</td>
               <td align="right" style="width: 50%; font-size:xx-small">Date : {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YYYY') }}</td>
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
               @if ($ledger->userReceipt->type == 'org' || $ledger->userReceipt->type == 'lab')
               <td align="left" style="width: 80%; font-size:xx-small">{{ $ledger->userReceipt->company_name ?? "" }}</td>
               @endif
               @if ($ledger->userReceipt->type == 'user')
               <td align="left" style="width: 80%; font-size:xx-small">{{ $ledger->userReceipt->name ?? "" }}</td>
               @endif
            </tr>
            <tr>
               <td align="left" style="width: 80%; font-size:xx-small">
                  {{ $ledger->userReceipt->addresses[0]->address ?? "" }},
                  {{  $ledger->userReceipt->addresses[0]->town->name ?? ""  }}
               </td>
            </tr>
            <tr>
               <td align="left" style="width: 80%; font-size:xx-small">
                  {{ $ledger->userReceipt->addresses[0]->city->name ?? "" }}-
                  {{ $ledger->userReceipt->addresses[0]->pincode ?? ""  }},
                  {{ $ledger->userReceipt->addresses[0]->state->name ?? "" }},
                  {{  $ledger->userReceipt->addresses[0]->country->name ?? "" }},
               </td>
            </tr>
        </table>
    </div>
   
    
    <div class="information">
        <table width="100%"  style="padding:0%">
            <tr>
               <td align="left" style="width: 80%; font-size:xx-small">
                  GSTIN -
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
      <div class="information">
         <table width="100%"  style="padding:0%" class="custom-table">
            <tr>
               {{-- 1 --}}
               <td align="left" style="width:4%; font-size:xx-small">Sr.</td>
               {{-- 2 --}}
               <td align="left" style="width:8%; font-size:xx-small">Gin</td>
               {{-- 3 --}}
               <td align="left" style="width:20%; font-size:xx-small">Product</td>
               {{-- 4 --}}
               <td align="left" style="width:8%; font-size:xx-small">HSN</td>
               {{-- 5 --}}
               <td align="right" style="width:5%; font-size:xx-small">Qty</td>
               {{-- 6 --}}
               <td align="right" style="width:4%; font-size:xx-small">Unit</td>
               {{-- 7 --}}
               <td align="right" style="width:6%; font-size:xx-small">Rate</td>
               {{-- 8 --}}
               <td align="right" style="width:9%; font-size:xx-small">MRP</td>
               {{-- 10 --}}
               <td align="right" style="width:1%; font-size:xx-small">Disc <br>(%)</td>
               {{-- 11 --}}
               <td align="right" style="width:9%; font-size:xx-small">Disc Amt</td>
               {{-- 9 --}}
               <td align="right" style="width:8%; font-size:xx-small">Taxable Amt</td>
               {{-- 12 --}}
               <td align="right" style="width:6%; font-size:xx-small">Tax %</td>
               {{-- 13 --}}
               <td align="right" style="width:7%; font-size:xx-small">Tax Amt</td>
               {{-- 14 --}}
               <td align="right" style="width:9%; font-size:xx-small">Amt</td>
            </tr>
            <tr>
               <td  colspan="14">
                  <hr >
               </td>
            </tr>
            @foreach ( $ledgerDetails->sortBy('productStock.productGrade.alias')->sortBy('productStock.product.name') as $detail)    
            <tr>
               {{-- 1 --}}
               <td align="left" style="width:4%; font-size:xx-small">{{ $loop->iteration }}</td>
               {{-- 2 --}}
               <td align="left" style="width:8%; font-size:xx-small">{{ $detail->gin ?? "" }}</td>
               {{-- 3 --}}
               <td align="left" style="width:20%; font-size:xx-small">{{ $detail->productStock->product->name }}-{{ $detail->productStock->productGrade->alias }} </td>
               {{-- 4 --}}
               <td align="left" style="width:8%; font-size:xx-small">{{ $detail->productStock->product->hsnCode->hsn_code ?? "" }}</td>
               {{-- 5 --}}
               <td align="right" style="width:5%; font-size:xx-small">{{ number_format($detail->product_unit_qty,2) }}</td>
               {{-- 6 --}}
               <td align="right" style="width:2%; font-size:xx-small">Ratti</td>
               {{-- 7 --}}
               <td align="right" style="width:6%; font-size:xx-small">{{ $detail->product_unit_rate }}</td>
               {{-- 8 --}}
               <td align="right" style="width:9%; font-size:xx-small">{{amountFormat($detail->product_unit_qty * $detail->product_unit_rate) }}</td>
               {{-- 10 --}}
               <td align="right" style="width:4%; font-size:xx-small">{{ $detail->discount_rate }}</td>
               {{-- 11 --}}
               <td align="right" style="width:8%; font-size:xx-small">{{ amountFormat($detail->discount_amount) }}</td>
               {{-- 9 --}}
               <td align="right" style="width:9%; font-size:xx-small">{{ amountFormat($detail->amount_with_discount) }}</td>
               {{-- 12 --}}
               <td align="right" style="width:6%; font-size:xx-small">{{ amountFormat($detail->tax_rate) }}</td>
               {{-- 13 --}}
               <td align="right" style="width:7%; font-size:xx-small">{{ amountFormat($detail->tax_amount) }}</td>
               {{-- 14 --}}
               <td align="right" style="width:9%; font-size:xx-small">{{ amountFormat($detail->mrp_without_tax) }}</td>
            </tr>
            @endforeach 
           
            <tr>
               <td  colspan="14"  style="border:0;">
                  <hr >
               </td>
            </tr>
            <tr >
               <td colspan="5" style="border:0;"></td>
               <td colspan="2" style="border:0;">Totals : </td>
               <td align="right" style="width:9%; font-size:xx-small; border:0">{{ amountFormat($ledger->products_amount) }}</td>
               <td align="right" style="width:9%; font-size:xx-small; border:0"></td>
               <td align="right" style="width:9%; font-size:xx-small; border:0">{{ amountFormat($ledger->discount_amount) }}</td>
               <td align="right" style="width:9%; font-size:xx-small; border:0">{{ amountFormat($ledger->amount_with_discount) }}</td>
               <td  style="border:0;"></td>
               <td align="right" style="width:7%; font-size:xx-small; border:0;">{{ amountFormat($ledger->tax_amount) }}</td>
               <td align="right" style="width:9%; font-size:xx-small; border:0;">{{ amountFormat($ledger->mrp_without_tax)  }}</td>
            </tr>
            <tr>
               <td  colspan="14"  style="border:0;">
                  <hr >
               </td>
            </tr>
            <tr>
         </table>
      </div>
      @php
      $taxes = App\Model\Admin\Organization\TaxRate::all()->pluck('rate');
      $couting[] = [];
      foreach ($taxes as $tax) {
          $tax = sprintf("%.2f", $tax); // $string = "0.123";
          $couting[$tax] = 0;
          $coutingAmount[$tax] = 0;
      }
      foreach ($taxes as $tax) {
         $tax = sprintf("%.2f", $tax); // $string = "0.123";
         foreach ($ledgerDetails as $rate) {
            if($tax == $rate->tax_rate){
                $couting[$tax] += 1;
                $coutingAmount[$tax] += $rate->tax_amount;

            }

         }
      }
      // dd(array_filter($coutingAmount));
     $final =  array_filter($couting);
     $coutingAmount =  array_filter($coutingAmount);
      foreach ($final as $key => $value) {
         
      } 
      @endphp
      <div class="information" style="width: 30%; display:inline-flex">
         <table width="50%"  style="padding:0%; border:1px solid black; border-collapse:collapse"  class="custom-table">
            <tr>
               <td>GST</td>
               @foreach ($final as $key => $item)
               <td>{{ $key }} </td>
               @endforeach
            </tr>
            
            <tr>
               <td>Details</td>
               @foreach ($coutingAmount as $key => $item)
               <td>{{ amountFormat($item) }} </td>
               @endforeach
            </tr>
         </table>
      </div>
      <div class="information" style="width: 69%;    display:inline-flex" >
         <table width="100%"  style="padding:0%">
            <tr>
               <td align="left" style="width: 50%; font-size:xx-small"></td>
               <td align="left" style="width: 20%; font-size:xx-small">Total Amount</td>
               <td align="right" style="width: 15%; font-size:xx-small">  (-)</td>
               <td align="right" style="width: 15%; font-size:xx-small">{{  amountFormat($ledger->mrp_without_tax)}}</td>
            </tr>
            <tr>
               <td align="left" style="width: 50%; font-size:xx-small"></td>
               <td align="left" style="width: 20%; font-size:xx-small">Discount</td>
               <td align="right" style="width: 15%; font-size:xx-small">  (-)</td>
               <td align="right" style="width: 15%; font-size:xx-small">{{ amountFormat($ledger->discount_amount) }}</td>
            </tr>
          
            <tr>
               <td align="left" style="width: 50%; font-size:xx-small"></td>
               <td align="left" style="width: 20%; font-size:xx-small">GST</td>
               <td align="right" style="width: 15%; font-size:xx-small">(+)</td>
               <td align="right" style="width: 15%; font-size:xx-small">{{ amountFormat($ledger->tax_amount) }}</td>
            </tr>
         </table>
      </div>
      
      <div class="information" style="width: 30%; display:inline-flex">
      </div>
      <div class="information" style="width: 69%;    display:inline-flex" >
         <table width="100%"  style="padding:0%">
            <tr>
               <td align="left" style="width: 50%; font-size:xx-small"></td>
               <td align="left" style="width: 20%; font-size:xx-small">Net Amount</td>
               <td align="right" style="width: 15%; font-size:xx-small"></td>
               <td align="right" style="border-top:1px solid black; width: 15%; font-size:xx-small">{{ amountFormat($ledger->total_amount)}}</td>
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
      <div class="information">
         <table width="100%"  style="padding:0%">
            <tr>
               <td align="left" style="width: 100%; font-size:xx-small">Amount in Words:  {{ucwords($ledger->convertNumberToWord($ledger->total_amount)) }}</td>
            </tr>
         </table>
      </div>
      <div class="information">
         <table width="100%"  style="padding:0%">
            <tr>
               <td align="left" style="width: 100%; font-size:xx-small">Note: No E-way Bill is required to be generated as the Goods covered under this Challan Exempted as per Serial No.150/151 to the Annexure to Rule 138(14) of the CGST Rules.</td>
            </tr>
         </table>
      </div>
      <div class="information">
         <table width="100%"  style="padding:0%">
            <tr>
               <td align="left" style="width: 50%; font-size:xx-small">&nbsp;</td>
               <td align="right" style="width: 50%; font-size:xx-small;">For {{ $ledger->storeReceipt->company_name ?? "" }}</td>
            </tr>
         </table>
      </div>
      <div class="information">
         <table width="100%"  style="padding:0%">
            <tr>
               <td align="left" style="width: 50%; font-size:xx-small">Audit________Dt : ________</td>
            </tr>
         </table>
      </div>
      <div class="information">
         <table width="100%"  style="padding:0%">
            <tr>
               <td align="right" style="width: 100%; font-size:xx-small">Auth Signatory</td>
            </tr>
         </table>
      </div>
      <div class="information" style="padding:0px;">
         <table width="100%"  style="padding:0%">
            <tr>
               <td align="left" style="width: 33%; font-size:xx-small">
                  _________________________________ <br>
                  {{ $ledger->userReceipt->name ?? "" }} <br>
                  Received By  
               </td>
               <td align="left" style="width: 33%; font-size:xx-small">_________________________________<br><br>Checked By</td>
               <td align="left" style="width: 33%; font-size:xx-small">
                  _________________________________ <br>
                  {{ $ledger->userIssue->name ?? "" }} <br>
                  Issued By 
               </td>
            </tr>
         </table>
      </div>
   </body>
</html>