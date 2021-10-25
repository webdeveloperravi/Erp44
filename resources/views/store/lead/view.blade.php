@extends('layouts.store.app')
@section('css')
 <style>

     th {
  text-align: left !important;
}

</style>
@endsection
@section('content')
<a  class="btn btn-dark mb-2" href="{{ route('lead.index') }}">Back</a>
<div id="edit"></div>
<div id="assign"> </div>
<div id="editComment"> </div>
<div id="viewImage"> </div>
<div class="card">
<!--Header ---->
<div class="card-footer p-0" style="background-color: #04a9f5">
<h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{$lead->company}}</h5>
</div>
<div class="card-body">
<div class="row">
    <div class="col col-md-6">
      <div class="row">
          <div class="col col-md-3">
            <img src="http://localhost/erp/public/images/lead-images/abc.jpg" alt="" class="img-fluid img-thumbnail" width="100">
          </div>
          <div class="col-md-9">
            <h6><span>{{ $lead->name ?? ""}}</span></h6>
            <h6><span>{{ $lead->company ?? ""}}</span></h6>
            <h6><span>{{ $lead->email ?? ""}}</span></h6>
            <h6><span>+{{ $lead->getPhoneWithCode($lead->id) ?? ""}}</span></h6>
          </div>
      </div>
    </div>
    <!---Left Div---->
    <div class="col col-lg-6 col-md-6">
      <div class="row">
          <div class="col mb-2">
            @if($lead->converted_to_store == 1)
            <button href="" class="btn btn-sm btn-success f-right"><i class="fa fa-check text-white"></i>Converted to Store</button>
            @else 
           
@can('store-update', 'lead.index')
 

<button id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right mr-3" onclick="editLead('{{$lead->id}}')">
  Edit
</button> 
@endcan  
            
            @can('store-create', 'lead.index')
            <button  type="button" class="btn btn-sm btn-warning waves-effect waves-light f-right mr-3" onclick="assign()">
            Assign
            </button>
            @endcan

            @endif
          </div>
      </div>
      <!----Close Left div Row -->
    </div>
    <!---Left Div close-->
    <div class="col-md-12">
      <ul class="nav nav-tabs m-2" role="tablist" >
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#nav_details">Details</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#nav_contacts" onclick="contactsIndex()">Contacts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#nav_comments" >Comments</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#nav_images" >Images</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#nav_convert" onclick="convertIndex()">Convert</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#nav_social" onclick="leadSocialIndex()">Social Media</a>
          </li>
      </ul>
      <div class="tab-content">
          <div id="nav_details" class="container tab-pane active">
            <br>
            <div class="card-block">
                <div class="view-info">
                  <div class="row">
                      <div class="col-lg-12">
                        <div class="general-info">
                            <div class="row">
                              <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table m-0">
                                        <tbody>
                                          <tr>
                                              <th scope="row">Owner Name</th>
                                              <td>{{ $lead->name ?? ""}}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Company</th>
                                              <td>{{ $lead->company ?? ""}}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Phone</th>
                                              <td>+{{ $lead->getPhoneWithCode($lead->id) ?? ""}}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Whats App</th>
                                              <td>+{{ $lead->getWhatsAppWithCode($lead->id) ?? ""}}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Email</th>
                                              <td>{{ $lead->email ?? ""}}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Lead Type</th>
                                              <td>{{$lead->leadType->name ?? '' }}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Lead Status</th>
                                              <td>{{$lead->leadStatus->name ?? '' }}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Created By</th>
                                              <td>{{ $lead->creator->name ?? ""}}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Assigned To</th>
                                              <td>{{ $lead->manager->name ?? ""}}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Lead Parent Store</th>
                                              <td>{{ $lead->store->name ?? "" }}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Lead Source</th>
                                              <td>{{ $lead->leadSource->name ?? ""}}</td>
                                          </tr>
                                          <tr>
                                        </tbody>
                                    </table>
                                  </div>
                              </div>
                              <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                    <table class="table m-0">
                                        <tbody>
                                          <tr>
                                              <th scope="row">Country</th>
                                              <td>{{ $lead->country->name ?? ""}}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">State</th>
                                              <td>{{ $lead->state->name ?? ""}}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Town</th>
                                              <td>{{ $lead->town->name ?? ""}}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">City</th>
                                              <td>{{ $lead->city->name ?? ""}}</td>
                                          </tr>
                                          <tr>
                                              <th scope="row">Address</th>
                                              <td>{{ $lead->address ?? ""}}</td>
                                          </tr>
                                          <th scope="row">Locality</th>
                                          <td>{{ $lead->locality ?? ""}}</td>
                                          </tr>
                                          <th scope="row">Landmark</th>
                                          <td>{{ $lead->landmark }}</td>
                                          </tr>
                                          <th scope="row">Pincode</th>
                                          <td>{{ $lead->pincode ?? ""}}</td>
                                          </tr>
                                        </tbody>
                                    </table>
                                  </div>
                              </div>
                            </div>
                        </div>
                      </div>
                  </div>
                </div>
            </div>
          </div>
          <div id="nav_contacts" class="container tab-pane fade">
            <br>
            <div id="contactsIndex"> </div>
          </div>
          <div id="nav_comments" class="container tab-pane fade">
            <br>
            <div class="" id="comments">
            </div>
          </div>
          <div id="nav_images" class="container tab-pane fade">
            <br>
            <div class="" id="images">
            </div>
          </div>
          <div id="nav_convert" class="container tab-pane fade">
            <br>
            <div class="" id="convertIndex">
            </div>

          </div>
          <div id="nav_social" class="container tab-pane fade">
            <br>
            <div class="" id="socialMediaIndex">

            </div>

          </div>
      </div>
    </div>
</div>
</div>
<!---card Body Div close-->
</div>


       
@endsection
@section('script')
<script>
    $(document).ready(function(){
        getComments();
        getImages();
    });

    function getComments(){
        var leadId = "{{ $lead->id }}";
        var url = "{{ route('lead.comment.all',['/']) }}/"+leadId;
        $.get(url,function(data){
            $("#comments").html(data);
        });
    }

    function storeComment(){
       
        $.ajax({
          url: "{{route('lead.comment.store')}}",
          method : "POST",
          data : $("#commentForm").serialize(),
          success : function(data){
            if(data.errors){
                $.each(data.errors,function(field_name,error){
                        $(document).find('[name='+field_name+']').after('<span class="text-strong text-danger">' +error+ '</span>')
                        $(document).find('[name='+field_name+']').addClass('input-error')
            }); 
            setTimeout(hideErrors,8000); 
          }else{
             notify('Lead Comment Saved','success');
              getComments();
            
          }
       },
         });
    }

  function hideErrors(){ 
  $(".text-danger").remove(); 
  $('input').removeClass('input-error');
  $('textarea').removeClass('input-error');
  $('select').removeClass('input-error');
}

    function editComment(commentId){
        var url = "{{ route('lead.comment.edit',['/']) }}/"+commentId;
        
        $.get(url,function(data){
        //    console.log(data);
            $("#editComment").html(data);
        });
    }

    function updateComment(){
        $.ajax({
          url: "{{ route('lead.comment.update') }}",
          method : "POST",
          data : $("#editCommentForm").serialize(),
          success : function(data){
             notify('Lead Comment Updated','success');
                $("#editComment").html('');
                getComments();
          }
        });
    }

    //Images
    

    function getImages(){
        var leadId = "{{ $lead->id }}";
        var url = "{{ route('lead.image.all',['/']) }}/"+leadId;
        $.get(url,function(data){
            $("#images").html(data);
        });
    }

    function viewImage(viewImage){

      var url = "{{ route('lead.image.view',['/']) }}/"+viewImage;
        
        $.get(url,function(data){
        //    console.log(data);
            $("#viewImage").html(data);
        });

    }



   function editLead(leadId)
   {
      var url = "{{route('lead.edit',['/'])}}/"+leadId;
      
      $.get(url, function(data){
       
            $('#edit').html(data);
            var offset = $("#edit").offset();
         $('html, body').animate({
            scrollTop: offset.top,
            scrollLeft: offset.left
         }, 1000);
      });
   }

   function assign(){
       var leadId = "{{ $lead->id }}";
       var url = "{{ route('lead.assign',['/']) }}/"+leadId;
       $.get(url,function(data){
           $("#assign").html(data);
       });
   }

   function assignSave(){
       $.ajax({
          url : "{{ route('lead.assignSave') }}",
          method : "POST",
          data : $("#leadAssignForm").serialize(),
          success : function(data){
            //   $("#modal-1").removeClass('md-show');
            $("#assign").html('');
              notify('Lead Assigned SuccessFully','success');
              location.reload();
          }
       });
   }

   function contactsIndex(){
       var url = "{{ route('leadContact.index',['/']) }}/"+"{{ $lead->id }}";
       $.get(url,function(data){
           $("#contactsIndex").html(data);
       });
   }

   function convertIndex(){
      
      var url ="{{ route('leadtostore.index',['/']) }}/"+"{{$lead->id}}"; 
        $.get(url,function(data){
           $("#convertIndex").html(data);
        });
   }

   function leadSocialIndex(){
      
      var url ="{{ route('leadSocial.index',['/']) }}/"+"{{$lead->id}}"; 
        $.get(url,function(data){
           $("#socialMediaIndex").html(data);
        });
   }


</script>
@endsection


 