    @php
        use App\Helpers\Helper; 
    @endphp 
    
    <div class="table-responsive">
    <table class="table">
    <thead>
    <tr class="table-active">
    <th>SN.</th>
    <th>Product</th>
    <th>Weight/Unit</th>
    <th>Weight/mg</th>
    <th>Piece</th>
    <th>Rate</th>
    <th>Amount</th>
    @if($invoice->complete != 0)
    <th>Gradesort</th>
    <th>Generate ID</th>
    <th>Issued </th>
    @endif
    <th>Actions</th>
    </tr>
    </thead>
    <tbody class="text-center">
        @if (empty($invoice))
        @else
        @foreach ($invoice->invoiceDetail as $detail)
        <tr class="text-center"> 
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $detail->product->name }}</td>
            <td>{{ $detail->weightUnit($detail->carat,$detail->unit_id) }}</td>
            <td>{{ $detail->carat . " mg" }}</td>
            {{-- <td>{{ app\Helpers\Helper::weightTOCarat($detail->carat) ." ct"}}</td> --}}
            <td>{{ $detail->piece . " /P" }}</td>
            <td>{{"Rs.".$detail->rate }}</td>
            <td>{{ $detail->amount }}</td>  
            
            {{-- @if(($detail->carat!=$detail->getTotalWeight($detail->id)) && ($detail->piece!=$detail->getTotalPieces($detail->id))) --}}
            @if($invoice->complete == 0)
            <td>
              @if(\App\Helpers\CheckPermission::instance()->viewAction('invoice-product-edit'))
              <button class="editInvoice btn btn-sm btn-warning" onclick="edit({{$detail->id}})"><i class="fa fa-edit text-white"></i>Edit</button>
              @endif
            
              @if(\App\Helpers\CheckPermission::instance()->viewAction('invoice-product-delete'))
              <button class="deleteInvoice btn btn-sm btn-danger"  onclick="deleteInvoiceDetail({{$detail->id}})"><i class="fa fa-times text-danger"></i>Delete</button>
              @endif
            </td> 
             @else 
             <td>
             @if ( $detail->complete == 0 )
             <i class="fa fa-times text-danger"></i>   
             @else
             <i class="fa fa-check text-success">
             @endif 
             </td>
             <td> 
              @if ( $detail->complete == 0 )
              <i class="fa fa-times text-danger"></i>   
               @else

               @if ($detail->checkGenerateIdStatus($detail->id))
               <i class="fa fa-check text-success">
                 @else
               <i class="fa fa-times text-danger"></i>   
              @endif 
               @endif
             </td>
             <td> 
              @if ( $detail->complete == 0 )
              <i class="fa fa-times text-danger"></i>   
               @else
               @if ($detail->issuedToManager($detail->id))
               <i class="fa fa-check text-success">
               @else
               <i class="fa fa-times text-danger"></i>   
              @endif 
               @endif
             </td>
             @if(\App\Helpers\CheckPermission::instance()->viewAction('gradesort-start'))
             @if ($detail->complete == 0)
             <td>
               @if ($invoice->authorization != 0 || auth('warehouse')->user()->role_id == '1')
                <button class="btn btn-sm btn-inverse text-white"  onclick="gradeSort({{ $detail->id }})" > 
                 GradeSort Start</button>
                 @else
                 <button class="btn btn-sm btn-inverse text-white" data-type="inverse" data-from="top" data-align="center" data-icon="fa fa-comments" onclick="swal('Invoice Not Authorized By Super')">Gradesort</button>
               @endif
               </td> 
             @else
             <td> 
               @if ($detail->checkGenerateIdStatus($detail->id))
                 @if(!$detail->issuedToManager($detail->id))
                 <button class="btn btn-sm btn-inverse text-white"  onclick="gradeSort({{ $detail->id }})" > 
                  Issue To Manager</button>
                  @else
                  <button class="btn btn-sm btn-success" onclick="gradeSort({{ $detail->id }})">View</button>
                 @endif
               @else
               <button class="btn btn-sm btn-dark" onclick="gradeSort({{ $detail->id }})"></i>Generate ID</button>
               @endif 
            </td> 
             @endif
             @else 
             <td>
          <button class="btn btn-sm btn-inverse text-white" onclick="noPermission()"><i class="fa fa-check text-white"></i>Gradesort</button>
              </td>
             @endif
            @endif  
        </tr>
        @endforeach
        @endif
        <thead>
        <tr class="table-active"> 
            <td>Total : </td>
            <td>{{ $invoice->totalItems($invoice->id)." Items" }}</td>
            <td>{{ Helper::weightToCarat($invoice->totalWeight($invoice->id))." Ct."  }}</td>
            <td>{{ $invoice->totalWeight($invoice->id)." mg"  }}</td>
            <td>{{ $invoice->totalPiece($invoice->id)." /p"  }}</td>
            <td></td>
            <td>Total : {{ $total_amount }}</td>
            <td  colspan="4"></td>
        </tr>
        </thead>
    </tbody>
    </table>
</div>
 
<div class="row">
    <div class="col-12">
       @if(\App\Helpers\CheckPermission::instance()->viewAction('invoice-complete'))
       <a class="btn btn-success float-right my-4 mr-4" id="completeButton" href="{{ route('product.purchase.complete',['id'=>$invoice->id,'type'=>'complete']) }}"  data-toggle="tooltip" data-placement="top" title="After complete you can't modify invoice">Complete Invoice</a>
       @endif
      
      {{-- @if (isset($invoice) && App\Helpers\Helper::invoiceGradeSorted($invoice->id))
          
      @endif --}}
    
{{--        
      @if(\App\Helpers\CheckPermission::instance()->viewAction('invoice-gradesort-now'))
      
      <button id="gdNow" class="btn btn-dark float-right my-4 mr-4 text-white" data-type="inverse" data-from="top" data-align="center" data-icon="fa fa-comments" style="display: " onclick="checkInvoiceAuthorization({{$invoice->id}})">Gradesort Now</button>
   
      @endif  --}}
       

       @if(\App\Helpers\CheckPermission::instance()->viewAction('invoice-save-to-draft'))
       <a class="btn btn-primary float-right my-4 mr-4" id="draftButton" href="{{ route('product.purchase.complete',['id'=>$invoice->id,'type'=>'draft']) }}"data-toggle="tooltip" data-placement="top" title="Come anytime here and modify product purchase">Save to Draft</a>
       @endif
    </div>
</div>


  <script> 
// $("#gdNow").on('click',function(){
//    location.reload();
// });

$(document).ready(function(){
  hideGradesortButton();
});
   function hideGradesortButton(){
      var current = document.URL;
      if(current.includes('dashboard-invoice-view')){ 
          $("#gdNow").hide();
      }else{
          $("#gdNow").show();
      }
   }


    function deleteInvoiceDetail(id){
        // $('#formDelete').attr('onsubmit','return false;');
        // alert(id);
        var invoiceId = id; 
        var token = $('meta[name="csrf-token"]').attr('content');

   $.ajax({
     url: "{{route('invoice.detail.delete')}}",
     method: 'POST', 
     data: { 
      _token: "{{ csrf_token() }}",
       invoiceId:invoiceId, 
     },
     success: function(data) {
         $("#invoice").trigger("focusout");
         $("#deleteMsg").show();
         setTimeout(function(){
            $("#deleteMsg").hide();
         },3000);
         // closeModal();
        }
   });
    }

    function checkInvoiceAuthorization(invoiceId){
      var url = "{{route('check.invoice.authorization',['/'])}}/"+invoiceId;
      $.get(url,function(data){
           if(data == true){
              var invId = "{{$invoice->id}}";
              var type = "gradesort";
              var gradesortInvoiceUrl = "{{route('product.purchase.complete',['/','/'])}}/"+invId+'/'+type;
               document.location.href=gradesortInvoiceUrl
           }else{
              swal('Invoice Not Authorized By Super');
             ;
           }
      });
    }

    function gradeSortNow(invoiceId){
      var invId = "{{$invoice->id}}";
      var type = "gradesort";
      var gradesortInvoiceUrl = "{{route('product.purchase.complete',['/','/'])}}/"+invId+'/'+type;
      document.location.href=gradesortInvoiceUrl
    }

    function gradeSort(invoiceDetailId){
   
      // if(checkAuthorization('invoice-gradesort-now','Invoice_Final','{{ $invoice->invoice_number }}')){
        var url = "{{route('gradesort.index',['/'])}}/"+invoiceDetailId;
      $.get(url,function(data){
        // console.log(data);
        $("#gradeSortView").html(data);
        $("#gradeSortView").LoadingOverlay("hide"); 
      });
      // }
     
    }

    
    
  
  </script>