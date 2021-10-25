<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sale_Challan_{{ $ledger->voucher_number ?? "" }}</title>
    {{-- <link href="http://fonts.cdnfonts.com/css/sugarcubes" rel="stylesheet"> --}}
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hepta+Slab:wght@200;300;400&display=swap" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hepta+Slab:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style type="text/css">
        @page {
            margin: 0px;
        }
        body {
            margin-left: 50px;
            margin-right: 50px;
        }
        * {
            /* font-family: Verdana, Arial, sans-serif; */
            font-family: 'Hepta Slab', serif;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
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
                <td align="center" style="width: 100%; font-size:small; font-weight:500">{{ $ledger->storeReceipt->company_name ?? "" }}</td> 
            </tr>
            <tr>
                <td align="center" style="width: 100%; font-size:small">
                    {{ $ledger->storeReceipt->primaryAddress->address ?? "" }},
                    {{ $ledger->storeReceipt->primaryAddress->city->name ?? "" }},
                    {{ $ledger->storeReceipt->primaryAddress->pincode ?? "" }},
                    {{ $ledger->storeReceipt->primaryAddress->country->name ?? "" }}
                </td> 
            </tr>
            <tr>
                <td align="center" style="width: 100%; font-size:small; font-weight:500">>> {{ $ledger->voucher->name ?? "" }}<< &nbsp;</td> 
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
                <td align="left" style="width: 50%; font-size:small">Challan No : {{ $ledger->voucher_number ?? "" }}</td> 
                <td align="right" style="width: 50%; font-size:small">Date : {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YYYY') }}</td> 
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
                <td align="left" style="width: 80%; font-size:small">{{ $ledger->userReceipt->company_name ?? "" }}</td> 
                @endif
                @if ($ledger->userReceipt->type == 'user')
                <td align="left" style="width: 80%; font-size:small">{{ $ledger->userReceipt->name ?? "" }}</td> 
                @endif
            </tr> 
            <tr>  
                <td align="left" style="width: 80%; font-size:small">
                    {{ $ledger->userReceipt->addresses[0]->address ?? "" }},
                    {{  $ledger->userReceipt->addresses[0]->town->name ?? ""  }}
                </td> 
            </tr> 
            <tr> 
                {{-- <td align="left" style="width: 7%; font-size:small">Address : </td>  --}}
                <td align="left" style="width: 80%; font-size:small">
                    {{ $ledger->userReceipt->addresses[0]->city->name ?? "" }}-
                    {{ $ledger->userReceipt->addresses[0]->pincode ?? ""  }},
                    {{ $ledger->userReceipt->addresses[0]->state->name ?? "" }},
                    {{  $ledger->userReceipt->addresses[0]->country->name ?? "" }},
                </td> 
            </tr> 
            <tr> 
                {{-- <td align="left" style="width: 7%; font-size:small">Address : </td>  --}}
                <td align="left" style="width: 80%; font-size:small">
                    GSTIN -
                </td> 
            </tr>  
        </table>
    </div>
    {{-- <div class="information">
        <table width="100%"  style="padding:0%"> 
            <tr>
                <td align="left" style="width: 100%; font-size:small">DL-PADAMNAGAR-NEW-KHANDEWAL-JEWELLERS-S-17</td>  
            </tr> 
        </table>
    </div> --}}
    {{-- <div class="information">
        <table width="100%"  style="padding:0%">
            <tr>
                <hr>
            </tr>
        </table>
    </div>
     --}}
    
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
                <td align="left" style="width:5%; font-size:small">Sr.No.</td>  
                <td align="left" style="width:24%; font-size:small">Item Name</td>  
                <td align="left" style="width:9%; font-size:small">Gin</td>  
                <td align="left" style="width:13%; font-size:small">HSN Code</td>  
                {{-- <td align="left" style="width:9%; font-size:small">Wt./Mg</td>    --}}
                <td align="left" style="width:9%; font-size:small">Qty.</td>  
                <td align="left" style="width:9%; font-size:small">Unit</td>  
                <td align="right" style="width:9%; font-size:small">Rate</td>  
                <td align="right" style="width:13%; font-size:small">Amount</td>  
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
            @foreach ($ledgerDetails->sortBy('product_unit_qty') as $detail)
           
            <tr>
                <td align="left" style="width:5%; font-size:small">{{ $loop->iteration }}</td>
                <td align="left" style="width:24%; font-size:small">{{ $detail->productStock->product->name }}-{{ $detail->productStock->productGrade->alias }}-{{ $detail->productStock->ratti->rati_standard }}+ </td>  
                <td align="left" style="width:9%; font-size:small">{{ $detail->productStock->gin ?? "" }}</td>  
                <td align="left" style="width:13%; font-size:small">{{ $detail->productStock->product->hsnCode->hsn_code ?? "" }}</td>  
                {{-- <td align="left" style="width:9%; font-size:small">{{ $detail->productStock->weight }}</td>   --}}
                <td align="right" style="width:9%; font-size:small">{{ number_format($detail->product_unit_qty,2) }}</td>  
                <td align="right" style="width:9%; font-size:small">Ratti</td>  
                {{-- <td align="left" style="width:10%; font-size:small">Ratti</td>   --}}
                <td align="right" style="width:9%; font-size:small">{{ $detail->product_unit_rate }}</td>  
                <td align="right" style="width:13%; font-size:small">{{ number_format($detail->product_amount,2) }}</td>  
            </tr>  
            @endforeach
            
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
                <td align="left" style="width: 50%; font-size:small"></td>  
                <td align="left" style="width: 25%; font-size:small">Total  Amount</td>  
                <td align="right" style="width: 25%; font-size:small">{{ number_format($ledger->amount,2) }}</td>  
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
                <td align="left" style="width: 50%; font-size:small"></td>  
                <td align="left" style="width: 20%; font-size:small">Discount</td>  
                <td align="right" style="width: 15%; font-size:small">{{ $ledger->ledgerDetails[0]->discount->rate ?? 0}} % (-)</td>  
                <td align="right" style="width: 15%; font-size:small">{{ number_format( $ledger->discount_amount,2) ?? "" }}</td>  
            </tr>
            <tr>
                <td align="left" style="width: 50%; font-size:small"></td>  
                <td align="left" style="width: 20%; font-size:small">GST (Inclusive) 0.25%-3%-5%</td>  
                <td align="right" style="width: 15%; font-size:small">(+)</td>  
                <td align="right" style="width: 15%; font-size:small">{{ $ledger->tax_amount ?? 0 }}</td>  
            </tr>
            {{-- <tr>
                <td align="left" style="width: 50%; font-size:small"></td>  
                <td align="left" style="width: 20%; font-size:small">Round Off ()</td>  
                <td align="right" style="width: 15%; font-size:small">(-)</td>  
                <td align="right" style="width: 15%; font-size:small">
                @php
                   $whole = intval($ledger->total_amount);
                   $decimal = $ledger->total_amount - $whole;
                    
                @endphp
                  {{ $decimal }}
            </td>  
            </tr>   --}}
        </table>
    </div>
    <div class="information">
        <table width="100%"  style="padding:0%">
            <tr>
                <td align="left" style="width: 50%; font-size:small"></td>  
                <td align="left" style="width: 20%; font-size:small">Net Amount</td>  
                <td align="right" style="width: 15%; font-size:small"></td>  
                <td align="right" style="border-top:1px solid black; width: 15%; font-size:small">{{ number_format($ledger->total_amount,2) }}</td>  
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
                <td align="left" style="width: 100%; font-size:x-small">Amount in Words:  {{ucwords($ledger->convertNumberToWord($ledger->getAmountAfterDiscount( $ledger->discountAmountForStore($ledger->userReceipt->id,$ledger->total_amount),$ledger->total_amount))) }}</td>  
            </tr>  
        </table>
    </div>
    
    <div class="information">
        <table width="100%"  style="padding:0%"> 
            <tr>
                <td align="left" style="width: 100%; font-size:small">Note: No E-way Bill is required to be generated as the Goods covered under this Challan Exempted as per Serial No.150/151 to the Annexure to Rule 138(14) of the CGST Rules.</td>  
            </tr> 
        </table>
    </div>
    <div class="information">
        <table width="100%"  style="padding:0%"> 
            <tr>
                <td align="left" style="width: 50%; font-size:small">&nbsp;</td>  
                <td align="right" style="width: 50%; font-size:small;">For Gemlab Laboratories</td>  
            </tr> 
            
        </table>
    </div>
    <div class="information">
        <table width="100%"  style="padding:0%"> 
            <tr>
                <td align="left" style="width: 50%; font-size:small">Audit________Dt : ________</td>  
            </tr>  
        </table>
    </div> 
    <div class="information">
        <table width="100%"  style="padding:0%"> 
            <tr>
                <td align="right" style="width: 100%; font-size:small">Auth Signatory</td>     
            </tr>  
            <tr>
                <td align="left" style="width: 100%; font-size:small">Received By : {{ $ledger->userReceipt->name ?? "" }}  Checked By_______________  Issued By : {{ $ledger->userIssue->name ?? "" }}</td>     
            </tr>  
        </table>
    </div>


{{-- 



    <div class="information">
        <table width="100%">
            <tr>
                <td align="center" style="width: 40%;">
                    <h3>John Doe</h3> <pre>
    Street 15
    123456 City
    United Kingdom
    <br /><br />
    Date: 2018-01-01
    Identifier: #uniquehash
    Status: Paid
    </pre> </td>
                <td align="center"> <img src="/path/to/logo.png" alt="Logo" width="64" class="logo" /> </td>
                <td align="right" style="width: 40%;">
                    <h3>CompanyName</h3> <pre>
                        https://company.com
    
                        Street 26
                        123456 City
                        United Kingdom
                    </pre> </td>
            </tr>
        </table>
    </div>
    <br/>
    <div class="invoice">
        <h3>Invoice specification #123</h3>
        <table width="100%">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Item 1</td>
                    <td>1</td>
                    <td align="left">€15,-</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1"></td>
                    <td align="left">Total</td>
                    <td align="left" class="gray">€15,-</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="information" style="position: absolute; bottom: 0;">
        <table width="100%">
            <tr>
                <td align="left" style="width: 50%;"> &copy; {{ date('Y') }} {{ config('app.url') }} - All rights reserved. </td>
                <td align="right" style="width: 50%;"> Company Slogan </td>
            </tr>
        </table>
    </div> --}}
</body>
</html>