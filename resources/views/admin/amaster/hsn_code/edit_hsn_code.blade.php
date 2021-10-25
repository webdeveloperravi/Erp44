      <div class="card">
      <!--Header ---->
      <div class="row">
        <div class="col-xs-6 col-sm-9 col-md-9 "> 
        <div class="card-header text-secondary text-uppercase">Edit HSNCODE </div>
        </div>
      </div>   
  
    <div class="card-body">
     <div class="alert alert-danger alert-dismissible" style="display: none" id="edit_error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="edit_res"></ul>
     </div>
    
    <form id="edit_hsn_code_form">
        @csrf
        <input type="hidden" name="hsn_code_id" value="{{$hsn_code_data->id}}">

         <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Tax Rate <span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
          <select   id="tax_rate"  name="tax_rate" class="form-control  @error('tax_type') is-invalid @enderror">
                      <option >Select Tax Rate</option>
            @foreach($tax_rate->sortBy('name') as $tr_key => $tr_val )
                                 <option value="{{$tr_val['id']}}" {{$tr_val->id==$hsn_code_data->tax_rate_id ? 'selected' : '' }}>
                    {{$tr_val['rate']}}% 
              </option> 
            @endforeach
        </select>
        </div>  
      </div>

      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">HSN-CODE<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="edit_name" type="text" class="form-control" name="hsn_code" autocomplete="name" autofocus value="{{$hsn_code_data->name}}">
        </div>	
      </div>

       <div class="form-group row">
                    <label for="alias" class="col-md-4 col-form-label text-md-right text-secondary">Description <span class="alert-danger">*</span> </label>
                    <div class="col-md-6">
                        <textarea id="edit_desc" name="description" class="form-control" cols="20" rows="5">{{$hsn_code_data->description}}</textarea> 
                        <span id="msg_origin_desc"></span>
                    </div>
        </div>
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="submit" class="btn btn-success" id="btn-updatehsncode">Update</button> <input type="button" name="cancel"class="btn btn-warning m-l-10" onclick="closeForm()" value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
  
</div>

<script type="text/javascript">
	
$("#btn-updatehsncode").click(function(event){
       
      event.preventDefault();   
      var url='{{route('hsn.code.update')}}';
  var form_data=$("#edit_hsn_code_form").serialize(); 
  $.ajax({

         url : url,
         type : "POST",
         data : form_data,
         success : function(res)
         {
                
            $(".edit_hsn_code").hide();
            hsn_code_list();
            $(".success_msg").show();
            $(".success_msg").html(res["success"]);
            $(function(){
            $(".success_msg").delay(3000).fadeOut();
            });
         },

        error:function(errorData)
        {
             var messages=errorData.responseJSON["message"];
             alert("errors");
             $("#edit_error_msg").show();
             $("#edit_res").empty();
             $("#edit_name").focus();
           for (var i =0; i<messages.length; i++) {
              $("#edit_res").append("<ul><li>"+messages[i]+"</li></ul>");
               }
            $(function(){
              $("#edit_error_msg").delay(10000).fadeOut();
              });
            }
      });

   });

</script>