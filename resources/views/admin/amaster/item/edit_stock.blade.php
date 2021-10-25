 <div class="col-md-12 col-sm-12">
        <div class="card" class="showForm" >
        <div class="card-header text-secondary"><h2>Edit Product Stock</h2></div>
        <div class="card-body">
        <div class="alert alert-danger alert-dismissible" style="display: none;" id="edit_error_item">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <ul id="edit_res"> </ul>
        </div>
        <form  enctype="multipart/form-data" id="edit_item_form">
				           @csrf
		<input type="hidden" name="item_id" value="{{$get_items->id}}">
	    <input type="hidden" name="category_id" value="{{$get_items->product_id}}">          
          <div class="form-group row">
		     <div class="offset-md-1 col-md-5 col-sm-6">
		     <label for="color">Product <span class="alert-danger">*</span></label>
		     <select   id="category_id"  name="product_type_id" class="form-control  @error('name') is-invalid @enderror" name="name"  disabled="">
                    	<option value="0">Select Product</option>
						@foreach($categories as $cat_key => $cat_val )
                                 <option value="{{$cat_val['id']}}" {{$cat_val->id == $get_items->product_id ? 'selected' :''}}>
								{{$cat_val['name']}}  
							</option> 
						@endforeach
			  </select>
			  <strong><span id="msg_product" style="color:red"></span></strong>
				   </div>
              <div class=" col-sm-6 col-md-5">
			  <label for="color">Length <span class="alert-danger">*</span></label>
			  <input id="edit_length" type="text" class="form-control only-numeric @error('length') is-invalid @enderror" name="length" value="{{number_format($get_items->length, 2, '.','')}}"  autocomplete="name" autofocus placeholder="Length">
			  <strong><span id="msg_length" style="color:red"></span></strong>
			  </div>
		</div>
           <div class="form-group row">
		          <div class="offset-md-1 col-sm-6 col-md-5">
				  <label for="color">Width <span class="alert-danger">*</span></label>
				  <input id="width" type="text" class="form-control only-numeric @error('width') is-invalid @enderror" name="width" value="{{number_format($get_items->width,2, '.','') }}"  autocomplete="name" autofocus  placeholder="Width">
		          <strong><span id="msg_width" style="color:red"></span></strong>
				  </div>
				  <div class="col-sm-6 col-md-5">
				  <label for="color">Depth <span class="alert-danger only-numeric">*</span></label>
				  <input id="depth" type="text" class="form-control only-numeric @error('length') is-invalid @enderror" name="depth" value="{{number_format($get_items->depth,2,'.','')}}"  autocomplete="name" autofocus  placeholder="Depth">
				   <strong><span id="msg_depth" style="color:red"></span></strong>
				  </div>
		   </div>

		   <div class="form-group row">
                <div class="offset-md-1 col-sm-6 col-md-5">
			    <label for="color">Weight <span class="alert-danger">*</span></label>
				<input id="weight" type="text" class="form-control only-numeric @error('length') is-invalid @enderror" name="weight" value="{{number_format($get_items->weight,2,'.','') }}"  autocomplete="name" autofocus  placeholder="Weight">
				<strong><span id="msg_weight" style="color:red"></span></strong>
		        </div> 
		         <div class="col-md-5 col-sm-6">
				<label for="color">Color <span class="alert-danger">*</span></label>
				<select name="color_id"  id="color_id" class="form-control  @error('color') is-invalid @enderror"  value="{{ old('color') }}"  autocomplete="color" autofocus>
				@foreach($res["color"] as $col_key => $cat_val )
                                 <option  value="{{$col_key}}" {{$col_key == $get_items->color_id ? 'selected' :''}}>
								 {{$cat_val}} 
							</option> 
						@endforeach
			   </select>
			   <strong><span id="msg_color" style="color:red"></span></strong>
               </div>
          </div>

          <div class="form-group row">
			   <div class="offset-md-1 col-sm-6 col-md-5">
               <label for="color">Clarity <span class="alert-danger">*</span></label>
		       <select name="clarity_id"  id="clarity_id" class="form-control  @error('clarity') is-invalid @enderror" name="name" value="{{ old('clarity') }}"  autocomplete="color" autofocus>
		       	@foreach($res["clarity"] as $clr_key => $clr_val )
                                 <option  value="{{$clr_key}}" {{$col_key == $get_items->clarity_id ? 'selected' :''}}>
								 {{$clr_val}} 
							</option> 
						@endforeach
			  
			   </select>
			   <strong><span id="msg_clarity" style="color:red"></span></strong>
			</div>
               <div class="col-md-5 col-sm-6">
               <label for="color">Grade <span class="alert-danger">*</span></label>
			   <select name="grade_id" id="grade_id" class="form-control  @error('grade') is-invalid @enderror"  value="{{ old('grade') }}"  autocomplete="color" autofocus>
			   	@foreach($res["grade"] as $grd_key => $grd_val )
                                 <option  value="{{$grd_key}}" {{$grd_key == $get_items->grade_id ? 'selected' :''}}>
								 {{$grd_val}} 
							</option> 
						@endforeach
			  
			   </select>
			   <strong><span id="msg_grade" style="color:red"></span></strong>
			   </div>
          {{--   <div class="col-sm-6 col-md-5">
            <label for="color">Rate Profile<span class="alert-danger">*</span></label>
             <p id="msg">lllll</p>
          <input id="rate_profile" type="text" class="form-control @error('length') is-invalid @enderror"  value="{{$get_items->assignRateProfile->id}}"  autocomplete="name" autofocus readonly="true">
          <span id="stand_rati">Stand Ratti</span> <span id="rati_rate">Rati Rate</span> <span id="mrp">MRP</span>
          <input id="profile_id" type="hidden" name="rate_profile_id">
        </div> --}}

         </div>

         <div class="form-group row">
			   <div class="offset-md-1 col-sm-6 col-md-5">
			   <label for="color">Origin <span class="alert-danger">*</span></label>
			    <select name="origin_id"  id="origin_id"  class="form-control  @error('origin') is-invalid @enderror"  value="{{ old('origin') }}"  autocomplete="color" autofocus>
			    	@foreach($res["origin"] as $org_key => $org_val )
                                 <option  value="{{$org_key}}" {{$org_key == $get_items->origin_id ? 'selected' :''}}>
								 {{$org_val}} 
							</option> 
						@endforeach
				
				</select>
			     <strong><span id="msg_origin" style="color:red"></span></strong>
				</div>
				<div class="col-md-5 col-sm-6">
                <label for="color">Shape <span class="alert-danger">*</span></label>
				<select name="shape_id"  id="shape_id"  class="form-control  @error('shape') is-invalid @enderror"  value="{{ old('shape') }}"  autocomplete="color" autofocus>
					@foreach($res["shape"] as $shp_key => $shp_val )
                                 <option  value="{{$shp_key}}" {{$shp_key == $get_items->shape_id ? 'selected' :''}}>
								 {{$shp_val}} 
							</option> 
						@endforeach
				
			    </select>
		     	<strong><span id="msg_shape" style="color:red"></span></strong>
			    </div>
        </div>

		<div class="form-group row">
			   <div class="offset-md-1 col-sm-6 col-md-5">
			   <label for="color">Specie <span class="alert-danger">*</span></label>
			   <input id="specie" type="text" class="form-control only-numeric @error('length') is-invalid @enderror" name="specie_id" value="{{$res['specie'] }}"  autocomplete="name" autofocus readonly>
        
			   <strong><span id="msg_specie" style="color:red"></span></strong>
			   </div>
			   <div class="col-sm-6 col-md-5">
               <label for="color">Treatment <span class="alert-danger">*</span></label>
			   <select id="treatment_id"   class="form-control" name="treatment_id" >
			   	@foreach($res["treatment"] as $trm_key => $trm_val )
                                 <option  value="{{$trm_key}}" {{$trm_key == $get_items->treatment_id ? 'selected' :''}}>
								 {{$trm_val}} 
							</option> 
						@endforeach
			  
		       </select>
			   <strong><span id="msg_treatment" style="color:red"></span></strong>
               </div>
	    </div>  
     </form>
        <div class="form-group row"> 
	          <div class="offset-md-1 col-sm-6 col-md-5">
	          <input type="button" class="btn btn-warning form-control" value="Update" onclick="updateStock()">
	           </div>
	           <div class="col-sm-6 col-md-5">
	           <button class="btn btn-warning btn-block"  onclick="closeForm()"> Cancel</button>
               </div>
           </div>

         </div>
	</div>	
  </div>      