<div class="card">
  <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Retail Model</h5>
    </div> 
      
      <div class="card-body">
        <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <ul id="res">
            
          </ul>
        </div>
        <form id="formRetailModel">
          @csrf
          <div class="form-group row">
            <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Retail Model Parent<span class="alert-danger">*</span></label>
            <div class="col col-sm-4 col-md-6">
              <select name="parentId"  class="form-control" onchange="getDiscountRates(this.value)"> 
                  @foreach ($retail_model_list      as $retail_model_val)
                   <option value="{{$retail_model_val->id}}">{{$retail_model_val->name}}</option>
                @endforeach
              </select>
            </div>
<script>
  
</script>
          </div>
          <div class="form-group row">
            <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
            <div class="col col-sm-4 col-md-6">
              <input id="name" type="text" class="form-control " name="name"  autocomplete="name" autofocus>
            </div>
          </div>

          <div class="form-group row">
            <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Alias<span class="alert-danger">*</span></label>
            <div class="col col-sm-4 col-md-6">
              <input id="alias" type="text" class="form-control" name="alias"  autocomplete="name" autofocus>
            </div>
          </div>


           <div class="form-group row">
                    <label for="ealias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <textarea id="color_desc" class="form-control @error('desc') is-invalid @enderror" name="description" value="{{ old('alias') }}"  autocomplete="name"></textarea>
                                 <span id="msg_desc"></span>
                      </div>
                </div>


           <div class="form-group row">
            <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Retail type<span class="alert-danger">*</span></label>
            <div class="col col-sm-4 col-md-6">
              <select name="retailType"  class="form-control">
                <option  selected value="0" >Select Retail Type</option>
                 @foreach ($retail_types->sortBy('name') as $retail_val)
                   <option value="{{$retail_val->id}}">{{$retail_val->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

           <div class="form-group row">
            <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Discount Rate<span class="alert-danger">*</span></label>
            <div class="col col-sm-4 col-md-6" id="getDiscountRates">
              {{-- <select name="discountRate"  class="form-control">
                <option value='0' selected="">Select Discount Rate</option>
               @foreach ($discount_rates->sortBy('name') as $dis_val)
                   <option value="{{$dis_val->id}}">{{$dis_val->name}}</option>
                @endforeach
              </select> --}}
            </div>
          </div>
            
            <div class="form-group row">
              <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
              <div class="col col-sm-4 col-md-4">
                <button  type="button" class="btn btn-success" onclick="addRetailModel()">Save</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()"  value="Cancel">
              </div>
            </div>
        </form>
      </div>
      
    </div>
    <script type="">
$(document).ready(function(){
   var parentId = $("#parentId").val();
  getDiscountRates(parentId);
 
});
 
 

function addRetailModel(){
   
   var formData = $("#formRetailModel").serialize();
   $.ajax({
  
     url    : "{{route('retail.model.store')}}", 
     method : "POST",
     data   : formData,
     success: function(data){
      
      if(data.errors){
        // $(".complete-loader").hide();
            // $(".complete-box").show(); 
            $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000);
      }else{
        retailModelList();
        closeForm();
      }
     }



   });
}

function getDiscountRates(id){  
  var url = "{{ route('retail.model.getdiscountrates',['/']) }}/"+id;
  // alert(url);
  $.get(url,function(data){ 
      $("#getDiscountRates").html(data);
  });
}

function hideErrors(){ 
    $(".text-danger").remove(); 
  }


    </script>