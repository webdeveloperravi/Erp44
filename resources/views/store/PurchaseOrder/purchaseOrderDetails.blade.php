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
  <a href="{{route('purchaseorder.index')}}" class="btn btn-inverse btn-sm  m-2">Back</a>
</div>
</div>  
<div class="card">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{$order->buyerStoreName->company_name ?? ''}}</h5>
     </div>
    
    <div class="card-body"> 
    <div class="row">

    <div class="col col-md-12">

    <div class="row">
      
      <div class="col-md-4">
      <h6><strong>To :  </strong> <span>{{$order->store->company_name ?? ''}}</span></h6>
      <h6><strong>From : </strong> <span>{{$order->buyerStoreName->company_name ?? ''}}</span></h6>
     </div>
    <div class="col-md-4">
      <h6><strong>Date : </strong><span>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->isoFormat('DD-MM-YYYY') }}</span></h6>
      <h6><strong> Order No. : </strong>#<span>{{$order->po_number ?? ''}}</span></h6>
    </div>
    <div class="col-md-4">
      <h6><strong>Total Quantity : </strong> <span>{{$order->getTotalPurchaseOrderQty($order->id)}}</span></h6>
      <h6><strong> Product Category :  </strong><span>{{$order->purchaseOrderDetail[0]->productCategory->name ?? ''}}</span></h6>

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
    <div id="details">
      <div class="card-body">
        @if(!empty($order))
  <div class="table-responsive">
     <table class="table" id="table_id2" style="width:100">
        <thead>
           <tr>
           <th>S.No</th> 
           <th>Product</th>
           <th>Grade</th>
           <th>Ratti</th>
           <th>Qty</th>
       </tr>
        </thead>
        <tbody>
           @foreach ($order->purchaseOrderDetail as $order)
              <tr>
               <td>{{$loop->iteration}}</td>   
                   <td>{{$order->product->name ?? " "}}</td>  
                   <td>{{$order->grade->grade ?? " "}}</td>  
                   <td>{{$order->ratti->rati_standard ?? " "}}+</td>  
                   <td>{{$order->quantity ?? ""}}</td>  
               </tr>
           @endforeach
        </tbody>
     </table>
  </div>
   @else
   <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
   @endif 
</div>

    </div>
</div>
    

  </div>



</div><!---card Body Div close-->
</div><!--Card Div Close-->

 
@endsection
@section('script')
<script>
      $(document).ready(function() {
$('#table_id2 tfoot th').each(function() {
   var title = $(this).text();
   $(this).html('<input type="text" placeholder="Search ' + title + '" />');
});
var cardTitle = "Order Detail";
var columns = [0, 1, 2, 3, 4];
// DataTable
var authUserId = "{{ auth('store')->user()->id ?? __}}";
var authUserName = "{{ auth('store')->user()->name ?? __}}";
var userRole = "{{ App\Helpers\Helper::getUserRoleName() ?? __}}";
var companyName = "{{ App\Helpers\Helper::getStoreName() ?? __}}"
var messageTop =`<h6 class="d-inline ml-2">Report from UID : </h6>` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
var messageTop2 =`Report from UID : ` + authUserId + "     Name : " + authUserName + "     Role : " + userRole + "     Company : " + companyName;
var table = $('#table_id2').DataTable({
   stateSave: true,
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
      // orientation: 'landscape',
      pageSize: 'a4',
      messageTop: messageTop
   }, {
      extend: 'print',
      exportOptions: {
         columns: columns,
      },
      title: cardTitle,
      messageTop: `<div class="ml-2"></div>`+messageTop
   }, ],
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





















































