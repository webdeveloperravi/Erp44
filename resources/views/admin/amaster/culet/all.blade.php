<div class="card">
<div class="card-footer p-0" style="background-color: #04a9f5">
  <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All Culets</h5>
 </div>

  <div class="table-responsive ">
  <table class="table table-bordered table-hover ">
    <thead class="table-active">
      <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Alias</th> 
        <th>Description</th> 
        <th>status</th> 
        <th colspan="2">Action</th> 
      </tr>
    </thead>
    <tbody>
      @if($culets->count() > 0)
       @foreach($culets as $culet)
      <tr class="text-center"> 

        <td><label>{{$loop->iteration}}</label></td>
        <td><label>{{$culet->name}}</label></td>
        <td><label>{{$culet->alias}}</label></td>
        <td><label>{{$culet->description}}</label></td>
        <td class="{{ $culet->status == 1 ? 'text-success' : 'text-danger' }}">{{ $culet->status == 1 ? 'Active' : 'In-active' }}</td>
<td><a class="{{ $culet->status == 1 ? 'btn btn-danger btn-sm p-1' : 'btn btn-success btn-sm p-1' }}" href="{{route('culet.status',['id'=>$culet->id])}}" style="width:60px;">{{$culet->status == 1 ? 'Disable' : 'Enable' }}</a>  
 
        <td> <button class="btn btn-warning btn-sm " onclick="editCulet({{$culet->id}})">Edit</button></td> 
      </tr>
      @endforeach
      @else
        <td colspan="5" class="text-center">No Culet</td>
      @endif 
      
    </tbody>
  </table>
  </div><!--******************Table End***************-->
 
</div>