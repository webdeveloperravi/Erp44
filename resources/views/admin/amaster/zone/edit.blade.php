 
  <div class="md-modal md-effect-1 md-show editModal" id="modal-1">
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Zone</h5>
     </div> 
    <div class="md-content"> 
  
    <form onsubmit="event.preventDefault()" > 
      @csrf 
       <input type="hidden" name="zoneId" id="zoneId" value="{{$zone->id}}">
        <div class="form-group row pt-3">
        <label class=" col-md-4 col-form-label text-md-right text-secondary">Name
        <span class="alert-danger">*</span>
        </label>
        <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 ">
          <input type="text" class="form-control" name="name" id="nameEdit" value="{{$zone->name}}">
        </div>
      </div> 
        <div class="form-group row pt-3">
        <label class=" col-md-4 col-form-label text-md-right text-secondary">Alias
        <span class="alert-danger">*</span>
        </label>
        <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 ">
          <input type="text" class="form-control" name="alias" id="aliasEdit" value="{{$zone->alias}}">
        </div>
      </div> 
        <div class="form-group row pt-3">
        <label class=" col-md-4 col-form-label text-md-right text-secondary">Description
        <span class="alert-danger">*</span>
        </label>
        <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 ">
          <input type="text" class="form-control" name="description" id="descriptionEdit" value="{{$zone->description}}">
        </div>
      </div> 
        <div class="form-group row py-3 justify-content-right" >
          <div class="col">
               <button onclick="updateZone()" class="btn btn-success float-right m-0 mr-4 ">Update</button>
        <button onclick="editModalHide()" class="btn btn-danger float-right m-0 mr-2">Close</button>
          </div>
      
      </div> 
 

     </form>
    </div>

  </div>
  <div class="md-overlay"></div>
  <script>
    $(document).ready(function(){  
      // alert('saab');
      document.getElementById("date5").defaultValue = new Date().toISOString().substr(0, 10) ;
       
    });

    function updateZone(){
    
   // $("#saveButton").attr('disabled',true); 
   var name = $("#nameEdit").val();
   var alias = $("#aliasEdit").val();
   var description = $("#descriptionEdit").val(); 
   var zoneId = "{{$zone->id}}";
   var token = "{{csrf_token()}}";
    
   
   $.ajax({
     url: "{{route('zone.update')}}",
     method: 'POST',
     data: { 
       name :name,
       alias :alias,
       description :description,
       zoneId :zoneId,
      _token:token,
     },
     beforeSend:function(){
         // $(".updateZone").attr('disabled',true);
     },
     success: function(data){
        $(".saveZone").attr('disabled',false);
      if($.isEmptyObject(data.errors)){
           editModalHide();
          $("#stateIndex").trigger('change');
          
         // product_purchase_list(); 
         // zoneIndex(); 
         // $(".complete-loader").hide();
         // $("#successMsg").show();
         // setTimeout(function(){
         //    $("#successMsg").hide();
         // },3000);
      }else{ 
         // $(".complete-loader").hide(); 
          $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000);   
      }
      }
   });

}
  </script>