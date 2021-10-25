<table class="table table-bordered tbl_unit_conversion_list">
    <thead>
        <tr>
          <th>Sr.No.</th>
          <th>Main Unit</th>
          <th>Sub Unit</th>
          <th>Conversion Factor</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      @if($unit_conv_list->isEmpty())
     <td colspan="7"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
      @else
        @foreach($unit_conv_list as $ucl_key => $ucl_val)
        
        <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$ucl_val->assigned_main_unit->name}}</td>
        <td>{{$ucl_val->assigned_sub_unit->name}}</td>
        <td>{{$ucl_val->conversion}}</td>
      @if($ucl_val->status==0)
       <td class="text-warning">In-active</td>
        @else
        <td class ="text-success">Active</td>
        @endif
        <td>
          <button class="btn btn-warning btn-sm p-1" onclick="changeStatus({{$ucl_val->id}},'{{$ucl_val->status}}')"  style="width:60px;">{{($ucl_val->status==1?"In-active":"Active")}}</button>
    <button class="btn btn-sm btn-primary p-1 " onclick="editUnitConversion({{$ucl_val->id}})" style="width:60px;"> edit</button>
 

         
         
      </tr>

        </tr>

        @endforeach
      @endif
    </tbody>

  </table>