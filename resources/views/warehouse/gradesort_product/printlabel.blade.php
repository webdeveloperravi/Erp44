<html>
    <head>
      <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <!-- Latest compiled and minified CSS -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
         {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet"> --}}
 <style>
      
        
        /* @media print {
    #hidebtn {
        display: none;
    }
} */
body{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 3.5mm;
}
/* div{
    padding: 0px;
    margin: 0px;
} */
 @page { 
     size: 60mm 40mm; 
     max-width: 60mm;  
      max-height: 40mm;
     margin: 0mm;
     padding:0mm;
     
     }
        
    </style>
    </head>
    <body class="m-0 p-0"> 
 @foreach ($products  as $item)
 <div class="p-0 m-0 " style="max-height:40mm;  max-width:60mm; padding-left:2mm !important; ">
          <span class="d-block ">Sku :</span>
          <span class="d-block" >{{ $item->product->alias }}</span> 
          <span class="d-block" >Grade : {{ $item->grade->grade->alias }} </span> 
          <span class="d-block" >Ratti : </span> 
          <span class="d-block" >Weight :</span>  
          <span class="d-block " ><img style="max-width: 40mm;" src="data:image/png;base64,{{DNS1D::getBarcodePNG('1234', 'C128A')}}"></span>  
            
        </div>
@endforeach  
</body>
</html> 