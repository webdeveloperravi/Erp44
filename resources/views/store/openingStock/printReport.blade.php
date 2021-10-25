<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Opening_Stock_{{ $ledger->voucher_number ?? "" }}</title>
    {{-- <link href="http://fonts.cdnfonts.com/css/sugarcubes" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hepta+Slab:wght@200;300;400&display=swap" rel="stylesheet">
    <style type="text/css">
        @page {
            margin: 0px;
        }
        body {
            margin-left: 30px;
            margin-right: 30px;
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
                <td align="center" style="width: 100%; font-size:small">{{ $ledger->storeReceipt->company_name ?? "" }}</td> 
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
                <td align="center" style="width: 100%; font-size:small">>> {{ $ledger->voucher->name ?? "" }}<< &nbsp;</td> 
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
                <td align="left" style="width: 50%; font-size:small">Opening Stock No : {{ $ledger->voucher_number ?? "" }}</td> 
                <td align="right" style="width: 50%; font-size:small">Date  
                    {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ledger->created_at)->isoFormat('DD-MM-YYYY') }}</td> 
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
                <td align="left" style="width: 100%; font-size:small">{{ $ledger->userReceiptOpeningStock->company_name }}</td>  
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
                <td align="left" style="width:5%; font-size:small">Sr.No.</td>  
                <td align="left" style="width:24%; font-size:small">Item Name</td>  
                <td align="left" style="width:9%; font-size:small">Gin</td>  
                <td align="left" style="width:13%; font-size:small">HSN Code</td>  
                <td align="left" style="width:9%; font-size:small">Wt./Mg</td>   
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
            @if ($type == 'scan')
            @foreach ($ledgerDetails->sortBy('id') as $detail)
            <tr>
                <td align="left" style="width:5%; font-size:small">{{ $loop->iteration }}</td>
                <td align="left" style="width:24%; font-size:small">{{ $detail->productStock->product->name }}-{{ $detail->productStock->productGrade->alias }}-{{ $detail->productStock->ratti->rati_standard }}+ </td>  
                <td align="left" style="width:9%; font-size:small">{{ $detail->productStock->gin ?? "" }}</td>  
                <td align="left" style="width:13%; font-size:small">{{ $detail->productStock->product->hsnCode->hsn_code ?? "" }}</td>  
                <td align="left" style="width:9%; font-size:small">{{ $detail->productStock->weight }}</td>  
                <td align="left" style="width:9%; font-size:small">{{ number_format($detail->product_unit_qty,2) }}</td>  
                <td align="left" style="width:9%; font-size:small">Ratti</td>  
                {{-- <td align="left" style="width:10%; font-size:small">Ratti</td>   --}}
                <td align="right" style="width:9%; font-size:small">{{ $detail->product_unit_rate }}</td>  
                <td align="right" style="width:13%; font-size:small">{{ number_format($detail->product_amount,2) }}</td>  
            </tr>  
            @endforeach
           @endif

         
            @if ($type == 'pgr')
            

            @foreach ($ledgerDetails->sortBy('product_unit_qty')->sortBy('productStock.productGrade.alias')->sortBy('productStock.product.name') as $detail)
            <tr>
                <td align="left" style="width:5%; font-size:small">{{ $loop->iteration }}</td>
                <td align="left" style="width:24%; font-size:small">{{ $detail->productStock->product->name }}-{{ $detail->productStock->productGrade->alias }}-{{ $detail->productStock->ratti->rati_standard }}+ </td>  
                <td align="left" style="width:9%; font-size:small">{{ $detail->productStock->gin ?? "" }}</td>  
                <td align="left" style="width:13%; font-size:small">{{ $detail->productStock->product->hsnCode->hsn_code ?? "" }}</td>  
                <td align="left" style="width:9%; font-size:small">{{ $detail->productStock->weight }}</td>  
                <td align="left" style="width:9%; font-size:small">{{ number_format($detail->product_unit_qty,2) }}</td>  
                <td align="left" style="width:9%; font-size:small">Ratti</td>  
                {{-- <td align="left" style="width:10%; font-size:small">Ratti</td>   --}}
                <td align="right" style="width:9%; font-size:small">{{ $detail->product_unit_rate }}</td>  
                <td align="right" style="width:13%; font-size:small">{{ number_format($detail->product_amount,2) }}</td>  
            </tr>  
            @endforeach
         
            @endif
        </table>
    </div>
    
    <div class="information">
        <table width="100%"  style="padding:0%">
            <tr>
                <hr>
            </tr>
        </table>
    </div> 
    <script>
        window.addEventListener("load", function(){
   print();
});
    </script>
</body>

</html>