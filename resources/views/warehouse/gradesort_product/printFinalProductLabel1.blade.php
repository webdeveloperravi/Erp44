<html>
    <head>
      <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <!-- Latest compiled and minified CSS -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
         {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet"> --}}
 <style>
      
 
body{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 2mm;
}
/* div{
    padding: 0px;
    margin: 0px;
} */
 
 @page { 
     size: 67mm 28mm; 
     max-width: 67mm;  
      max-height: 28mm;
     margin: 0mm;
     padding:0mm;
     
     }
        
</style>
</head>
<body class="m-0 p-0" >  
    @foreach ($products as $product)
    {{-- @foreach (\App\Model\Warehouse\InvoiceDetailGradeProduct::where(['invoice_detail_grade_packet_id'=>2,'final'=>1])->get(); as $product) --}}
    <div style="position: relative; left:0mm; right:0mm; max-width:67mm; min-height:28mm;max-height:28mm;">
    <div style="position: relative; left:15mm; right : 15mm; max-width:37mm;min-height:14mm;max-height:13mm; border-bottom:0.1mm solid black;display:block">
        <span style="font-weight: 600; font-size:3mm;">{{ $product->product->alias }}</span><br>
         <div style="position: relative;left:0mm; right:5mm;min-width:18mm; max-width:18mm;  display: inline-block;">
                <span>Length : {{ $product->length }}mm</span><br>
                <span>Width : {{ $product->width }}mm</span><br>
                <span>Depth : {{ $product->depth }}mm</span><br>
         </div>
         <div style="position: relative;left:0mm; right:5mm;min-width:18mm;max-width:18mm;  display: inline-block;">
             {{-- <span></span><br> --}}
            <span>Weight : {{ $product->weight }}mg</span><br>
            <span>Standard : {{ $product->ratti->rati_standard }}+</span><br>
            <span>Big : {{ $product->ratti->rati_big }}+</span><br>
         </div>
    </div> 
    <div style="position: relative; left:15mm; right : 15mm; max-width:37mm;min-height:13mm;max-height:13mm;  ">
            <div style="position: relative;left:0mm; right:5mm;min-width:18mm; max-width:18mm;  display: inline-block;"> 
                <span> MRP Rs.{{ App\Helpers\Helper::getProductPrice($product->weight,App\Helpers\Helper::getRateProfile($product->product_id,$product->grade_id)) ?? "Null"}}/- &nbsp;</span><br> 
            </div>
            <div style="position: relative;left:0mm; right:5mm;min-width:18mm;max-width:18mm;  display: inline-block;">
                <span>C-2{{ $product->weight }}mg-{{ $product->ratti->rati_standard }}+-{{ App\Helpers\Helper::getProductRattiRate($product->weight,App\Helpers\Helper::getRateProfile($product->product_id,$product->grade_id)) ?? "Null"}}</span><br> 
            </div> 
         <div style="position: relative;left:0mm; right:5mm;min-width:13mm; max-width:13mm;  display: inline-block;">
         </div>
         <div style="position: relative;left:0mm; right:5mm;min-width:18mm;max-width:18mm;  display: inline-block;">
            <span> <img style="max-width: 22mm;" src="data:image/png;base64,{{DNS1D::getBarcodePNG('123456789', 'C128A')}}"> </span>
         </div> 
         <div style="position: relative;left:0mm; right:5mm;min-width:13mm; max-width:13mm;  display: inline-block;">
         </div>
         <div style="position: relative;left:0mm; right:5mm;min-width:18mm;max-width:18mm;  display: inline-block;">
            <div style="position: relative;left:0mm; right:5mm;min-width:5mm;max-width:18mm;  display: inline-block;">
                <span style="font-size: 3mm;font-weight:600;">{{ $product->productGrade->alias }}</span>
            </div> 
            <div style="position: relative;left:0mm; right:5mm;min-width:5mm;max-width:18mm;  display: inline-block;">
                <span style="position:relative;top:-5;">{{ $product->gin }}</span>
            </div> 
         </div> 
    </div>
    </div> 
     
    @endforeach
 <script>
 window.print();
 </script>
</body>
</html> 