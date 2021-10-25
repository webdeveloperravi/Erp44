<div class="card">
      <!--Header ---->
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Unit Conversion</h5>
        </div> 
        
  
    <div class="card-body">
     
     <div class="alert alert-danger alert-dismissible" style="display: none" id="edit_error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="edit_res">
                  
                 </ul>
     </div>

      <form id="edit_unit_conversion_form">
        @csrf
        <input type="hidden" name="id" value="{{$unit_conversion_edit->id}}">
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Main Unit<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
      <select   id="edit_main_unit"  name="main_unit" class="form-control  @error('main_unit') is-invalid @enderror" onchange="getSubUnit(this.value)">
                       <option value="0">Select Unit</option>
                      @foreach($unit as $u_key =>$u_val)
                        <option value="{{$u_val['id']}}" {{$u_val['id']== $unit_conversion_edit->unit_main_id ?'selected': '' }}>
                {{$u_val['name']}}  
                    @endforeach
                     
          
        </select>
        </div>	
      </div>
        <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Sub Unit <span class="alert-danger">*</span></label>
         <div class="col col-sm-4 col-md-6">
       <select id="edit_sub_unit"  name="sub_unit" class="form-control sub_unit @error('main_unit') is-invalid @enderror">
                 
                   @foreach($sub_unit_edit as $u_val)
                        @if($u_val->id==$unit_conversion_edit->unit_sub_id)
                        <option value="{{$u_val->id}}" selected>{{ $u_val->name }}
                        @else
                        <option value="{{$u_val->id}}">{{ $u_val->name }}
                        @endif
                       
                    @endforeach    
          
        </select>
      </div>
    </div>

      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Convesion Factor <span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="edit_conversion_res" type="text" class="form-control only_numeric" name="conversion"  autocomplete="name" autofocus value="{{ $unit_conversion_edit->conversion}}">
        </div>  
      </div>
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="button" class="btn btn-success" onclick="updateUnitConversion()">Update</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
 </div>

 <script>
    $(".only_numeric").bind("keypress", function (e) {
          var keyCode = e.which ? e.which : e.keyCode
             var leng=$(this).val().length;

          if (!(keyCode >= 48 && keyCode <= 57)) {
             $(".error").css("display", "inline");
            return false;
          }
              if(leng>8)
              {
                return false;
              }
          else{
            $(".error").css("display", "none");
          }
        });

 </script>