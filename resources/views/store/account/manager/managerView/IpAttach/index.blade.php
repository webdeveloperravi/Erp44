<div class="row justify-content-center">
    <div class="col-md-12">
       <div class="card">
          <div class="card-footer p-0" style="background-color: #04a9f5">
             <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Attach IPs To :  ({{ $manager->name }})</h5>
          </div>
          <div class="card-block">
            <form onsubmit="event.preventDefault(0)" id="zoneAttachForm">
               @csrf  
               @php
                   $oldIds = $manager->managerIps->pluck('id')->toArray();
               @endphp
               <input type="hidden" name="managerId"  value="{{ $manager->id }}">
               
               <div class="row justify-content-center">
                  {{-- <div class="col-sm-12 col-xl-3 m-b-30">
                     <span class="text-danger">
                        Not Atached
                     </span>
                  </div> --}}
                   
                  <div class="col-sm-12 col-xl-5 m-b-30">  
                     <div class="row justify-content-center">
                        <div class="col-6">
                           <span class="text-danger">
                              Not Attached
                           </span>
                        </div>
                        <div class="col-6">
                           <span class="text-success">
                              Attached
                           </span>
                        </div>
                     </div>
                     <select id='custom-headers' class="searchable" multiple='multiple' name="zones[]"> 
                        @foreach ($ips as $ip) 
                        <option value="{{$ip->id }}" {{ in_array($ip->id,$oldIds) ? 'selected' : '' }}>{{ $ip->ip_address }}</option>
                        @endforeach 
                     </select>
                     <div class="row justify-content-center mt-2">
                        <div class="col">
                           <input id="ip_blocking" type="checkbox" name="ip_blocking" {{ $manager->ip_blocking == 1 ? 'checked' : ''}}>
                           <label for="ip_blocking">Enable IP Blocking : </label>
                        </div>
                     </div>
                  </div> 
               </div> 
               <div class="row justify-content-center">
                  <div class="col-sm-12 col-xl-6"> 
                     <button onclick="attachZones()" class="btn btn-dark float-right">Submit</button> 
                  </div>
               </div> 
            </form>
   
          </div>
       </div>
    </div>
</div>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/pages/advance-elements/select2-custom.js"></script>
<script>


function attachZones(){
    var url = "{{ route('managerIpAttach') }}";
    $.ajax({
        method :"POST",
        url : url,
        data : $("#zoneAttachForm").serialize(),
        success: function(data){
           
        notify('Successfully Attached','success');

        }
    });
 }
 
   </script>