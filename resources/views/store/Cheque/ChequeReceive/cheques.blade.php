{{-- @foreach ($cheques as $cheque)
 <div class="col-xl-12 col-md-12 col-12 mb-1">
    <div class="border-checkbox-section">
       <div class="border-checkbox-group border-checkbox-group-info">
          <input class="border-checkbox" name="cheques[]" value="{{ $cheque->id }}" type="checkbox" id="checkbox{{ $cheque->id }}">
          <label class="border-checkbox-label" for="checkbox{{ $cheque->id }}">{{ $cheque->number }}</label>
       </div>
    </div>
 </div> 
 @endforeach --}}
 @if (count($cheques))
 <div class="table-responsive">
   <table class="table" id="table_id2" style="width:100"> 
      <thead>
         <tr>
           <th>Select</th> 
           <th>UID</th> 
           <th>Number</th> 
           <th>Amount</th>  
         </tr>
      </thead>
       <tbody>
         @foreach($cheques as $cheque)
         <tr class="text-center"> 
            <td>
               <div class="border-checkbox-section">
                  <div class="border-checkbox-group border-checkbox-group-info">
                     <input class="border-checkbox" name="cheques[]" value="{{ $cheque->id }}" type="checkbox" id="checkbox{{ $cheque->id }}">
                     <label class="border-checkbox-label" for="checkbox{{ $cheque->id }}"></label>
                  </div>
               </div>
            </td>
           <td><label>{{$cheque->id}}</label></td> 
           <td><label>{{$cheque->number}}</label></td> 
           <td><label>{{$cheque->amount}}</label></td>  
         </tr>
         @endforeach 
       </tbody> 
   </table>
  </div>
  <div class="row">
   <div class="col-xl-4 col-md-6 col-12 my-auto">
      <div class="form-group mt-lg-4"> 
         <button class="btn btn-success" onclick="save()">Confirm</button>
         <button class="btn btn-danger" onclick="($('#create').html(''))">Cancel</button>
      </div>
   </div>
</div>
 @else
 <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
 @endif