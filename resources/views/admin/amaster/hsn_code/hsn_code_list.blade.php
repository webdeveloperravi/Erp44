<table class="table table-bordered tbl_hsn_code">
    <thead>
        <tr>
          <th>Sr.No.</th>
          <th>HSN-Code</th>
          <th>Descripion</th>
          <th>Assigned Tax Rate</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      @if($hsn_code->isEmpty())
     <td colspan="5"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
      @else
        @foreach($hsn_code as $key => $val)
        
        <tr>
           <td>{{$loop->iteration}}</td> 
           <td>{{$val->hsn_code}}</td>
           <td style="white-space: inherit;">{{$val->description}}</td>
           <td>{{$val->hsnCode->assign_tax_rate->rate ?? ''}}%</td>
         <td>
          @if ($val->status == 1)
          <button class="btn btn-warning btn-sm p-1 float-right" onclick="changeStatus({{$val->id}},'{{$val->status}}')"  style="width:60px;">Disable</button>
          @else
          <button class="btn btn-success btn-sm p-1 float-right" onclick="changeStatus({{$val->id}},'{{$val->status}}')"  style="width:60px;">Enable</button>
          @endif
      
        </td>  
        <td> 
     <button class="btn btn-sm btn-primary p-1 " onclick="edit_hsn_code({{$val->id}},'{{$val->hsn_code}}',`{{$val->description}}`)" style="width:auto;"> edit</button>
     <a href="{{route('hsn.code.assign.rate',['id'=>$val->id,'hsncode'=>$val->hsn_code])}}" class="btn btn-sm btn-success p-1" style="width: auto"> Assign </a>{{-- 
     <button class="btn btn-sm btn-success p-1 " onclick="edit_hsn_code({{$val->id}})" style="width:auto;">Assign</button> --}}
   

         
         
      </tr>

        </tr>

        @endforeach
      @endif
    </tbody>

  </table>