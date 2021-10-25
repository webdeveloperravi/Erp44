<div class="col-md-12">
<form id="createForm" onsubmit="event.preventDefault();">
    @csrf
    <input type="hidden" name="leadId" value="{{ $lead->id }}">
   <div class="row">
    <div class="col-xl-4 col-md-12 col-12 mb-1">
    <div class="form-group">
        <label for="basicInput">Email</label> 
        @if ($lead->email_verify)
        <i class="fa fa-check text-success"></i>
        <label class="label label-success">Verified</label>
        @else
        <i class="fa fa-times text-danger"></i>
        <label class="label label-danger">Not Verified</label>
        @endif
        <input name="name" type="email" class="form-control" value="{{ $lead->email }}" readonly/>
    </div>
    </div> 
    </div>

    <div class="row">
    <div class="col-xl-4 col-md-6 col-12 mb-1">
    <div class="form-group">
        <label for="basicInput">Phone</label>
        @if ($lead->phone_verify)
        <i class="fa fa-check text-success"></i>
        <label class="label label-success">Verified</label>
        @else
        <i class="fa fa-times text-danger"></i>
        <label class="label label-danger">Not Verified</label>
        @endif
        <input  id="phone" type="text" class="form-control" value="{{ $lead->getPhoneWithCode($lead->id) }}"  readonly/>
    </div>
    </div>
    </div>

    @if (!$lead->email_verify || !$lead->phone_verify)
    <div class="row"> 
        <div class="col-xl-4 col-md-6 col-12 my-auto">
            <div class="form-group "> 
                <button class="btn btn-sm btn-dark" onclick="sendOtp()"><i class="fa fa-sign-in"></i>Send Verification Link</button>
                <button class="btn btn-sm btn-primary" onclick="refreshVerificationComponent()"><i class="fa fa-refresh"></i>Refresh</button>
            </div>
         </div>  
        </div>
    @else
    <div class="row">
        <div class="col-xl-4 col-md-6 col-12 mb-1">
        <div class="form-group">
            <label for="basicInput">Store Role</label>
            <input type="hidden" id="orgRole" value="{{ $orgRole->id }}}">
            <input  type="text" class="form-control" value="{{ $orgRole->name }}"  readonly/>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6 col-12 mb-1">
        <div class="form-group">
            <label for="basicInput">Sub Domain</label>
            <input  type="text" id="subdomain" name="subdomain" class="form-control" value="{{str_replace(' ', '', substr($lead->company,0,8))}}.{{$_SERVER['SERVER_NAME']}}"  readonly/>
        </div>
        </div>
    </div>
    @if($lead->converted_to_store == 1)
    <div class="row"> 
        <div class="col-xl-4 col-md-6 col-12 my-auto">
            <div class="form-group "> 
                <button class="btn btn-sm btn-success"><i class="fa fa-check text-white"></i>Converted to Store</button>
                <a href="{{ route('lead.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i>Back to Leads</a>
            </div>
         </div>  
    </div>
    @else
    <div class="row"> 
        <div class="col-xl-4 col-md-6 col-12 my-auto">
            <div class="form-group "> 
                <button class="btn btn-sm btn-dark" onclick="convertToStore()">Convert to Store</button>
            </div>
         </div>  
    </div>
    @endif
    @endif
   </form>

</div> 
<script>
    
function convertToStore(){ 

    $.ajax({
        method: "POST",
        url: "{{ route('leadtostore.convert') }}",
        data : {
            _token: "{{ csrf_token() }}",
            leadId : "{{ $lead->id }}",
            orgRoleId : "{{$orgRole->id }}",
            subdomain : $("#subdomain").val(),
        },
        success:function(data){ 
            if(data.exist){
                swal(data.msg);
            }
            if(!data.success){
                notify('Email Noit Found','danger');
            }

            getVerificationStatus('{{$lead->id }}');
        }
    });
}
</script>