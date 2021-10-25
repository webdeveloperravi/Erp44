<div class="card">
 
    
    <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit ({{ $retailModel->name }})</h5>
      </div> 
    <div class="card-body">
      
      <div class="alert alert-danger alert-dismissible" style="display: none" id="edit_error_msg">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <ul id="edit_res">
          
        </ul>
      </div>

      <form id="edit_config_role_form">
        @csrf
        <input type="hidden" name="retailModelId" value="{{ $retailModel->id }}">
        <div class="form-group row">
            <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Retail Model Parent<span class="alert-danger">*</span></label>
            <div class="col col-sm-4 col-md-6">
              <select name="parentId"  class="form-control"> 
                  @foreach ($retailModels  as $model)
                  @if($model->id == $retailModel->id)
                  @continue
                  @endif
                  @if($model->id == $retailModel->parent_id)
                  <option value="{{$model->id}}" selected>{{$model->name}}</option>
                

                  @else

                  <option value="{{$model->id}}">{{$model->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
       
        <div class="form-group row">
          <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
          <div class="col col-sm-4 col-md-6">
            <input id="name" type="text" class="form-control " name="name"  autocomplete="name" autofocus value="{{ $retailModel->name }}">
          </div>
        </div>

        <div class="form-group row">
          <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Alias<span class="alert-danger">*</span></label>
          <div class="col col-sm-4 col-md-6">
            <input id="alias" type="text" class="form-control" name="alias"  autocomplete="name" value="{{ $retailModel->alias }}">
          </div>
        </div>


         <div class="form-group row">
                  <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                  <div class="col-md-6">
                      <textarea id="color_desc" class="form-control @error('desc') is-invalid @enderror" name="description" value="{{ old('alias') }}"  autocomplete="name">{{ $retailModel->description }}</textarea>
                               <span id="msg_desc"></span>
                    </div>
              </div>


         <div class="form-group row">
          <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Retail type<span class="alert-danger">*</span></label>
          <div class="col col-sm-4 col-md-6">
            <select name="retailType"  class="form-control">
              <option  selected="" value="0">Select Retail Type</option>
               @foreach ($retailTypes as $retialType)
               @if($retialType->id == $retailModel->retail_type_id)
             <option value="{{$retialType->id}}" selected>{{$retialType->name}}</option>
             @else
             <option value="{{$retialType->id}}">{{$retialType->name}}</option>
             @endif
              @endforeach
            </select>
          </div>
        </div>

         <div class="form-group row">
          <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Discount Rate<span class="alert-danger">*</span></label>
          <div class="col col-sm-4 col-md-6">
            <select name="discountRate"  class="form-control">
              <option value='0' selected="">Select Discount Rate</option>
             @foreach ($discountRates as $discountRate)
             @if($discountRate->id == $retailModel->discount_id)
             <option value="{{$discountRate->id}}" selected>{{$discountRate->name}} ({{ $discountRate->rate."%"}})</option>
             @else

             <option value="{{$discountRate->id}}">{{$discountRate->name}} ({{ $discountRate->rate."%"}})</option>
             @endif
              @endforeach
            </select>
          </div>
        </div>
          
          <div class="form-group row">
            <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
            <div class="col col-sm-4 col-md-4">
              <button  type="button" class="btn btn-success" onclick="update()">Update</button>
               <button type="button" class="btn btn-danger m-l-10" onclick="closeE()"  >Close</button>
            </div>
          </div>
      </form>

    </div>
    
  </div>
  <script>
    
  </script>