
 <div class="card">
    <!--Header ---->
    <div class="card-footer " style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-center">Add Symmetry</h5>
     </div>
    
    <div class="card-body">
   
    <form id="createForm" onsubmit="event.preventDefault();">
      @csrf
     <div class="row">
              @csrf
            <div class="col-xl-6 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Name</label>
                <input name="name" type="text" class="form-control"  placeholder="Enter Symmetry Name" />
              </div>
            </div> 
            <div class="col-xl-6 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Alias</label>
                <input name="alias" type="text" class="form-control"  placeholder="Enter Symmetry Alias" />
              </div>
            </div> 
            <div class="col-xl-6 col-md-8 col-12 mb-1">
              <div class="form-group">
                <label for="ifscCode">Description</label>
                <textarea id="description" name="description" class="form-control" cols="5" rows="3" placeholder="Enter Symmetry Description"></textarea> 
              </div>
            </div>
                 <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group mt-lg-4"> 
                    <button class="btn btn-primary" onclick="addSymmetry()">Submit</button>
                    <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button>
                  </div>
            </div>  
     </form>
  </div>
 </div>
 <script>
    
    function addSymmetry(){

  let url ="{{route('symmetry.store')}}";
  let formData = $("#createForm").serialize();
 
  $.ajax({
        
       url : url, 
       method : "POST",
       data : formData,
     success : function(data){
               
               if(data.success){
                 
              $("#create").html('');
              notify('Successfully Saved','success');
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