 <ul class="listree-submenu-items">
  @foreach ($retailModels->subRetailModels as $model)
  <li style="margin-left:30px;" class="saab">
    <div class="listree-submenu-heading btn btn-block {{ $model->status == 0 ? "btn-danger" : "btn-inverse"}}  text-left mt-1">{{ $model->name }}
      {{-- <button class="btn btn-danger btn-sm p-1 float-right" onclick="changeStatus({{$model->id}})"  style="width:60px;">{{($model->status==1?"Disable":"Enable")}}</button> --}}
      <button class="btn btn-sm btn-warning p-1 ml-2 mr-1 float-right" onclick="edit({{$model->id}})" style="width:60px;"> Edit</button>
      @if ($model->status == 1)
      <button class="btn btn-danger btn-sm p-1 float-right" onclick="changeStatus({{$model->id}})"  style="width:60px;">Disable</button>
      @else
      <button class="btn btn-success btn-sm p-1 float-right" onclick="changeStatus({{$model->id}})"  style="width:60px;">Enable</button>
      @endif
      {{-- <button class="btn btn-sm btn-primary p-1 mr-1 float-right" onclick="view({{$model->id}})" style="width:60px;"> View</button> --}}
 
    </div> 
</li> 
@includeWhen($model->subRetailModels->count() > 0,'admin.amaster.organization.retail_model.sub_retail_model_list',['retailModels'=>$model])
@endforeach
</ul>




