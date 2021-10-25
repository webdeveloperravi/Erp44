@foreach ($retailModels->subRetailModels as $model)
<option value="{{$model->id}}" class="text-dark font-weight-normal">
&nbsp;&nbsp;&nbsp;&nbsp;{{$model->name}} 
</option> 
@includeWhen($model->subRetailModels->count() > 0,'admin.amaster.organization.org_role_config.retail_model_options',['retailModels'=>$model] )
@endforeach
</ul>