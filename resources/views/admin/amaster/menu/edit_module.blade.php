<div class="md-modal md-effect-1 md-show editModal" id="modal-1">
    <div class="md-content">  
<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Module</h5>
    </div> 

<div class="card-body">
<div class="alert alert-danger alert-dismissible" style="display: none" id="edit_error_msg">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<ul id="edit_res">
</ul>
</div>
                                 
        <form method="POST"  enctype="multipart/form-data" id="edit_menu_form">
            @csrf  
           <input type="hidden" name="edit_id" value="{{ $module->id }}"> 
            <input type="hidden" name="guard_id" value="{{ $module->guard_id }}">         
            <input type="hidden" name="chlid_sort" value="{{ $module->child_sort }}"> 
             <input type="hidden" name="parent_id" value="{{ $module->parent }}">          
                      
            <div class="form-group row">
              <label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Title<span class="alert-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="etitle" type="text" class="form-control @error('edit_title') is-invalid @enderror" name="title" value="{{$module->title }}"  autocomplete="etitle" autofocus>
                                 
                        @error('etitle')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
              </div>

               <div class="form-group row">
              <label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Description</label>
                    <div class="col-md-6">
               <textarea id="description" class="form-control @error('desc') is-invalid @enderror" name="description" value="{{ old('alias') }}"  autocomplete="name">{{$module->description}}</textarea>
        
                    </div>
              </div>

                <div class="form-group row">
                    <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Route <span class="alert-danger">*</span></label>
                    <div class="col-md-6">
                        <input id="eroute" type="text" class="form-control @error('route') is-invalid @enderror" name="route" value="{{$module->route }}"  autocomplete="name" autofocus>
                                 <span id="msg_alias"></span>
                        @error('route')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                    
                <div class="form-group row">
                <label for="parent" class="col-md-4 col-form-label text-md-right text-secondary">Parent Menu   </label>

                <div class="col-md-6">

                    <select     class="form-control" name="parent" value="{{ old('parent') }}"  autocomplete="name" autofocus  id="edit_parent_menu">
                    <option value="0"> Select Parent Menu</option>
                     @foreach($parent_modules as $gm_val)
                    @if($gm_val->parent=='0')
                    <option value="{{ $gm_val->id }}" class="text-dark font-weight-bold" {{ $gm_val->id==$module->parent ? 'selected' : ''}}>{{$gm_val->title}}</option>
                      @foreach($gm_val->sub_module as $fm_val)
                           
                           <option value="{{ $fm_val->id }}" class="text-secondary font-weight-bold" {{ $fm_val->id==$module->parent ? 'selected' : ''}}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $fm_val->title}}</option>
                             @foreach($fm_val->sub_module as $sn_val)
                            <option value="{{ $sn_val->id }}" class="text-dark font-weight-normal" {{ $sn_val->id==$module->parent ? 'selected' : ''}}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sn_val->title}}</option>
                             
                             @foreach($sn_val->sub_module as $sn_sn_val)
                                 
                                  <option value="{{ $sn_sn_val->id }}" class="text-dark font-weight-normal"{{ $sn_sn_val->id==$module->parent ? 'selected' : ''}}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sn_sn_val->title}}</option>

                             @endforeach 

                             @endforeach    
 
                       @endforeach
                      @endif
                   @endforeach
                </select>


                   {{--  @foreach($parent_modules as $pm_key =>$pm_val)
                    <option value="{{$pm_key}}"{{$pm_key== $module->parent ? 'selected' :''}}> {{ $pm_val}}</option>
                      
                    @endforeach
                    </select> --}}
                </div>
            </div>
 
              <div class="form-group row">
                <label for="color" class="col-md-4 col-form-label text-md-right text-secondary">Guard<span class="alert-danger">*</span></label>
                      <div class="col-md-6">
                        <input  type="text" value="{{ $guard->name }}" class="form-control @error('route') is-invalid @enderror" name="guard" readonly>
                        {{-- <select name="guard" class="form-control">
                          <option value="0">Select Guard</option>
                          @foreach ($guards as $guard)
                          @if ($guard->id == $module->guard_id)
                          <option value="{{ $guard->id }}" selected>{{ $guard->name }}</option>
                          @else    
                          <option value="{{ $guard->id }}">{{ $guard->name }}</option>
                          @endif
                          @endforeach
                        </select>  --}}
                      </div>
           </div> 
                   
        <div class="form-group row mb-0">
            
            <div class="col-md-6 offset-md-4">
                                <input type="button" class="btn btn-success" id="btn_menu_updated" class="btn_menu_update" value="Update" onclick="updateModule()">
            
                                 <input type="button" class="btn btn-danger" value="Cancel" id="btn_order_cancel" onclick="closeForm()">

               </div>
               
              </div>
         </form>
        </div> 
        </div>
    </div>
    
  <div class="md-overlay"></div>
