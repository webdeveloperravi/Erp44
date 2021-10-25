<div id="Colour_{{$cat_id}}" style="display: none" class="list" >

<form action="{{route('product.cat.assign.color')}}"   method="post" class="form">
@csrf
<h5 class="msg">Color</h5>
<input type="hidden" name="cat_id" value="{{$cat_id}}">
<input type="hidden" name="type" value="colors">
<div class="row"> 		
<div class="col-sm" >
<!-- <h3> Select <- </h3>  -->
<span>Selected <i class="fas fa-arrow-down"></i></span>
<ul id='color_{{$cat_id}}_right'> 
@forelse($assigned_color->sortBy('color') as $assignKey => $assignVal) 
<li onclick="move('c_'+{{$cat_id}}{{$assignVal->id}}, 'color_'+{{$cat_id}}+'_')" direction="left" id="c_{{$cat_id}}{{$assignVal->id}}" class="z-depth-0 p-2 m-2 sel" style="background-color: darkseagreen;
opacity: 1.5;"> 

{{$assignVal->color}}

<input class="c_{{$cat_id}}{{$assignVal->id}}"  type="hidden" name="attach[]" value="{{$assignVal->id}}"> 
</li>
@empty 

@endforelse

</ul>



</div>
<div class="col-sm" > 

<!-- 	<h3> Un Select -> </h3> -->
<span>Unselected <i class="fas fa-arrow-down"></i></span>
<ul id="color_{{$cat_id}}_left">
@foreach($color->sortBy('color')->whereNotIn('id',$assigned_color->pluck('id')) as $coKey =>$coVal)
<li onclick="move('c_'+{{$cat_id}}{{$coVal->id}}, 'color_'+{{$cat_id}}+'_' )" direction="right" id="c_{{$cat_id}}{{$coVal->id}}" class="z-depth-0 p-2 m-2 unsel" style="background-color: lavender;
opacity: 1.5;"> 

{{$coVal->color}} 

<input class="c_{{$cat_id}}{{$coVal->id}}" type="hidden" name="dettach[]" value="{{$coVal->id}}"> 
</li>
@endforeach
</ul>



</div>


</div>	
<div class="row">
<div class="align-self-center mx-auto">
<input type="submit" name=""class="btn  m-t-5 btn-success btn-sm" value="Attach Color">
</div>
</div>
</form>
</div>