@if($products[0]->alreadyGenerated($gradeId,$ratti->id))
{{-- <a onclick="packetList({{ $gradeId }})" class="btn btn-success mb-3 text-white">Already Generated </a> --}}
   {{-- <div class="col" id="packetList">
      </div> --}}
      <div class="col-sm-12 col-md-12 mb-2" >
         <h4 class="text-center text-success">Already Created</h4>
         <div class="progress">
             
             <div class="progress-bar progress-bar-emrald" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
             </div>
     </div>
@else
<div class="card-body content">
   <div class="row">
      <div class="col-md-6 col-lg-3">
         <div class="card statustic-card">
            <div class="card-block text-center p-0">
               <span class="d-block text-c-blue f-28">{{ $ratti->rati_standard }}</span> 
            </div>
            <div class="card-footer" style="background-color: #04a9f5">
               <h6 class="text-white m-b-0 text-center">Ratti</h6>
            </div>
         </div>
      </div>
      <div class="col-md-6 col-lg-3">
         <div class="card statustic-card">
            <div class="card-block text-center p-0">
               <span class="d-block text-c-yellow f-28">{{ count($products) }}</span>
               {{-- 
               <p class="m-b-0">Left Pieces</p>
               --}}
            </div>
            <div class="card-footer bg-c-yellow">
               <h6 class="text-white m-b-0 text-center">Total Pieces</h6>
            </div>
         </div>
      </div>
   </div> 
   <div class="row">
      <div class="col-md-6">
         <div class="table-responsive">
            <table class="table">
               <thead>
                  <tr class="table-active text-center">
                     <th>Sr.</th>
                     <th>UID</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach ($products as $product)
                  <tr id="myTable" class="text-center">
                     <td>{{ $loop->iteration }}</td>
                     <td>{{ $product->id }}</td>
                  </tr>
                  @endforeach 
               </tbody>
            </table>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col"> 
         @if(\App\Helpers\CheckPermission::instance()->viewAction('make-packets')) 
         <a onclick="makePackets({{ $ratti->id }},{{ $gradeId }})"  class="btn btn-inverse float-right text-white"><i class="icofont icofont-exchange"></i>Make Packets</a>
         
         @endif 
      </div>
      {{-- <div class="col" id="packetList">
      </div> --}}
   </div>
</div>
<div id="loader"></div>
@endif
<script>


</script>