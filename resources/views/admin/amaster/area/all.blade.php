{{-- 
<div class="card-header">
  <button onclick="createArea({{$zoneId}})" class="btn btn-dark">Add Area</button>
</div> --}}
<div class="card">
  <div class="card-body">
  <div class="card-footer p-0" style="background-color: #04a9f5">
   <div class="row">
     <div class="col-md-10">
      <h5 class="text-white m-b-0 text-center pt-2 pl-3">All Areas ({{ucfirst($zone->name ) }})</h5>
     </div>
     <div class="col-md-2">
      <button onclick="createArea({{$zoneId}})" class="btn btn-dark my-0 float-right">Add Area</button>
     </div>
   </div>
   </div> 
  <div class="table-responsive ">
  <table class="table table-bordered table-hover ">
    <thead class="table-active">
      <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Alias</th> 
        <th>Description</th> 
        <th>Actions</th> 
      </tr>
    </thead>
    <tbody>
      
       @foreach($areas as $area)
      <tr class="text-center"> 

        <td><label>{{$loop->iteration}}</label></td>
        <td><label>{{$area->name}}</label></td>
        <td><label>{{$area->alias}}</label></td>
        <td><label>{{$area->description}}</label></td>
        <td> <button class="btn btn-warning" onclick="editArea({{$area->id}})">Edit</button></td> 
      </tr>
      @endforeach 
      
    </tbody>
  </table>
  </div><!--******************Table End***************-->
</div>
</div>
<div id="createArea"></div>
<div id="editArea"></div>
<script type="text/javascript">
   function createArea(zoneId){
     var url ="{{route('area.create',['/'])}}/"+zoneId;
     $.get(url,function(data){
        $("#createArea").html(data);
     });
   }

  function editArea(areaId){ 
    var url ="{{route('area.edit',['/'])}}/"+areaId;
   $.get(url,function(data){
       $("#editArea").html(data);
   });
}

function closeArea(){
   $("#createArea").html("");
}
</script>