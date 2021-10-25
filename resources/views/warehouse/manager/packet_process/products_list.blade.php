{{-- <div class="card card-border-primary">
    <div class="card-block">
        <div class="row justify-content-center">
            <div class="table-responsive"> 
                <table class="table">
                <thead>
                    <tr class=" table-active"> 
                        <th>UID</th>
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
                        <td>{{ $product->number }}</td>
                       <td>{{ $product->weight }}</td>
                        <td>{{ $product->grade->invoicedetail->product->name }}</td>
                        <td>{{ $product->grade->grade->grade }}</td>
                        <td>{{ $product->grade->invoicedetail->invoice->invoice_number }}</td>
                        @if($product->invoice_detail_grade_packet_id == "0")
                        <td><button class="btn btn-sm btn-primary weight_edit_button" onclick="showEditModal({{ $product->id }})">Edit</button></td>
                        @endif
                    </tr>
                    @endforeach
                 
                </tbody>
            </table>
            {{-- <div class="row">
                <div class="animation-model"> 
                 
            </div>
            </div>  
            </div> 
        </div>
    </div>
</div> --}}
@php
use  Carbon\Carbon;
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-footer p-0" style="background-color: #04a9f5">
                <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Gin Products List ({{ $products->count() }})</h5>
             </div>
        {{-- <div class="card-header">
        <h5 class="card-header-text">Gin Products List {{ $products->count() }}</h5>
        </div> --}}
        <div class="card-block accordion-block">

        <div id="accordion" role="tablist" aria-multiselectable="true">  
            <div id="accordion" role="tablist" aria-multiselectable="true">

                @foreach ($products as $product)
                <div class="accordion-panel">
                <div class="accordion-heading" role="tab" id="product{{ $product->gin }}">
                 <h3 class="card-title accordion-title">
                <a class="accordion-msg  scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{ $product->gin }}" aria-expanded="false" aria-controls="collapseOne{{ $product->gin }}">
                    <div class="card-header p-0">
                        <h4>UID : {{$product->id}} </h4><h4>GIN : {{ $product->gin }}</h4>
                        {{-- (Create Time : {{ Carbon::createFromDate($product->updated_at)->format('Y-m-d') }} --}}
                     </div>
                </a>
                </h3>
                </div>
                <div id="collapseOne{{ $product->gin }}" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="product{{ $product->gin }}" style="">
                <div class="accordion-content accordion-desc">
                 

@if($product->gin)
<div     class="invoiceView"> 
      <!--Card Start--> 
      {{-- <div class="card-header m-2">
         <h4>Gin : {{$product->gin}} </h4>
         
      </div> --}}
      <div class="card-body">
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Gin </label>
               <input type="text" class="form-control " disabled value="{{$product->gin}}" >
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Grade</label>
               <input type="text" class="form-control" value="{{$product->grade->grade->grade}}" disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Packet Number </label>
               <input type="text" class="form-control " value="{{ $product->packet->number }}" disabled>
            </div>
            <div class="col-sm-6 col-md-5">
               <label for="color">UID </label>
               <input type="text" class="form-control " value="{{ $product->gin }}" disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Length </label>
               <input type="text" class="form-control " value="{{ $product->length }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Width</label>
               <input type="text" class="form-control" value="{{ $product->width }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Depth </label>
               <input type="text" class="form-control " value="{{ $product->depth }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Weight</label>
               <input type="text" class="form-control" value="{{ $product->weight.$mg}}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Product </label>
               <input type="text" class="form-control " value="{{ $product->packet->invoiceDetailGrade->invoiceDetail->product->name }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Color</label>
               <input type="text" class="form-control" value="{{$product->color->color  }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Clarity </label>
               <input type="text" class="form-control " value="{{ $product->clarity->clarity }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Ratti Standard</label>
               <input type="text" class="form-control" value="{{ $product->ratti->rati_standard }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Rate Profile </label>
               <input type="text" class="form-control " value="{{ $product->rateProfile->name }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Origin</label>
               <input type="text" class="form-control" value="{{ $product->origin->origin }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Shape </label>
               <input type="text" class="form-control " value="{{ ucfirst($product->shape->shape) }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Specie</label>
               <input type="text" class="form-control" value="{{ $product->specie->species }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">SG </label>
               <input type="text" class="form-control " value="{{ $product->sg }}" disabled>
            </div>
            <div class="col-md-5 col-sm-6">
               <label for="color">Ri</label>
               <input type="text" class="form-control" value="{{ $product->ri }}"  disabled>
            </div>
         </div>
         <div class="form-group row">
            <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Treatment</label>
               <input type="text" class="form-control" value="{{ $product->treatment->treatment }}"  disabled>
            </div>
            <div class="col-md-5 col-sm-6">
            </div>
         </div>
      </div> 
</div>
@else 
<h1 class="text-center">No Product Found</h1>
@endif
                </div>
                </div>
                </div>
                @endforeach 
                </div>
        </div>
 

        </div>
        </div>
        </div>
</div>

