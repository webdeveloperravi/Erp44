<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - #123</title>
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
                <td align="center" style="width: 100%; font-size:small">GemLab Laboratories</td> 
            </tr>
            <tr>
                <td align="center" style="width: 100%; font-size:small">59-Krishna Square, Amritsar-143001 INDIA</td> 
            </tr>
            <tr>
                <td align="center" style="width: 100%; font-size:small">>> Opening Stock<< &nbsp;</td> 
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
                <td align="left" style="width: 50%; font-size:small">Voucher No : {{ $ledger->voucher_number ?? "" }}</td> 
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
                <td align="left" style="width:20%; font-size:small">Gin</td>  
                <td align="left" style="width:20%; font-size:small">Product</td>  
                <td align="left" style="width:20%; font-size:small">Grade</td>  
                <td align="left" style="width:20%; font-size:small">Ratti</td>  
                <td align="left" style="width:20%; font-size:small">Amount</td>     
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
                <td align="left" style="width:20%; font-size:small">{{ $detail->productStock->gin ?? "" }}</td>  
                <td align="left" style="width:20%; font-size:small">{{ $detail->productStock->product->name }}</td>  
                <td align="left" style="width:20%; font-size:small">{{ $detail->productStock->productGrade->alias }}</td>  
                <td align="left" style="width:20%; font-size:small">{{ $detail->productStock->ratti->rati_standard }}+</td>  
               <td align="left" style="width:20%; font-size:small">{{ number_format($detail->product_amount,2) }}</td>  
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
      {{-- <div class="information">
        <table width="100%"  style="padding:0%"> 
            <tr>
                <td align="left" style="width: 50%; font-size:small"></td>  
                <td align="left" style="width: 25%; font-size:small">Total  Amount</td>  
                <td align="right" style="width: 25%; font-size:small">{{ number_format($ledger->countTotalAmount($ledger->id),2) }}</td>  
            </tr> 
        </table>
    </div> 
     --}}
 
    <script>
        window.addEventListener("load", function(){
   print();
});
    </script>
</body>

</html>