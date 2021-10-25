 @php 
use Carbon\Carbon;
@endphp  
<div class="row">
    <div class="col-sm-12"> 
            <div class="card-footer p-0" style="background-color: #04a9f5">
                <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Packaging Process</h5>
             </div>
        </div> 
    
</div>
@php
    // dd($rattis);
@endphp
    <div class="row">
        <div class="col-md-12">
            <div class="card"> 
             <div class="card-block"> 
                <div class="row justify-content-center">
                    @if($rattis->count() !== 0)
                    <div class="col-sm-12 col-md-4 col-xl-4">
                    <h4 class="sub-title mb-0">Select Ratti</h4>
                    <select name="ratti_id" id="ratti_id" class="form-control ">
                        <option selected value="0" >Select Ratti</option>
                    @foreach ($rattis as $ratti)
                    <option value="{{ $ratti->id }}">{{ $ratti->rati_standard }}</option> 
                    @endforeach
                    </select>
                    </div>
                    @else 
                    <div class="col-sm-12 col-md-6">
                        <h4 class="text-center text-success">Packaging Complete</h4>
                        <div class="progress">
                            <div class="progress-bar progress-bar-emrald" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                    </div>
                    @endif
                    <div class="col-sm-12 col-md-12 mt-4" id="ssc" style="display: none">
                        <h4 class="text-center text-success">Packet Created</h4>
                        <div class="progress">
                            
    <div class="progress-bar progress-bar-emrald" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                    
                </div>
            </div>
             <div class="col-md-12 content_two">
                
            </div> 
            </div>
        </div>  
    </div> 
    <div id="packetList"> 
        
    </div>  
             
<script>
    $(document).ready(function(){
    // alert('saab');
    var gradeId = "{{ $gradeId }}"; 
    packetList(gradeId);
    });

 
    $('#ratti_id').on('change',function(){
        // alert("Saab");
        $("#ssc").hide();
        var rattiId = $(this).val();
        var gradeId = "{{ $gradeId }}";
        var url = "{{ route('manager.challan.packet.create',['/','/']) }}/"+rattiId+'/'+gradeId; 
        $.get(url,function(data){ 
           if(data == 'no'){ 
           $(".content_two").html("");
           }else{
           $(".content_two").html(data);
           packetList({{ $grade->id }});
           }
        });
    }); 

   function packetList(gradeId){
       var url = "{{ route('manager.challan.packet.list',['/']) }}/"+gradeId;
       $.get(url,function(data){
         $("#packetList").html(data);
       });
   }

   function makePackets(rattiId,gradeId){
      var url = "{{ route('manager.challan.packet.store',['/','/']) }}/"+rattiId+"/"+gradeId;
      $(".content").LoadingOverlay("show"); 
      $.get(url,function(data){
       if(data == "success"){
          $(".content").LoadingOverlay("hide"); 
           packetList(gradeId);
           $("#ssc").show();
           $(".content_two").html("");
           $("#makePackets").click();
       }
      });
   }

   function returnToSuper(packetId){
    var url = "{{ route('packet.return',['/']) }}/"+packetId;
    var gradeId = "{{ $gradeId }}";
    // $("#packetList").LoadingOverlay("show");
    
    $.get(url,function(data){
        //   $("#packetList").LoadingOverlay("hide");
         packetList(gradeId);
      
    });
  }
</script> 