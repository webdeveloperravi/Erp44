@can('store-create', 'lead.index')
<div class="container-fluid">
   <div class="row justify-content-center" id="verificationComponent"> 
   </div>
   
   
</div> 
@endcan  
<script>
 $(document).ready(function(){
 
  getVerificationStatus('{{ $lead->id }}');
 });

 function getVerificationStatus(leadId){
    var url ="{{ route('leadtostore.checkverificationstatus',['/']) }}/"+leadId; 
        $.get(url,function(data){
           $("#verificationComponent").html(data);
        });
    
 }

    function sendOtp(){
        // $("#verificationComponent").LoadingOverlay("show");
       var email_verify = "{{$lead->email_verify}}";
       var phone_verify ="{{$lead->phone_verify}}";
     
       if(((email_verify != 1) && (phone_verify != 1)))
       {
       
          sendEmail();
          getSmsToken('{{ $lead->id }}');
       }
       else if(email_verify !=1){
          // alert('email');
          sendEmail();
        
          
       }
       else if(phone_verify !=1){
        //  alert('phone');
          getSmsToken('{{ $lead->id }}');

       }
       else{
        
       }
  
      
    }

    function sendEmail(){
        $.ajax({
           url: "{{ route('leadtostore.sendemail') }}",
           method : "POST",
           data : $("#createForm").serialize(),
           success: function(data){ 
            }
        });
    }

    function getSmsToken(leadId){ 
        var url ="{{ route('leadtostore.getsmstoken',['/']) }}/"+leadId; 
        $.get(url,function(data){
        if(data.success){
            
        }else{
            // $("#verificationComponent").LoadingOverlay("hide", true);

            sendSms(data.token);
        }
        
        });
    }

    function sendSms(token){
       var bind;
       var url = "{{ route('leadtostore.verifyphone',['/']) }}/"+token;
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
                "content":"Lead Verify Account to create New Store."+url,
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
    
    function refreshVerificationComponent(){
       contactsIndex("{{$lead->id}}");
        getVerificationStatus('{{ $lead->id }}');
    }


</script> 