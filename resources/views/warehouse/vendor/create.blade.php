<div class="card" id="form">
   <!--Header ---->
   <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Create Vendor Account</h5>
   </div>
   <div class="card-body">
      <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
         <button type="button" class="close" data-dismiss="alert">×</button>
         <ul id="res"></ul>
      </div>
      <form id="createForm" onsubmit="event.preventDefault();">
         @csrf
         <div class="row">
            @csrf   
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Name</label>
                  <input name="name" type="text" class="form-control"  placeholder="Owner Name" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Company</label>
                  <input name="company" type="text" class="form-control"  placeholder="Company Name" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Phone</label>
                  <input name="phone" type="tel" class="form-control" id="phone"/>
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Email</label>
                  <input name="email" type="text" class="form-control"  placeholder="Email" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="parentId">Country</label>
                  <select class="form-control" name="country" id="country" onchange="getState()">
                     <option value="0" selected>Select Country</option>
                     @foreach ($countries as $country)
                     <option value="{{ $country->id }}">{{ $country->name }}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group" id="state_id">
                  <label for="parentId">State</label>
                  <select class="form-control" name="state" id="state" >
                     <option value="0" selected>Select State</option>
                  </select>
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group" id="city_id">
                  <label for="parentId">City</label>
                  <select class="form-control" name="city" id="city" >
                     <option value="0" selected>Select City</option>
                  </select>
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Address</label>
                  <input name="address" type="text" class="form-control"  placeholder="Address" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Locality</label>
                  <input name="locality" type="text" class="form-control"  placeholder="Locality" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Landmark</label>
                  <input name="landmark" type="text" class="form-control"  placeholder="Landmark" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Pincode</label>
                  <input name="pincode" type="text" class="form-control"  placeholder="Pincode" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">GST Number</label>
                  <input name="gst" type="text" class="form-control"  placeholder="GST Number" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 my-auto">
               <div class="form-group mt-lg-4"> 
                  <button class="btn btn-primary" onclick="save()">Submit</button>
                  <button class="btn btn-danger" onclick="($('#create').html(''))">Close</button>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>

<script type = "text/javascript" >
    $("#country").change(function() {
        if ($(this).val() > 0) {
            var country = $(this).val();
            $.ajax({
                url: "{{route('warehouse.vendor.country',['/'])}}/" + country,
                type: "GET",
                dataType: "JSON",
                success: function(res) {
                    $("#state").empty();
                    // $("#state").html("<option>choose State</option>");
                    $.each(res['state'], function(key, value) {
                        $("#state").append("<option value=" + key + ">" + value + "</option>");
                    });
                }
            });
        } else {
            $("#state").html("<option>choose State</option>");
        }
    })
    
$("#state").change(function() {
    if ($(this).val() > 0) {
        var state = $(this).val();
        $.ajax({
            url: "{{route('warehouse.vendor.state',['/'])}}/" + state,
            type: "GET",
            dataType: "JSON",
            success: function(res) {
                $("#city").empty();
                // $("#city").html("<option>choose City</option>");
                $.each(res['city'], function(key, value) {
                    $("#city").append("<option value=" + key + ">" + value + "</option>");
                });
            }
        });
    } else {
        $("#city").html("<option>choose City</option>");
    }
});


</script>