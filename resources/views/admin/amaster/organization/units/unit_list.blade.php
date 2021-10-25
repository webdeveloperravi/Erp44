<table class="table table-bordered tbl_unit">
    <thead>
        <tr>
          <th>Sr.No.</th>
          <th>Name</th>
          <th>Alias</th>
          <th>Descripion</th>
          {{-- <th>UQC</th> --}}
          <th>Status</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      @if($unit_list->isEmpty())
     <td colspan="7"><h2 style="color:red; text-align: center;">No Record Found</h2></td>
      @else
        @foreach($unit_list as $ul_key => $ul_val)
        
        <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$ul_val->name}}</td>
        <td>{{$ul_val->alias}}</td>
        <td>{{($ul_val->description)}}</td>
         {{-- @if($ul_val->uqc=='')
       <td class="text-secondary">None</td>
        @else
        <td class ="text-secondary">{{ $ul_val->uqc }}</td>
        @endif --}}
      @if($ul_val->status==0)
       <td class="text-warning">In-active</td>
        @else
        <td class ="text-success">Active</td>
        @endif
        <td>
          <button class="btn btn-warning btn-sm p-1" onclick="changeStatus({{$ul_val->id}},'{{$ul_val->status}}')"  style="width:60px;">{{($ul_val->status==1?"In-active":"Active")}}</button>
    <button class="btn btn-sm btn-primary p-1 " onclick="editUnit({{$ul_val->id}},'{{$ul_val->name}}','{{$ul_val->alias  }}',`{{$ul_val->description}}`,`{{ $ul_val->uqc }}`)" style="width:60px;"> edit</button>
 

         
         
      </tr>

        </tr>

        @endforeach
      @endif
    </tbody>

  </table>