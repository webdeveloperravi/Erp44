<table class="table table-bordered tbl_tax_rate_list">
    <thead>
        <tr>
          <th>Sr.No.</th>
          <th>Tax Type</th>
          <th>Rate</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      @if($tax_rate_list->isEmpty())
     <td colspan="5"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
      @else
        @foreach($tax_rate_list as $tr_key => $tr_val)
        
        <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$tr_val->AssignTaxType->name}}</td>
       <td>{{number_format($tr_val->rate, 2, '.', ',')}}%</td>
      @if($tr_val->status==0)
       <td class="text-warning">In-active</td>
        @else
        <td class ="text-success">Active</td>
        @endif
        <td>
          <button class="btn btn-warning btn-sm p-1" onclick="changeStatus({{$tr_val->id}},'{{$tr_val->status}}')"  style="width:60px;">{{($tr_val->status==1?"In-active":"Active")}}</button>
    <button class="btn btn-sm btn-primary p-1 " onclick="editTaxRate({{$tr_val->id}})" style="width:60px;"> edit</button>
 

         
         
      </tr>

        </tr>

        @endforeach
      @endif
    </tbody>

  </table>