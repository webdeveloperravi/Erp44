 
  <div class="md-modal md-effect-1 md-show editModal" id="modal-1">
    <div class="md-content"> 
    <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{ $orgRole->name }}</h5>
      </div> 
    <form id="editConfigForm" > 
      @csrf 
      <input type="hidden" name="orgRoleId" value="{{ $orgRole->id }}">
        <div class="form-group row pt-3">
        <label class=" col-md-4 col-form-label text-md-right text-secondary">Retail Model:
        <span class="alert-danger">*</span>
        </label>
        <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 ">
          <select class="selectpicker form-control m-b-10" name="retailModelId"> 
            <option value="">Select Retail Model</option>
          @foreach ($retailModels as $model)
          @if($model->id == $orgRole->retail_model_id)
          <option value="{{ $model->id }}" selected>{{$model->name}}</option> 
          @else
          <option value="{{ $model->id }}">{{$model->name}}</option> 
          @endif
          @endforeach
          </select>
        </div>
        </div> 
        <div class="form-group row pt-3">
        <label class=" col-md-4 col-form-label text-md-right text-secondary">Tax Type:
        <span class="alert-danger">*</span>
        </label>
        <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 ">
          <select class="selectpicker form-control m-b-10" name="taxType"> 
          <option value="">Select Tax Type</option>
          @foreach ($taxTypes as $type)
          @if($type->id == $orgRole->tax_type_id)
          <option value="{{ $type->id }}" selected>{{$type->name}}</option> 
          @else
          <option value="{{ $type->id }}">{{$type->name}}</option> 
          @endif
          
          @endforeach
          </select>
        </div>
        </div> 
        <div class="form-group row pt-3">
        <label class=" col-md-4 col-form-label text-md-right text-secondary">Unit:
        <span class="alert-danger">*</span>
        </label>
        <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 ">
          <select class="selectpicker form-control m-b-10" name="unitType"> 
            <option value="">Select Unit</option>
          @foreach ($units as $unit)
          @if ($unit->id == $orgRole->unit_id)
          <option value="{{ $unit->id }}" selected>{{$unit->name}}</option> 
          @else    
          <option value="{{ $unit->id }}">{{$unit->name}}</option> 
          @endif
          @endforeach
          </select>
        </div>
        </div> 
        <div class="form-group row pt-3">
        <label class=" col-md-4 col-form-label text-md-right text-secondary">IP Blocking Feature:
        <span class="alert-danger">*</span>
        </label>
        <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 ">
          <select class="selectpicker form-control m-b-10" name="ip_blocking_feature">  
          <option value="0" {{ $orgRole->ip_blocking_feature == 0 ? "selected" : "" }}>Disable</option>  
          <option value="1" {{ $orgRole->ip_blocking_feature == 1 ? "selected" : "" }}>Enable</option>  
         
          </select>
        </div>
        </div> 
        <div class="form-group row pt-3">
        <label class=" col-md-4 col-form-label text-md-right text-secondary">Stock Visibility:
        <span class="alert-danger">*</span>
        </label>
        <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 ">
          <select class="selectpicker form-control m-b-10" name="stock_visibility">  
          <option value="0" {{ $orgRole->stock_visibility == 0 ? "selected" : "" }}>Disable</option>  
          <option value="1" {{ $orgRole->stock_visibility == 1 ? "selected" : "" }}>Enable</option>  
         
          </select>
        </div>
        </div> 
             <div class="form-group row">
             {{-- <label class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label> --}}
             <div class="col col-sm-4 col-md-12 mb-2">
             <button type="button" class="btn btn-success float-right mx-4" onclick="updateConfig()">Update</button> 
             <button type="button" name="cancel" class="btn btn-danger float-right" onclick="closeModal()">Close</button>
             </div>
             </div>
     </form>
    </div>

  </div>
  <div class="md-overlay"></div>
  <script>
    $(document).ready(function(){  
      // alert('saab');
      document.getElementById("date5").defaultValue = new Date().toISOString().substr(0, 10) ;
       
    });


    function closeModal(){
        $("#editConfig").html("");
    }
  </script>