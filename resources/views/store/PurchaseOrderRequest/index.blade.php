@extends('layouts.store.app')
@section('content') 
 
<div class="card"> 
<div class="card-footer p-0" style="background-color: #04a9f5">
    <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Purchase Order Requests</h5>

</div>
 <div class="card-body"> 
  <div class="row">
    <div class="col col-md-4"> 
          <div class="form-group"> 
             <label for="ifscCode">Select Account</label>
             <select class="form-control" id="userId" onchange="all2()">  
                <option value="all">All</option>
                <option value="{{ auth('store')->user()->id }}" selected>Current Only</option>
                @foreach ($managers as $manager)  
                <option value="{{ $manager->id }}">{{ $manager->name }}</option> 
                @endforeach
             </select>
          </div> 
    </div>
 </div> 
   <div id="all"></div>
    
</div>
</div>


 
@endsection
@section('script')
<script>
  $(document).ready(function () {
    all2();
  });

function all2(){ 
  
  var userId =$("#userId").val();
  var url = "{{ route('purchaseOrderRequest.all',['/']) }}/"+userId; 
      $.get(url,function(data){
         $("#all").html(data);
      });
}
</script>

@endsection