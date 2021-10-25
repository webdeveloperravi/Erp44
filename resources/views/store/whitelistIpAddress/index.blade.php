@extends('layouts.store.app') 
@section('content') 
	<div class="add_address_type ">
		<div class="card">
			<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
				<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Add IP</h5> </div>
			<div class="card-body"> 
				<form id="createForm" onsubmit="event.preventDefault(0)">
                     @csrf
                     <div class="row">
                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="basicInput">IP Address</label>
                                <input name="ip_address" id="ipAddress" onkeypress="javascript: if(event.keyCode == 13){$('#submitBtn').click()};" type="text"  class="form-control"  placeholder="Enter IP Address"  autocomplete="off"/>
                              </div>
                         </div>
                         <div class="col-md-4">
                            <div class="form-group">
                                <label for="parentId" class="invisible d-block">Hidden</label>
                               <button class="btn btn-inverse btn-sm" type="button" id="submitBtn" onclick="save()">Save</button>
                              </div>
                         </div>
                     </div>
                     
                    
				</form>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
			<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">WhiteList IP List</h5> </div>
		<div class="card-body" id="all"> 

		</div> 
	</div> 
@section('script')
<script type="text/javascript">

$(document).ready(function(){
        all();
        $("#ipAddress").focus();
});
 
 function save(){ 
    $.ajax({
         url : "{{ route('whitelistIpAddress.save') }}",
         type : "Post",
         data : $("#createForm").serialize(),
         success:function(data){
           
          if(data.success){  
            all();
            $("#ipAddress").val('');
            notify('Successfully Saved', 'success'); 
          }
          if(data.errors){
            $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
            }); 
            setTimeout(hideErrors,5000); 
          }
          },
        });
 }

 function all(){
     var url = "{{ route('whitelistIpAddress.all') }}";
     $.get(url, (data) =>{
           $("#all").html(data);
     });
 } 
 

 function remove(id){
 



        swal({
			title: "Confirm to Delete Ip Address !",
			text: ``,
			type: "info",
			showCancelButton: true, 
		}, function () {
         hideErrors();
         var url = "{{ route('whitelistIpAddress.delete',['/']) }}/"+id;
     $.get(url, (data) =>{
           all();
           notify('Removed Successfully','danger' );
     });
		}
      );

 } 
    


</script>


@endsection
@endsection