<form onsubmit="event.preventDefault(0)" id="unitAttachForm">
    @csrf
<div class="row justify-content-center">
        <div class="col-md-12">
        <div class="card"> 
            <div class="card-footer p-0" style="background-color: #04a9f5">
                <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Attach Units  ({{ $productCategory->name }})</h5>
               </div>  
        <div class="card-block">
           
         <input type="hidden" name="productCategoryId" id="productCategoryId" value="{{ $productCategory->id }}">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col">
             <h1 class="text-danger">UnSelected</h1> 

                </div> 
             </div>
        <div class="col-sm-12 col-xl-6 m-b-30"> 
        <select id='custom-headers' class="searchable" multiple='multiple' name="units[]">
            @foreach ($productCategory->units as $unit)
                
            <option value="{{$unit->id }}" selected>{{ $unit->name }}</option>  
            @endforeach
        @foreach ($units->sortBy('name') as $unit) 
        <option value="{{$unit->id }}">{{ $unit->name }}</option>
       
         @endforeach 
        </select>
        </div>
        <div class="row">
            <div class="col">
         <h1 class="text-success">Selected</h1> 

            </div> 
         </div>
    </div>
    
    <div class="row justify-content-center">
        <div class="col-sm-12 col-xl-6"> 
                <button onclick="attachUnits()" class="btn btn-dark float-right">Submit</button> 
        </div>
    </div>
        </div>

        </div>
        </div>
    </div>
    

</form> 
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/bower_components/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="https://colorlib.com//polygon/adminty/files/assets/pages/advance-elements/select2-custom.js"></script> 
