<html>
    <head>
      <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <!-- Latest compiled and minified CSS -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
         {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet"> --}}
 <style>
      
        
        @media print {
    
}
body{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 2mm;
}
/* div{
    padding: 0px;
    margin: 0px;
} */
 
 @page { 
     size: 70mm 30mm; 
     max-width: 70mm;  
      max-height: 30mm;
     margin: 0mm;
     padding:0mm;
     
     }
        
</style>
</head>
<body class="m-0 p-0" > 
{{-- <div class="p-0 m-0 " style="max-height:28mm; min-width:67mm; max-width:67mm;">
    <div class="p-0 m-0 " style="max-height:28mm; min-width:15mm !important; max-width:15mm;"> </div>
    <div class="p-0 m-0 margin-15mm" style="max-height:14mm; min-width:37mm; max-width:37mm;">
        <div class="p-0 m-0 " style="max-height:14mm; min-width:18mm; max-width:18mm;">
            <span class="d-block" >Sku :</span>
        </div>
        <div class="p-0 m-0 " style="max-height:14mm; min-width:18mm; max-width:18mm;">
            <span class="d-block" >Sku :</span>
        
        </div>
    </div>
    <div class="p-0 m-0 " style="max-height:28mm; min-width:15mm; max-width:15mm;"> </div>
</div> --}}
<div style="position: relative; left:0mm; right:0mm; max-width:67mm; min-height:28mm;max-height:28mm;">
<div style="position: relative; left:15mm; right : 15mm; max-width:37mm;min-height:14mm;max-height:14mm; border-bottom:0.1mm solid black;">
     <div style="position: relative;left:0mm; right:5mm;min-width:18mm; max-width:18mm;  display: inline-block;">
            <span style="font-weight: 600; font-size:3mm;">Pearl</span><br>
            <span>Length : 5mm</span><br>
            <span>Length : 5mm</span><br>
            <span>Depth : 5mm</span><br>
     </div>
     <div style="position: relative;left:0mm; right:5mm;min-width:18mm;max-width:18mm;  display: inline-block;">
         <span></span><br>
        <span>Weight : 200mg</span><br>
        <span>Standard : 1+</span><br>
        <span>Big : 2+</span><br>
     </div>
</div>
<div style="position: relative; left:15mm; right : 15mm; max-width:37mm;min-height:14mm;max-height:14mm;  ">
        <div style="position: relative;left:0mm; right:5mm;min-width:18mm; max-width:18mm;  display: inline-block;">
            <span> MRP Rs.22000/- &nbsp;</span><br> 
        </div>
        <div style="position: relative;left:0mm; right:5mm;min-width:18mm;max-width:18mm;  display: inline-block;">
            <span>C-200mg-1+-1100</span><br> 
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
            <span style="font-size: 3mm;font-weight:600;">N</span>
        </div> 
        <div style="position: relative;left:0mm; right:5mm;min-width:5mm;max-width:18mm;  display: inline-block;">
            <span style="position:relative;top:-5;">123456789</span>
        </div> 
     </div> 
</div>
</div>




 {{-- @foreach ($products  as $item)
 <div class="p-0 m-0 " style="max-height:28mm;  max-width:15mm;">
          <span class="d-block" >Sku :</span>
          <span class="d-block" >{{ $item->product->alias }}</span> 
          <span class="d-block" >Grade : {{ $item->grade->grade->alias }} </span> 
          <span class="d-block" >Ratti : </span> 
          <span class="d-block" >Weight :</span>  
          <span class="d-block " ><img style="max-width: 28mm;" src="data:image/png;base64,{{DNS1D::getBarcodePNG('1234', 'C128A')}}"></span>  
</div>
 <div class="p-0 m-0 " style="max-height:28mm;  max-width:37mm; ">
          <span class="d-block" >Sku :</span>
          <span class="d-block" >{{ $item->product->alias }}</span> 
          <span class="d-block" >Grade : {{ $item->grade->grade->alias }} </span> 
          <span class="d-block" >Ratti : </span> 
          <span class="d-block" >Weight :</span>  
          <span class="d-block " ><img style="max-width: 28mm;" src="data:image/png;base64,{{DNS1D::getBarcodePNG('1234', 'C128A')}}"></span>  
</div>
 <div class="p-0 m-0 " style="max-height:28mm;  max-width:37mm;  ">
          <span class="d-block" >Sku :</span>
          <span class="d-block" >{{ $item->product->alias }}</span> 
          <span class="d-block" >Grade : {{ $item->grade->grade->alias }} </span> 
          <span class="d-block" >Ratti : </span> 
          <span class="d-block" >Weight :</span>  
          <span class="d-block " ><img style="max-width: 28mm;" src="data:image/png;base64,{{DNS1D::getBarcodePNG('1234', 'C128A')}}"></span>  
</div>
@endforeach   --}}
</body>
</html> 