<div class="card">
<div class="card-footer p-0" style="background-color: #04a9f5">
  <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Vouchers</h5>
 </div>
 
  
  <div class="table-responsive ">
  <table class="table table-bordered table-hover ">
    <thead class="table-active">
      <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Alias</th> 
        <th>Description</th> 
        <th colspan="2">Action</th> 
      </tr>
    </thead>
    <tbody>
      @if($vouchers->count() > 0)
       @foreach($vouchers as $vocher)
      <tr class="text-center"> 

        <td><label>{{$loop->iteration}}</label></td>
        <td><label>{{$vocher->name}}</label></td>
        <td><label>{{$vocher->alias}}</label></td>
        <td><label>{{$vocher->description}}</label></td>
        <td> <button class="btn btn-warning btn-sm " onclick="editVoucher({{$vocher->id}})">Edit</button></td> 
      </tr>
      @endforeach
      @else
        <td colspan="5" class="text-center">No Voucher</td>
      @endif 
      
    </tbody>
  </table>
  </div><!--******************Table End***************-->
 
</div>