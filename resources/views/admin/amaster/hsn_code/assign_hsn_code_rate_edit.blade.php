<div class="assign_hsn_code_rate" style="display:block">
      <div class="card">
      <!--Header ---->
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Assign Tax Rate</h5>
        </div>   
  
    <div class="card-body">
     <div class="alert alert-danger alert-dismissible" style="display: none" id="edit_error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="edit_res"></ul>
     </div>

      <form id="assign-tax-rate-form_edit">
        @csrf
       <input type="hidden" name="hsn_code_id" value="{{$assign_hsn_rate->hsn_code_id}}">
       <input type="hidden" name="id" value="{{$assign_hsn_rate->id}}">
       <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">HSN-CODE<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="name" type="text" class="form-control"  autocomplete="name" autofocus value="{{$assign_hsn_rate->assign_hsn_code->hsn_code}}" readonly="true">
        </div>	
      </div>
 
       <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Tax Rate <span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
          <select   id="edit_tax_rate"  name="tax_rate" class="form-control  @error('tax_type') is-invalid @enderror">
                      <option >Select Tax Rate</option>
            @foreach($tax_rate->sortBy('name') as $tr_key => $tr_val )
                                 <option value="{{$tr_val['id']}}" {{$tr_val->id==$assign_hsn_rate->tax_rate_id ? 'selected' : ''}}>
                    {{$tr_val['rate']}}% 
              </option> 
            @endforeach
        </select>
        </div>  
      </div>

        <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Date<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
            <input id="edit_date" type="text" class="form-control" name="manual_date" autocomplete="name" autofocus placeholder="yyyy/mm/dd" value="{{$assign_hsn_rate->created_date}}">
        </div>  
      </div>
      
    <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="submit" class="btn btn-success" id="btn-assign-rate-edit">Update</button>
          <input type="button" name="cancel"class="btn btn-warning m-l-10" onclick="closeForm()" value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
  
</div>
</div>

<script type="text/javascript">
  
// update assigned hsn_code...

$("#btn-assign-rate-edit").click(function(event){

    event.preventDefault();   
  var url='{{route('hsn.code.assign.update')}}';
  var form_data=$("#assign-tax-rate-form_edit").serialize(); 
  $.ajax({

         url : url,
         type : "POST",
         data : form_data,
         success : function(res)
         {
                
            $(".edit_assign_hsn_code_rate").hide();
            //hsn_code_list();
            $(".success_msg").show();
            $(".success_msg").html(res["success"]);
            $(function(){
            $(".success_msg").delay(3000).fadeOut();
            });
             setTimeout(function () {
        location.reload(true);
      }, 3000);

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


$("#edit_date").on('mouseover',function(){
 $(this).datepicker({
    dateFormat: "dd/mm/yy",
    defaultDate: '01/04/2019',
   changeMonth: true,
   changeYear: true,
   minDate: 0,
  });
 



});




</script>