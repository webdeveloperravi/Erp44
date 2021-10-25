<table class="table table-bordered tbl_tax_type_list">
    <thead>
        <tr>
          <th>Sr.No.</th>
          <th>Name</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      @if($tax_type_list->isEmpty())
     <td colspan="5"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
      @else
        @foreach($tax_type_list as $tl_key => $tl_val)
        
        <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{strtoupper($tl_val->name)}}</td>
      @if($tl_val->status==0)
       <td class="text-warning">In-active</td>
        @else
        <td class ="text-success">Active</td>
        @endif
        <td>
          <button class="btn btn-warning btn-sm p-1" onclick="changeStatus({{$tl_val->id}},'{{$tl_val->status}}')"  style="width:60px;">{{($tl_val->status==1?"In-active":"Active")}}</button>
    <button class="btn btn-sm btn-primary p-1 " onclick="editTaxType({{$tl_val->id}},'{{$tl_val->name}}')" style="width:60px;"> edit</button>
 

         
         
      </tr>

        </tr>

        @endforeach
      @endif
    </tbody>

  </table>