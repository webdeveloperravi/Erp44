
 
 <div class="card" id="form">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Manager Verify Account</h5>
     </div>
    
    <div class="card-body">

    <form id="createForm" onsubmit="event.preventDefault();">
    
        @csrf
        <input type="hidden" name="managerId" value="{{ $manager->id }}">
       <div class="row">
        <div class="col-xl-4 col-md-12 col-12 mb-1">
        <div class="form-group">
            <label for="basicInput">Email</label> 
            @if ($manager->email_verify)
            <i class="fa fa-check text-success"></i>
            <label class="label label-success">Verified</label>
            @else
            <i class="fa fa-times text-danger"></i>
            <label class="label label-danger">Not Verified</label>
            @endif
            <input name="name" type="email" class="form-control" value="{{ $manager->email }}" readonly/>
        </div>
        </div> 
        </div>
    
        <div class="row">
        <div class="col-xl-4 col-md-6 col-12 mb-1">
        <div class="form-group">
            <label for="basicInput">Phone</label>
            @if ($manager->phone_verify)
            <i class="fa fa-check text-success"></i>
            <label class="label label-success">Verified</label>
            @else
            <i class="fa fa-times text-danger"></i>
            <label class="label label-danger">Not Verified</label>
            @endif
            <input  id="phone" type="text" class="form-control" value="{{ $manager->phone }}"  readonly/>
        </div>
        </div>
        </div>
    
        @if (!$manager->email_verify || !$manager->phone_verify)
        <div class="row"> 
            <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group "> 
                    <button class="btn btn-sm btn-dark" onclick="sendOtp()">Send Verification Link</button>
                </div>
             </div>  
        </div>
        @else
        <div class="row"> 
            <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group "> 
                    {{-- <button class="btn btn-sm btn-success"><i class="fa fa-check text-white"></i>Converted to Store</button> --}}
                    <a href="{{ route('store.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-arrow-left"></i>Back to All Stores</a>
                </div>
             </div>  
        </div>
        @endif
       </form>
    </div>
 </div>
 <script>
    
    function sendOtp(){
        // $("#verificationComponent").LoadingOverlay("show");
        sendEmail({{ $manager->id }});         
        getSmsToken({{ $manager->id }});
    }

    function sendEmail(id){
        $.ajax({
           url: "{{ route('manager.account.sendemail',['/']) }}/"+id,
           method : "POST",
           data : $("#createForm").serialize(),
           success: function(data){ 
            }
        });
    }

    function getSmsToken(leadId){ 
        var url ="{{ route('manager.account.getsmstoken',['/']) }}/"+leadId; 
        $.get(url,function(data){
        if(data.success){
             
        }else{
            // $("#verificationComponent").LoadingOverlay("hide", true);
            sendSms(data.token);
        }
        
        });
    }

    function sendSms(token){
        var url = "{{ route('manager.account.verifyphone',['/']) }}/"+token;
       var  body = JSON.stringify(
    {
        "messages": [
            // {
            //     "channel": "whatsapp",
            //     "to": "9803462078",
            //     "content": "Test WhatsApp Message Text"
            // },
            {
                "channel": "sms",
                "to": $("#phone").val(),
                "content": "Verify Link To Create New Store "+url,
            }
        ]
          }
        );

      $.ajax({
         url: "https://platform.clickatell.com/v1/message",
         method :"POST",
         dataType: 'json',
         headers:{
            "Authorization" : "qSrGgsZCQYOIf9WTP6He_w==",
            "Content-Type" : "application/json"
         },
         data : body
      });
    }
</script> 