<style>
    .md-content > div ul{
        padding: 0px !important;
    }
</style>
<div class="md-modal modal-lg md-effect-1 md-show editModal" id="modal-1" style="width: 70%; max-width:1300px">
    <div class="md-content">
        {{-- <div class="row"> --}}
           
           <div class="col-sm-12 p-0">
               <div class="card-footer p-0 mb-0" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Weight Challans</h5>
        </div>
            <div class="card card-border-primary">
            <div class="card-header">
            <h5>From : {{ $challan->super->name ?? ""}}   </h5>
            <h5 class="float-right">Challan Number : {{ $challan->challan_number }}</h5>
             
            </div>
            <div class="card-block pb-0">
            <div class="row">
            <div class="col-sm-6">
            <ul class="list list-unstyled">
            <li>Invoice #: &nbsp;{{ $challan->invoiceDetailGrade->invoiceDetail->invoice->invoice_number }}</li>
            <li>Product : &nbsp;{{ $challan->invoiceDetailGrade->invoiceDetail->product->name }}</li>
            <li>Category : &nbsp;{{ $challan->invoiceDetailGrade->invoiceDetail->assign_product->name }}</li>
            <li>Date : &nbsp;{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $challan->created_at)->isoFormat('DD-MM-YYYY') }}</li>
            </ul>
            </div>
            <div class="col-sm-6">
            <ul class="list list-unstyled text-right">
                <li>Grade: &nbsp;{{ $challan->invoiceDetailGrade->grade->alias }}</li>
                <li>Weight: &nbsp;{{ $challan->invoiceDetailGrade->carat.$mg }}</li>
                <li>Pieces: &nbsp;{{ $challan->invoiceDetailGrade->piece }}</li> 
            </ul>
            </div>
            </div>
            </div>
            <div class="card-footer">
                
            <div class="task-list-table">
             {{-- <p class="task-due"><strong> Due : </strong><strong class="label p-2 label-primary">  {{ Carbon::parse($challan->created_at)->diffForHumans()}}</strong></p> --}}
             {{-- @if ($challan->weightComplete($challan) == true)
             <a href="{{ route('manager.weight.create',$challan->id) }}" class="btn btn-success btn-sm b-none">Weight Complete</a>
             @else
             @if(\App\Helpers\CheckPermission::instance()->viewAction('reject-weight-challan'))
             <a href="{{ route('manager.challan.reject',$challan->id) }}" class="btn btn-danger btn-sm b-none">Reject Challan</a>
             @endif 
             @if(\App\Helpers\CheckPermission::instance()->viewAction('start-weight-challan'))
             <a href="{{ route('manager.weight.create',$challan->id) }}" class="btn btn-info btn-sm b-none">Start Weight</a>
             @endif
             @endif  --}}
             
            </div>
            <div class="task-board m-0">
                @php
                $weightStatus = $challan->weightComplete($challan->invoiceDetailGrade->id);
                $packagingStatus = $challan->packetsComplete($challan->invoiceDetailGrade->id);
               @endphp
               @if ($challan->accept_challan != 1)
               <button class="btn btn-success btn-sm b-none" onclick="acceptChallan({{ $challan->id }})">Accept Challan</button>
               <a href="{{ route('manager.challan.reject',$challan->id) }}" class="btn btn-danger btn-sm b-none">Reject Challan</a>
               @else
               <a href="#" class="btn btn-success btn-sm b-none">Accepted</a>
               @endif
               <a type="button" class="btn btn-danger btn-sm b-none text-white" onclick="($('#previewView').html(''))">Close</a>
               
            </div>
            
            </div>
            </div>
            
            </div>
           
           
           {{-- </div> --}}
    </div>
 </div>
 <div class="md-overlay"></div>
 
 

<script>
       function acceptChallan(id){
       $.get("{{ Route('packetProcess.accept',['/']) }}/"+id,function(data){
              $("#previewView").html("");
              location.reload();   
       });
   }
</script>