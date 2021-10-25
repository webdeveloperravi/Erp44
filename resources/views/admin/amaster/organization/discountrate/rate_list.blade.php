<table class="table table-bordered tbl_discount_list">
    <thead>
        <tr>
          <th>Sr.No.</th>
          <th>Name</th>
          <th>Rate</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      @if($discount_list->isEmpty())
     <td colspan="5"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
      @else
        @foreach($discount_list as $dl_key => $dl_val)
        
        <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{strtoupper($dl_val->name)}}</td>
       <td>{{strtoupper($dl_val->rate)}}%</td>
      @if($dl_val->status==0)
       <td class="text-warning">In-active</td>
        @else
        <td class ="text-success">Active</td>
        @endif
        <td>
          <button class="btn btn-warning btn-sm p-1" onclick="changeStatus({{$dl_val->id}},'{{$dl_val->status}}')"  style="width:60px;">{{($dl_val->status==1?"In-active":"Active")}}</button>
    <button class="btn btn-sm btn-primary p-1 " onclick="editDiscountRate({{$dl_val->id}},'{{$dl_val->name}}',{{ $dl_val->rate}})" style="width:60px;"> edit</button>
 

         
         
      </tr>

        </tr>

        @endforeach
      @endif
    </tbody>

  </table>