<div class="md-modal md-effect-1 md-show editModal" id="modal-1">
    <div class="card-footer " style="background-color: #04a9f5">
            <h5 class="text-white m-b-0 text-center">Edit Culet</h5>
           </div>
    <div class="md-content p-2">
     
     <form id="editculet" onsubmit="event.preventDefault();">
         @csrf
          <input type="hidden" name="culetId"  value="{{$culet->id}}">
         <div class="row">
            @csrf
            <div class="col-xl-6 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Name</label>
               <input name="name" type="text" class="form-control" value="{{$culet->name}}" autocomplete="off"/>
               </div>
            </div>
            <div class="col-xl-6 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Alias</label>
                  <input name="alias" type="text" class="form-control"   value="{{$culet->alias}}" autocomplete="off"/>
               </div>
            </div>
            <div class="col-xl-6 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Description</label>
                    <textarea id="description" name="description" class="form-control" cols="5" rows="2">{{$culet->description}}</textarea> 
               </div>
            </div>
        </div>
           
           <div class="form-group row py-3 justify-content-right" >
          <div class="col">
          <button class="btn btn-success saveZone float-right  m-0 mr-4" onclick="updateCulet()">Update</button> 
          <button class="btn btn-danger float-right m-0 mr-2" onclick="$('#edit').html('')">Close</button>  
        </div>
        </div>
     
     
  </form>
         </div>
    </div>
  <div class="md-overlay"></div>

  <script type="text/javascript">
     
     function updateCulet(){
     let url ="{{route('culet.update')}}";
  let formData = $("#editculet").serialize();
 
  $.ajax({
        
       url : url, 
       method : "POST",
       data : formData,
     success : function(data){
               
               if(data.success){
                 
              $("#edit").html('');
              notify('Successfully Updated','success');
                all();
               }else{
                  $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
               }
            }, 
        });
    }


    function hideErrors(){ 
   $(".text-danger").remove(); 
 }
 

  </script>