@extends('layouts.admin.app')
@section('content')

@php  $end_range = 0; @endphp


  <div class="container">
   <div class="row float-right">
  	<div class="col-md-4"><a href="{{route('profile_weight_range.new_range',['id'=>$id])}}" class="btn btn-primary">New Range</a></div>
  </div>
  <h2 class="text-info m-b-20">{{$name}}</h2>
@if(Session::has('error'))
  <h3 class="alert alert-danger"> {{Session::get('error')}} </h3>
@endif
         <div class='table-responsive'> 
<table id="rate_profile_new_weight_range" class="table table-stripped new_range_table" style="margin-top: 20px;">
        <thead class="table-primary">
		     <tr>
		         <th>Sr</th>
				<th>Start Range</th>
				<th>End Range</th>
			    <th>Price</th>
			    <th>Rati Standard</th>
			    </tr>
			</thead>
		<tbody> 
			@foreach($pw_range as $pw_key => $pw_val )
		 		@php $end_range = $pw_val->end_range; @endphp
                 <tr>
                 	<td>{{$loop->iteration}}</td>
                 	<td>{{$pw_val['from']}}</td>  
                    <td> {{$pw_val['to']}} </td>
                    <td  style="width:300px;"> <span id="label_{{$loop->iteration}}">{{$pw_val->profile_weight_price->ratti_rate}}
                   	<i onclick="$('#label_{{$loop->iteration}}').hide(); $('#edit_{{$loop->iteration}}').show();" class="fas fa-pencil-alt"></i>
                   </span>
                    <form action="{{route('profile_weight_price_update.update_price')}}" method="post">
					   @csrf
                    <div style="display: none;" id="edit_{{$loop->iteration}}" >
                    <input type="hidden" name="rate_profile_weight_range_id" value="{{$pw_val->id}}"> 
                     <input type="hidden" name="rate_profile_id" value="{{$id}}"> 
                    <input type="text" name="price_update" value="{{$pw_val->profile_weight_price->ratti_rate}}" required="" placeholder="Price"> 
                    <button type="submit" class="btn btn-warning btn-sm p-1" id="btn_save" style="margin-top:-5px;">
                                   Update
                                </button>
                                <span style="padding-left: 20px;"><i onclick="$('#edit_{{$loop->iteration}}').hide(); $('#label_{{$loop->iteration}}').show()" class="fas fa-times text-danger">
                                	
                                </i>
                            </span>
                        </div>
                    </form>
                      </td>
                    <td>{{$pw_val['rati_standard']}}</td>
                     </tr>
                 	@endforeach
          </tbody>
           @if($weight_range->where('id','>',$end_range)->isNotEmpty()) 
             <tr>    
                  
				<form  action="{{route('rate.profile.rate.weight.range.price')}}" method="post"> 
					 <input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="rate_profile_id" value="{{$id}}">
				<td>1</td>
				<td>
					<select name="start_range">
						@foreach($weight_range as $w_key => $w_val )

						@if($end_range < $w_val['id'] )
							
							 
							<option value="{{$w_val['id']}}">
								{{$w_val['from']}} - {{$w_val['to']}}  
							</option> 
							  @break
						@endif
						@endforeach
					</select>
				</td>

				<td> 

					<select name="end_range">
						@foreach($weight_range->where('id','>',$end_range) as $w_key => $w_val )
                           
                           
                              

							<option value="{{$w_val['id']}}">
								{{$w_val['from']}} - {{$w_val['to']}} - (<span class="font-weight-bold">{{ $w_val['rati_standard'] }}+)</span> 
							</option> 
								
						@endforeach
					</select>
				</td>
				<td><input type="text" name="ratti_rate" required="" placeholder="Price"></td>
                <td><input type="submit" class="btn btn-success btn-sm" value="Save" style="margin-top: -5px;">
				</td>
				</form>
			</tr>
			
		@endif
            

              </table>
          </div>
          <a href="{{route('rate.profile')}}" class="btn btn-warning btn-sm text-lg">Back Rate Profile</a>

      </div>

@endsection

@section('script')

<script type="text/javascript">
	$(document).ready(function(){
  
     $(".new_range_table").DataTable();
 
	});
</script>

@endsection