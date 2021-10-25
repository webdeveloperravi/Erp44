 @if ($challan->weightComplete($challan->invoiceDetailGrade->id))
 
 <div class="row"> 
    <div class="col-md-6 col-lg-3">
        <div class="card statustic-card">
            <div class="card-block text-center">
                <span class="d-block text-c-blue f-28">{{ $leftWeight.$mg }}</span>
                <p class="m-b-0">Left Weight</p>
            </div>
            <div class="card-footer" style="background-color: #04a9f5">
                <h6 class="text-white m-b-0 text-center">Total Weight : {{ $challan->invoiceDetailGrade->carat }}</h6>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card statustic-card">
            <div class="card-block text-center">
                <span class="d-block text-c-yellow f-28">{{ $leftPiece }}</span>
                <p class="m-b-0">Left Pieces</p>
            </div>
            <div class="card-footer bg-c-yellow">
                <h6 class="text-white m-b-0 text-center">Total Pieces :{{ $challan->invoiceDetailGrade->piece }}</h6>
            </div>
        </div>
    </div> 
    </div> 
@else
 <script>
     $("#makePackets").click();
 </script>
 @endif

@if ($products->count() > 0)

<div class="table-responsive"> 
    <table class="table">
    <thead>
        <tr class=" table-active"> 
            <th>ID</th>
            <th>Weight</th>
            <th>Product</th>
            <th>Grade</th>
            <th>Inovoice No.</th> 
            <th>Action</th> 
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr id="myTable" class="text-center"> 
            <td>{{ $product->id }}</td>
           <td>{{ $product->weight }}</td>
            <td>{{ $product->grade->invoicedetail->product->name }}</td>
            <td>{{ $product->grade->grade->grade }}</td>
            <td>{{ $product->grade->invoicedetail->invoice->invoice_number }}</td>
            @if($product->invoice_detail_grade_packet_id == "0")
            {{-- @if(\App\Helpers\CheckPermission::instance()->viewAction('edit-product-weight')) --}}
            <td><button class="btn btn-sm btn-primary weight_edit_button" onclick="showEditModal({{ $product->id }})">Edit</button></td>
            {{-- @endif --}}
            @endif
        </tr>
        @endforeach
     
    </tbody>
</table>
<div class="row">
    <div class="animation-model"> 
     
</div>
</div>
</div> 
@endif

@if ($leftWeight == 0 && $leftPiece == 0) 
<div class="col-md-12 col-lg-12"> 
        <div class="row">
            <div class="col">
            
                @if (!$challan->packetsComplete($gradeId))
                <script>
                   makePacketsView("{{ $gradeId }}");
                </script>
                {{-- <a class="btn btn-inverse text-white float-right mb-3" onclick="makePacketsView({{ $gradeId }})"><i class="icofont icofont-exchange"></i>Products Packaging</a> --}}
                @else
                @if(\App\Helpers\CheckPermission::instance()->viewAction('start-packaging'))
                <a  
                onclick="finishWeight({{ $gradeId }})" id="makePackets" class="btn btn-inverse float-right text-white mb-3 start_packaging_button"><i class="icofont icofont-exchange "></i>Start Packaging</a>
                @endif 
                @endif 
        
        </div>
        </div>  
</div>
@endif

 
