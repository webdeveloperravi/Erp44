
 <div class="card">
    <!--Header ---->
    <div class="card-footer " style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-center">Create Cheque</h5>
     </div>
    
    <div class="card-body">
   
    <form id="createForm" onsubmit="event.preventDefault();">
      @csrf
              <div class="row"> 
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Cheque Number</label>
                <input name="number" type="text" id="name" class="form-control"  placeholder="Cheque Number" />
              </div>
            </div>  
            <div class="col-xl-4 col-md-6 col-12 mb-1">
              <div class="form-group">
                <label for="basicInput">Enter Amount</label>
                <input name="amount" type="text" class="form-control"  placeholder="Enter Amount" />
              </div>
            </div>  
            <div class="col-xl-4 col-md-6 col-12 my-auto">
            <div class="form-group mt-lg-4"> 
                    <button class="btn btn-primary" onclick="save()">Save</button>
                    <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button>
            </div>
            </div>  
     </form>
  </div>
 </div>
 <script>
    $("#name").focus();
    function save(){

  let url ="{{route('cheque.store')}}";
  let formData = $("#createForm").serialize();
 
  $.ajax({
        
       url : url, 
       method : "POST",
       data : formData,
     success : function(data){
               
               if(data.success){
                 
              $("#create").html('');
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