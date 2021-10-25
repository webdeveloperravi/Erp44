<form onsubmit="event.preventDefault(0)" id="zoneAttachForm">
    @csrf 
       
                   <input type="hidden" name="managerId"  value="{{ $manager->id }}">
                   <div class="row justify-content-center">
                      <div class="col-sm-12 col-xl-6 m-b-30">
                         <select id='custom-headers' class="searchable" multiple='multiple' name="zones[]">
                            @foreach ($manager->managerZones as $zone)
                            <option value="{{$zone->id }}" selected>{{ $zone->name }}</option>
                            @endforeach
                            @foreach ($zones as $zone) 
                            <option value="{{$zone->id }}">{{ $zone->name }}</option>
                            @endforeach 
                         </select>
                      </div>
                   </div>
                   <div class="row justify-content-center">
                      <div class="col-sm-12 col-xl-6"> 
                         <button onclick="attachZones()" class="btn btn-dark float-right">Submit</button> 
                      </div>
                   </div> 
 </form>
 <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/select2/js/select2.full.min.js"></script>
 <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
 <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/multiselect/js/jquery.multi-select.js"></script>
 <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/js/jquery.quicksearch.js"></script>
 <script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/pages/advance-elements/select2-custom.js"></script>