    <div class="card">
      <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Tax Rate</h5>
        </div>  

     <div class="card-body">
     
     <div class="alert alert-danger alert-dismissible" style="display: none" id="edit_error_msg">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <ul id="edit_res">
                  
                 </ul>
     </div>
      <form id="edit_tax_rate_form">
        @csrf
        <input type="hidden" name="id" id="id" value={{$tax_rate_edit->id}}>
       <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Tax Type <span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
          <select   id="edit_tax_type"  name="tax_type" class="form-control  @error('tax_type_id') is-invalid @enderror"> 
            @foreach($tax_type->sortBy('name') as $tt_key => $tt_val )
                                 <option value="{{$tt_val['id']}}" {{$tt_val['id']== $tax_rate_edit->org_tax_type_id ? 'selected':'' }}>
                {{$tt_val['name']}}  
              </option> 
            @endforeach
        </select>
        </div>  
      </div>
     
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Rate<span class="alert-danger">*</span></label>
       <div class="col col-sm-4 col-md-6">
        <input id="edit_rate" type="text" class="form-control only_num" name="rate"  autocomplete="name" autofocus value="{{$tax_rate_edit->rate}}">
        </div>  
      </div>
      
      <div class="form-group row">
      <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
       <div class="col col-sm-4 col-md-4">
         <button  type="button" class="btn btn-success" onclick="updateTaxRate()">Update</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()" value="Cancel">  
        </div>  
      </div>
    </form>
   </div>
 </div>

 <script type="text/javascript">
   
$(function () {
    $(".only_num").on("keypress", function (evt) {
        var $txtBox = $(this);
        var charCode = (evt.which) ? evt.which : evt.keyCode
          ("#msg").append(charCode);
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46)
            return false;
        else {
            var len = $txtBox.val().length;
            var index = $txtBox.val().indexOf('.');
            //alert(index);
            if (index > 0 && charCode == 46) {
              return false;
            }
            if (index > 0) {
                var charAfterdot = (len + 1) - index;
                if (charAfterdot > 3) {
                    return false;
                }
            }
        }
        return $txtBox; //for chaining
    });
})

 </script>