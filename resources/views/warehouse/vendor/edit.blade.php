@extends('layouts.warehouse.app')
@section('css')
<style type="text/css">
</style>
@endsection
@section('content')
<div class="card" id="form">
   <!--Header ---->
   <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Edit Vendor</h5>
   </div>
   <div class="card-body">
      <div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
         <button type="button" class="close" data-dismiss="alert">×</button>
         <ul id="res"></ul>
      </div>
      <form id="updateForm" onsubmit="event.preventDefault();">
         @csrf
         <div class="row">
          <input type="hidden" name="vendorId" value="{{$vendor_edit_info->id}}">
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Name</label>
                  <input name="name" type="text" class="form-control" value="{{$vendor_edit_info->name}}" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Company</label>
                  <input name="company" type="text" class="form-control" value="{{$vendor_edit_info->company_name}}"  />
               </div>
            </div>
         <!--    <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Phone</label>
                  <input name="phone" type="tel" class="form-control" id="phone" value="{{$vendor_edit_info->phone}}"/>
               </div>
            </div> -->
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Email</label>
                  <input name="email" type="text" class="form-control"  value="{{$vendor_edit_info->email}}" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="parentId">Country</label>
                  <select class="form-control" name="country" id="country" onchange="getState()">
                     <option value="0" selected>Select Country</option>
                    @foreach($country_list as $coun_key => $coun_val)
                     <option value="{{$coun_val->id}}" {{$coun_val->id == $vendor_edit_info->country_id ? "selected" : "" }}>{{$coun_val->name}}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group" id="state_id">
                  <label for="parentId">State</label>
                  <select class="form-control" name="state" id="state" >
                     @foreach($state_list as $state_val)
                  <option value="{{$state_val->id}}" {{$state_val->id ==$vendor_edit_info->state_id ? "selected" : "" }}>{{$state_val->name}}</option>
                  @endforeach
                  </select>
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group" id="city_id">
                  <label for="parentId">City</label>
                  <select class="form-control" name="city" id="city" >
                        @foreach($city_list as $city_val)
                     <option value="{{$city_val->id}}" {{ $city_val->id == $vendor_edit_info->city_id ? "selected" : "" }}>{{$city_val->name}}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Address</label>
                  <input name="address" type="text" class="form-control"  value="{{$vendor_edit_info->address}}" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Locality</label>
                  <input name="locality" type="text" class="form-control" value="{{$vendor_edit_info->locality}}" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Landmark</label>
                  <input name="landmark" type="text" class="form-control" value="{{$vendor_edit_info->landmark}}" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">Pincode</label>
                  <input name="pincode" type="text" class="form-control"  value="{{$vendor_edit_info->pincode}}"/>
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 mb-1">
               <div class="form-group">
                  <label for="basicInput">GST Number</label>
                  <input name="gst" type="text" class="form-control"  value="{{$vendor_edit_info->gst_number}}" />
               </div>
            </div>
            <div class="col-xl-4 col-md-6 col-12 my-auto">
               <div class="form-group mt-lg-4"> 
                  <button class="btn btn-warning" id="btn_edit_vendor" onclick="update()">Update</button>
                <a href="{{ route('warehouse.vendor.view',$vendor_edit_info->id)}}"class="btn btn-warning">Back</a>
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
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function(){
 



});  

function update(){

    var form_data = $("#updateForm").serialize();

    $.ajax({

        url: "{{route('warehouse.vendor.update')}}",
        type: "POST",
        data: form_data,
        success: function(data) {
            console.log(data);
            if ($.isEmptyObject(data.errors)) {
             
                 window.location.href = "{{route('warehouse.vendor.show',['/'])}}/"+"{{$vendor_edit_info->id}}";
                notify('Updated Successfully', 'success');

            } else {
                $.each(data.errors, function(field_name, error) {
                    $(document).find('[name=' + field_name + ']').after('<span class="text-strong text-danger">' + error + '</span>');

                });
                setTimeout(hiderrors, 10000);
            }


        }


    });


}


// hide errors automatic
function hiderrors() {
    $('.text-danger').remove();
}
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
@endsection
