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
                <td align="center" style="width: 100%; font-size:small">GemLab Laboratories</td> 
            </tr>
            <tr>
                <td align="center" style="width: 100%; font-size:small">59-Krishna Square, Amritsar-143001 INDIA</td> 
            </tr>
            <tr>
                <td align="center" style="width: 100%; font-size:small">>> Delivery Challan<< &nbsp;</td> 
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
                <td align="left" style="width: 50%; font-size:small">Bill No : 1402</td> 
                <td align="right" style="width: 50%; font-size:small">Date 15-07-2021</td> 
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
                <td align="left" style="width: 100%; font-size:small">DL-PADAMNAGAR-NEW-KHANDEWAL-JEWELLERS-S-17</td>  
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
                <td align="left" style="width: 13%; font-size:small">Spc Info</td>  
                <td align="center" style="width: 5%; font-size:small">:</td>  
                <td align="left" style="width:75%; font-size:small">RET-255</td>  
            </tr> 
            <tr>
                <td align="left" style="width: 13%; font-size:small">Dealer Name</td>  
                <td align="center" style="width: 5%; font-size:small">:</td>  
                <td align="left" style="width:75%; font-size:small">KHANDEWAL JEW</td>  
            </tr> 
            <tr>
                <td align="left" style="width: 13%; font-size:small">Delivery Place</td>  
                <td align="center" style="width: 5%; font-size:small">:</td>  
                <td align="left" style="width:75%; font-size:small">PADAMNAGAR</td>  
            </tr> 
            <tr>
                <td align="left" style="width: 13%; font-size:small">Supply Place</td>  
                <td align="center" style="width: 5%; font-size:small">:</td>  
                <td align="left" style="width:75%; font-size:small">PB</td>  
            </tr> 
            <tr>
                <td align="left" style="width: 13%; font-size:small">HSN Code</td>  
                <td align="center" style="width: 5%; font-size:small">:</td>  
                <td align="left" style="width:75%; font-size:small">7103</td>  
            </tr> 
            <tr>
                <td align="left" style="width: 13%; font-size:small">Through</td>  
                <td align="center" style="width: 5%; font-size:small">:</td>  
                <td align="left" style="width:75%; font-size:small">HARSH VERMA</td>  
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
                <td align="left" style="width:20%; font-size:small">Item Name</td>  
                <td align="left" style="width:15%; font-size:small">Item Code</td>  
                <td align="left" style="width:10%; font-size:small">Quantity</td>  
                <td align="left" style="width:10%; font-size:small">Unit</td>  
                <td align="right" style="width:15%; font-size:small">Rate</td>  
                <td align="right" style="width:15%; font-size:small">Amount</td>  
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
                <td align="left" style="width:20%; font-size:small">Emerald-N-8+</td>  
                <td align="left" style="width:15%; font-size:small">11324668</td>  
                <td align="right" style="width:10%; font-size:small">8.33</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">525.00</td>  
                <td align="right" style="width:15%; font-size:small">4373.25</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small">Emerald-N-9+</td>  
                <td align="left" style="width:15%; font-size:small">11324167</td>  
                <td align="right" style="width:10%; font-size:small">9.50</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">525.00</td>  
                <td align="right" style="width:15%; font-size:small">4987.50</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small">Emerald-N-9+</td>  
                <td align="left" style="width:15%; font-size:small">11294135</td>  
                <td align="right" style="width:10%; font-size:small">10.50</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">525.00</td>  
                <td align="right" style="width:15%; font-size:small">5512.50</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small">Emerald-N-9+</td>  
                <td align="left" style="width:15%; font-size:small">11312207</td>  
                <td align="right" style="width:10%; font-size:small">8.00</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">125.00</td>  
                <td align="right" style="width:15%; font-size:small">1000.00</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small">Emerald-N-9+</td>  
                <td align="left" style="width:15%; font-size:small">11312591</td>  
                <td align="right" style="width:10%; font-size:small">9.67</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">125.00</td>  
                <td align="right" style="width:15%; font-size:small">1208.75</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small">Emerald-N-9+</td>  
                <td align="left" style="width:15%; font-size:small">11323395</td>  
                <td align="right" style="width:10%; font-size:small">9.00</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">125.00</td>  
                <td align="right" style="width:15%; font-size:small">1125.00</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small">Emerald-N-9+</td>  
                <td align="left" style="width:15%; font-size:small">11304054</td>  
                <td align="right" style="width:10%; font-size:small">10.67</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">125.00</td>  
                <td align="right" style="width:15%; font-size:small">1333.75</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small">Emerald-N-9+</td>  
                <td align="left" style="width:15%; font-size:small">11314661</td>  
                <td align="right" style="width:10%; font-size:small">8.42</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">125.00</td>  
                <td align="right" style="width:15%; font-size:small">1052.50</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small">Emerald-N-9+</td>  
                <td align="left" style="width:15%; font-size:small">11314703</td>  
                <td align="right" style="width:10%; font-size:small">9.00</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">125.00</td>  
                <td align="right" style="width:15%; font-size:small">1125.00</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small">Emerald-N-9+</td>  
                <td align="left" style="width:15%; font-size:small">11305350</td>  
                <td align="right" style="width:10%; font-size:small">9.08</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">125.00</td>  
                <td align="right" style="width:15%; font-size:small">1135.00</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small">Emerald-N-9+</td>  
                <td align="left" style="width:15%; font-size:small">11305574</td>  
                <td align="right" style="width:10%; font-size:small">10.67</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">125.00</td>  
                <td align="right" style="width:15%; font-size:small">1333.75</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small">Emerald-N-9+</td>  
                <td align="left" style="width:15%; font-size:small">11305566</td>  
                <td align="right" style="width:10%; font-size:small">10.67</td>  
                <td align="left" style="width:10%; font-size:small">Ratti</td>  
                <td align="right" style="width:15%; font-size:small">125.00</td>  
                <td align="right" style="width:15%; font-size:small">1333.75</td>  
            </tr>  
            <tr>
                <td align="left" style="width:20%; font-size:small"></td>  
                <td align="left" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:10%; font-size:small">1.00</td>  
                <td align="left" style="width:10%; font-size:small">Pcs.</td>  
                <td align="right" style="width:15%; font-size:small"></td>  
                <td align="right" style="width:15%; font-size:small"></td>  
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
                <td align="left" style="width: 25%; font-size:small">Total  Amount</td>  
                <td align="right" style="width: 25%; font-size:small">25520.75</td>  
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
                <td align="right" style="width: 15%; font-size:small">17.00 % (-)</td>  
                <td align="right" style="width: 15%; font-size:small">4338.53</td>  
            </tr>
            <tr>
                <td align="left" style="width: 50%; font-size:small"></td>  
                <td align="left" style="width: 20%; font-size:small">GST 0.25%-3%-5%</td>  
                <td align="right" style="width: 15%; font-size:small">(-)</td>  
                <td align="right" style="width: 15%; font-size:small">0.00</td>  
            </tr>
            <tr>
                <td align="left" style="width: 50%; font-size:small"></td>  
                <td align="left" style="width: 20%; font-size:small">Round Off (-)</td>  
                <td align="right" style="width: 15%; font-size:small">(-)</td>  
                <td align="right" style="width: 15%; font-size:small">0.22</td>  
            </tr>  
        </table>
    </div>
    <div class="information">
        <table width="100%"  style="padding:0%">
            <tr>
                <td align="left" style="width: 50%; font-size:small"></td>  
                <td align="left" style="width: 20%; font-size:small">Net Amount</td>  
                <td align="right" style="width: 15%; font-size:small"></td>  
                <td align="right" style="border-top:1px solid black; width: 15%; font-size:small">21182.00</td>  
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
                <td align="left" style="width: 100%; font-size:x-small">Amount in Words: Rupees Twenty One Thousand One Hundred Eighty Two only</td>  
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
                <td align="left" style="width: 100%; font-size:small">GST Number : 03AVCPS7931B1ZU</td>  
            </tr> 
            
        </table>
    </div>
    <div class="information">
        <table width="100%"  style="padding:0%"> 
            <tr>
                <td align="left" style="width: 50%; font-size:small">Audit________Dt : ________</td>  
                <td align="right" style="width: 50%; font-size:small;">For Gemlab Laboratories</td>  
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