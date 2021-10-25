{{-- @extends('layouts.store.app')
@section('css')
<style>
   th {
   text-align: left !important;
   }
</style>
@endsection
@section('content')
<div class="row">
<div class="col">
  <a href="{{route('receiveChallan.index')}}" class="btn btn-inverse btn-sm  m-2">Back</a>
</div>
</div>  
<div class="card">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Challan Details #{{$receiveChallan->voucher_number ?? ''}}</h5>
     </div>
    
    <div class="card-body"> 
    <div class="row">

    <div class="col col-md-6">

    <div class="row">
      
      <div class="col col-md-3">
        <img src="{{ asset('public/images/lead-images/abc.jpg') }}" alt="" class="img-fluid img-thumbnail" width="100">
      </div>

      <div class="col-md-9">
      <h6>To : <span>{{$receiveChallan->userIssue->name ?? ''}}</span></h6>
      <h6>Date : <span>  {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $receiveChallan->created_at)->isoFormat('DD-MM-YYYY') }}</span></h6>
    
      </div>

     </div>
    </div>
 </div>

  <ul class="nav nav-tabs m-2" role="tablist" >
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#nav_orderDetails"  onclick="orderDetails()">OrdreDetails</a>
    </li>
   
   
  </ul>

 
  <div class="tab-content">
    <div id="nav_orderDetails" class="container tab-pane active"><br>
        <div class="card-body">
            @if (!empty($receiveChallan->ledgerDetails))
     <div class="table-responsive">
     <table class="table" id="example" style="width:100">
         <thead>
         <tr>
             <th>Sr.</th> 
             <th>GIN</th> 
             <th>Product</th>
             <th>Grade</th>
             <th>Exact Ratti</th>
             <th>Amount</th>
            <!--  <th>Qty.</th> 
             <th>Left Qty.</th>  -->
         </tr>
     </thead>
     <tbody>
     @foreach($receiveChallan->ledgerDetails as $product)
     <tr>
         <td>{{$loop->iteration}}</td> 
         <td>{{ $product->productStock->gin }}</td> 
         <td>{{ $product->productStock->product->alias }}</td>  
         <td>{{ $product->productStock->productGrade->alias }}</td>  
         <td>{{ $product->product_unit_qty }}</td> 
         <td>{{amountFormat($product->total_amount) }}</td>
       
     </tr>
     @endforeach
     <tr>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       <td>Total Amount</td>
       <td>{{ amountFormat($receiveChallan->total_amount) }}</td> 
     </tr>
     </tbody>
     </table>
 </div>
 @else 
  <div class="card-body">
             <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
            </div>
 @endif
 </div>
</div>
    

  </div>



</div> 
</div> 

 
@endsection
  --}}




@extends('layouts.store.app')
@section('css')
<style>
   th {
   text-align: left !important;
   }
</style>
@endsection
@section('content')
<div class="row">
<div class="col">
  <a href="{{route('receiveChallan.index')}}" class="btn btn-inverse btn-sm  m-2">Back</a>
</div>
</div>  
<div class="card">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Receive Challan Details #{{$receiveChallan->voucher_number ?? ''}}</h5>
     </div>
    
    <div class="card-body"> 
    <div class="row">

    <div class="col col-md-6">

    <div class="row">
      
      <div class="col col-md-3">
        <img src="{{ asset('public/images/lead-images/abc.jpg') }}" alt="" class="img-fluid img-thumbnail" width="100">
      </div>

      <div class="col-md-9">
        @if ($receiveChallan->userIssue->type == 'org' || $receiveChallan->userIssue->type == 'lab')
        <h6>From : <span>{{$receiveChallan->userIssue->company_name ?? ''}}</span></h6>
        @endif
        @if ($receiveChallan->userIssue->type == 'user')
        <h6>From : <span>{{$receiveChallan->userIssue->name ?? ''}}</span></h6>
        @endif
      <h6>Date : <span>  {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $receiveChallan->created_at)->isoFormat('DD-MM-YYYY') }}</span></h6>
    
      </div>

     </div>
    </div>
 </div> 
  @if (!empty($receiveChallan->ledgerDetails))
  <div class="table-responsive">
    <table class="table" id="table_id2" style="width:100">
<thead>
<tr>
   <th>Sr.</th> 
   <th>GIN</th> 
   <th>Product</th>
   <th>Grade</th>
   <th>Exact Ratti</th>
   <th>Amount</th> 
</tr>
</thead>
<tbody>
@foreach($receiveChallan->ledgerDetails as $product)
<tr>
<td>{{$loop->iteration}}</td> 
<td>{{ $product->productStock->gin }}</td>  
<td>{{ $product->productStock->product->alias }}</td>  
<td>{{ $product->productStock->productGrade->alias }}</td>  
<td>{{ $product->product_unit_qty }}</td> 
<td>{{ amountFormat($product->total_amount) }} </td>

</tr>
@endforeach
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td>Total Amount</td>
<td>{{ amountFormat($receiveChallan->total_amount) ?? "" }}</td> 
</tr>
</tbody>
<tfoot>
  <tr>
    <th>Sr.</th> 
    <th>GIN</th> 
    <th>Product</th>
    <th>Grade</th>
    <th>Exact Ratti</th>
    <th>Amount</th> 
 </tr>
</tfoot>
</table>
</div>
@else 
<div class="card-body">
   <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
  </div>
@endif  
</div> 
</div> 
<div class="card">  
  <div class="card-footer p-0" style="background-color: #04a9f5">
     <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;"> Images</h5>
  </div>
  <div class="row">
     @if($receiveChallan->mediaImages->count() == 0)
      <div class="col-lg-12 col-sm-12">
      <div class="jumbotron text-center">
        <h2 class="text-center "><i class="fa fa-inbox "></i>&nbsp; Empty</h2>
         <a class="btn btn-dark mt-3" href="{{ route('ledgerMedia.index',$receiveChallan->id) }}">Click to Upload Images</a>
      </div>
     </div>
     @else
      @foreach ($receiveChallan->mediaImages as $image)
      <div class="col-lg-3 col-md-3 col-sm-6">
          <div class="thumbnail">
           <div class="thumb"> 
              <a href="{{ asset('public/'.$image->url.$image->name) }}" data-lightbox="1" data-title="">
                  <img src="{{ asset('public/'.$image->url.$image->name) }}" alt="" class="img-fluid img-thumbnail">
                  </a>
          </div>
          </div>
          
          </div>
      @endforeach 
      <div class="col-md-12">
        <div class="jumbotron text-center"> 
           <a class="btn btn-dark mt-3" href="{{ route('ledgerMedia.index',$receiveChallan->id) }}">Click to Upload More Images</a>
        </div>
      </div>
      @endif
</div> 
</div> 
@endsection
@section('script')
    
<script> 
  $(document).ready(function() {
    $('#table_id2 tfoot th').each(function() {
      var title = $(this).text();
      $(this).html('<input type="text" placeholder="Search ' + title + '" />');
     });
     var cardTitle = "Sale Challans All";
     var columns = [0, 1, 2, 3, 4, 5];
    // DataTable
    var authUserId = "{{ auth('store')->user()->id ?? __}}";
    var authUserName = "{{ auth('store')->user()->name ?? __}}";
    var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
    var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
    var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
  var messageTop2 =`Report from UID : ` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
    var table = $('#table_id2').DataTable({
      dom: 'Bfrtip',
      buttons: [{
        extend: 'excelHtml5',
        exportOptions: {
          columns: columns,
        },
        text: 'Export Excel',
        title: cardTitle,
      }, {
        extend: 'pdfHtml5',
        download: 'open',
        exportOptions: {
          columns: columns,
        },
        text: 'Export Pdf',
        title: cardTitle,
        orientation: 'landscape',
        pageSize: 'a4',
        messageTop: messageTop2
      },
      {
      text: 'Print',
      action: function ( e, dt, button, config ) {
         window.open("{{ route('saleChallan.detailsPrint',['/']) }}/"+"{{ $receiveChallan->id }}", '_blank'); 
      }
      } 
      ],
      
    "lengthMenu": [50, 75, 100 ],
      "order": [],
      "aaSorting": [],
      initComplete: function() {
        this.api().columns().every(function() {
          var that = this;
          $('input', this.footer()).on('keyup change clear', function() {
            if(that.search() !== this.value) {
              that.search(this.value).draw();
            }
          });
        });
      }
    });
  });
  </script>
@endsection
