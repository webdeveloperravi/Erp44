<div class="card" id="form">
    <!--Header ---->
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Verification Account
      <button class="btn btn-danger btn-sm f-right m-r-2" onclick="$('#verifyAccount').html('')">Close</button>
      </h5>
     </div>
    
    <div class="card-body">
<form id="createForm" onsubmit="event.preventDefault();">
    @csrf
        <input type="hidden" name="accountId" value="{{$managerAccountId->id }}">
       <div class="row">
        <div class="col-xl-4 col-md-12 col-12 mb-1">
        <div class="form-group">
            <label for="basicInput">Email</label> 
            @if ($managerAccountId->email_verify)
            <i class="fa fa-check text-success"></i>
            <label class="label label-success">Verified</label>
            @else
            <i class="fa fa-times text-danger"></i>
            <label class="label label-danger">Not Verified</label>
            @endif
            <input name="name" type="email" class="form-control" value="{{$managerAccountId->email }}" readonly/>
        </div>
        </div> 
          
     
        <div class="col-xl-4 col-md-6 col-12 mb-1">
        <div class="form-group">
            <label for="basicInput">Phone</label>
            @if($managerAccountId->phone_verify)
            <i class="fa fa-check text-success"></i>
            <label class="label label-success">Verified</label>
            @else
            <i class="fa fa-times text-danger"></i>
            <label class="label label-danger">Not Verified</label>
            @endif
            <input  id="phone" type="text" class="form-control" name="phone" value="{{ $managerAccountId->getPhoneWithCode($managerAccountId->id) }}"  readonly />
        </div>
        </div>
      
    
        @if (!$managerAccountId->email_verify || !$managerAccountId->phone_verify)
      
            <div class="col-xl-2 col-md-6 col-12 my-auto">
                <div class="form-group "> 
                      <label for="basicInput"></label>
                    <button class="btn btn-sm btn-dark m-t-15" onclick="sendOtp()">Send Verification Link</button>
                </div>
             </div>  
    
          <div class="col-xl-2 col-md-6 col-12 my-auto">
                <div class="form-group "> 
                      <label for="basicInput"></label>
                       <button class="btn btn-sm btn-success m-t-15" onclick="refreshCompont('{{$managerAccountId->id}}')">Refresh</button>
                </div>
             </div>
    </div>
        @else
        <script> 
            location.reload();
        </script>
        @endif
       </form>
    </div>
 </div>
 <script>
     function sendOtp(){
       
       var email_verify = "{{$managerAccountId->email_verify}}";
       var phone_verify ="{{$managerAccountId->phone_verify}}";
     
       if(((email_verify != 1) && (phone_verify != 1)))
       {
        sendEmail('{{ $managerAccountId->id }}');
        getSmsToken('{{ $managerAccountId->id }}');
       }
       else if(email_verify !=1){
        
         sendEmail('{{ $managerAccountId->id }}');
        
          
       }
       else if(phone_verify !=1){
        // alert('phone');
          getSmsToken('{{ $managerAccountId->id }}');

       }
       else{
        
       }

       
    }

    function sendEmail(id){
        $.ajax({
           url: "{{ route('store.account.sendemail',['/']) }}/"+id,
           method : "POST",
           data : $("#createForm").serialize(),
           success: function(data){ 
            }
        });
    }

    function sendSms(token){
        var url = "{{ route('store.account.verifyphone',['/']) }}/"+token;
       var  body = JSON.stringify(
    {
        "messages": [
           
            {
                "channel": "sms",
                "to": $("#phone").val(),
                "content": "Verify Link To Create Manager Account "+url,
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
   

    function getSmsToken(Id){ 
        var url ="{{ route('store.account.getsmstoken',['/']) }}/"+Id; 
        $.get(url,function(data){
        if(data.success){
             
        }else{
            // $("#verificationComponent").LoadingOverlay("hide", true);
            sendSms(data.token);
        }
        
        });
    }

    
   function refreshCompont(id){
     verifyAccount(id);
   }

  
    
</script> 