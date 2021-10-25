<div class="card">
<div class="card-footer p-0" style="background-color: #04a9f5">
  <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">All fluorescences</h5>
 </div>
 
  
  <div class="table-responsive ">
  <table class="table table-bordered table-hover ">
    <thead class="table-active">
      <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Alias</th> 
        <th>Description</th> 
        <th>status </th> 
        <th colspan="2">Action</th> 
      </tr>
    </thead>
    <tbody>
      @if($fluorescences->count() > 0)
       @foreach($fluorescences as $fluorescence)
      <tr class="text-center"> 

        <td><label>{{$loop->iteration}}</label></td>
        <td><label>{{$fluorescence->name}}</label></td>
        <td><label>{{$fluorescence->alias}}</label></td>
        <td><label>{{$fluorescence->description}}</label></td>
        <td class="{{ $fluorescence->status == 1 ? 'text-success' : 'text-danger' }}">{{ $fluorescence->status == 1 ? 'Active' : 'In-active' }}</td>
<td><a class="{{ $fluorescence->status == 1 ? 'btn btn-danger btn-sm p-1' : 'btn btn-success btn-sm p-1' }}" href="{{route('fluorescence.status',['id'=>$fluorescence->id])}}" style="width:60px;">{{$fluorescence->status == 1 ? 'Disable' : 'Enable' }}</a>  
 
        <td> <button class="btn btn-warning btn-sm " onclick="editFluorescence({{$fluorescence->id}})">Edit</button></td> 
      </tr>
      @endforeach
      @else
        <td colspan="5" class="text-center">No fluorescence</td>
      @endif 
      
    </tbody>
  </table>
  </div><!--******************Table End***************-->
 
</div>