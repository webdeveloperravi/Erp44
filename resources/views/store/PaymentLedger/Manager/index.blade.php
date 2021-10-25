@extends('layouts.store.app')
@section('content') 

<div class="card" id="form">
   <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Manager Payment Ledger</h5>
   </div>
   <div class="card-body">
      <div class="row">
         <div class="col col-md-4">
            <form id="createForm" onsubmit="event.preventDefault();">
               @csrf
               <div class="form-group"> 
                  <label for="ifscCode">Select Manager</label>
                  <select class="form-control js-example-basic-single " onchange="getLedger(this.value)"> 
                     <option value="0">Select Manager</option> 
                     @foreach ($accountGroups as $group)
                     
                     <optgroup label="{{ $group->name ?? "" }}">
                        @foreach ($managers as $manager)  
                        @continue($manager->id == auth('store')->user()->id)
                        @if ($manager->account_group_id == $group->id)
                           <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                        @endif
                        @endforeach
                     </optgroup>    
                     @endforeach  
                     
                  </select>

              


               </div>
            </form>
         </div>
      </div>
      
   </div>  
</div> 
<div id="all"></div>
@endsection
@section('script')
<script>   
   function getLedger(id){ 
      var url = "{{ route('managerPaymentLedger.all',['/']) }}/"+id;
      $.get(url,function(data){
         $("#all").html(data);  
      });
   }

  
</script>
@endsection