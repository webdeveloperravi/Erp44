@extends('layouts.store.appWithoutModules')
@section('content') 
           <style>
               body{
                   font-size: 5px !important;
               }
               th{
                   text-align: left !important;
               }
               td{
                   text-align: left !important;
               }
 

 td,  th {
  border: 1px solid #ddd;
  padding: 8px;
}

 tr:nth-child(even){background-color: #f2f2f2;}

 tr:hover {background-color: #ddd;}

 th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
  font-size: 0.5rem;
}

   @media print {
      #printArea{
          padding: 20px;
          width: 100%;
          max-width: 100%;
          height: auto;
          overflow: visible;
          font-size: 5px;
       }
       *{
        font-size: 12pt; 
       }

      td{
          padding: 1px;
          margin: 1px;
      }

      th{
          padding: 1px;
          margin: 1px;
      }
      table.report { page-break-after:auto }
  table.report tr    { page-break-inside:avoid; page-break-after:auto }
  table.report td    { page-break-inside:avoid; page-break-after:auto }
  table.report thead { display:table-header-group }
  table.report tfoot { display:table-footer-group }

}
 } 
 .table thead th,
.jsgrid .jsgrid-table thead th { 
  font-size: 0.5rem !important; 
}

@page {
    margin: 0px;
    size: 215mm 275mm landscape;
}
</style>
<body>
    
    <div id="printArea">
        @foreach ($products as $product)
 @if (!empty($data[$product['id']]))
 <h3>{{ $product->alias }}</h3>
 <div class="table-responsive">
     <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
        <thead> 
            <tr>
                <th>G/R</th>
                @php
                    $rattis = $product->getUniqueRattis($product->id,$productStockIds)
                    @endphp
                    
            @foreach ($rattis as $ratti) 
            <th>

                    {{ $ratti->rati_standard }}+          
                </th>
                @endforeach
            </tr>  
            @foreach ($product->getUniqueGrades($product->id,$productStockIds) as $grade) 
            <tr>
                <td>{{ $grade->alias }}</td>
                @if (!empty($data[$product['id']][$grade['id']]))
                @foreach ($rattis as $ratti) 
                 @if (!empty($data[$product['id']][$grade['id']][$ratti['id']]))
                        <td>{{ count($data[$product['id']][$grade['id']][$ratti['id']]) }}</td>
                @else 
                <td></td>
                @endif
                 @endforeach
                 @else 
            <td></td>
            @endif 
        </tr>
         @endforeach   
        </thead>
        <tbody> 
        </tbody>
    </table>
</div>
</div>
</body>
@endif
@endforeach 
@endsection 