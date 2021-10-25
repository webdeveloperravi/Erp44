@extends('layouts.admin.app')
@section('content')
<div class="container">
        
         <div class="card col-md-6 col-sm-6 offset-sm-3 offset-md-3 border-primary mb-4" style="max-width: 25rem;">
              <div class="row">
              <div class="col-4 col-sm-4 col-md-4"><a href="{{ url()->previous() }}" class="btn btn-outline-warning btn-sm p-1 m-t-10" style="width:60px">Back</a></div>
              <div class="col-8 col-sm-8 col-md-8">
              <h3 class="text-secondary text-uppercase text-info m-t-10">{{$pro_cat_info->name}}</h3>
              </div>
            </div>
              @php
            $check_unit =$pro_cat_unit->keyBy('unit_id');
             @endphp

             <div class="card-body">
                <form id="pro_cat_unit_form">
                @csrf
                  <input type="hidden" name="pro_cate_id" value="{{ $pro_cat_info->id }}">
                  <input type="hidden" name="assign" value="{{$assign}}">
               @foreach($units as $u_val)
                  @if(!empty($check_unit[$u_val->id]))
                  <div class="col-md-6 offset-md-4 offset-sm-4 offset-4">
                  <div class="form-check">
                  <input type="checkbox" name="unit[]" value="{{$u_val->id}}" checked="true" class="form-check-input"> <strong class="text-dark">{{$u_val->name}}</strong>
                  </div></div>
                  @else
                   <div class="col-md-6 offset-md-4 offset-sm-4 offset-4">
                   <div class="form-check">
                  <input type="checkbox" name="unit[]" value="{{$u_val->id}}" class="form-check-input"> <strong class="text-dark">{{$u_val->name}}</strong>
                   </div>
                 </div>
                  @endif
           @endforeach
           <div class="row">
             <div class="col-md-6 offset-md-4 offset-sm-4 offset-4">
           <input type="submit" id="btn-add-unit" value="Save" class="btn btn-sm btn-success m-t-10">
           </div>
         </div>
            </form>      
             </div>
             </div> 
           </div> 
         </div>

@section('script')

<script type="text/javascript">
	$("#btn-add-unit").click(function (event) {
		
     var form_data=$("#pro_cat_unit_form").serialize();
     event.preventDefault();

    $.ajax({

          url : '{{route('product.type.store.unit')}}',
          type : 'POST',
          data : form_data,
          success : function(res)
          {
             alert(res);
           window.location.href ="{{route('product-category') }}";
            
          }
 

       })

	});

</script>


@endsection
@endsection