
@extends('layouts.admin.app')
@section('content')

@php
//var_dump($updated_dates);
$count1=0;
@endphp
<div class="container">

	<!--  -->

	<div class='table-responsive'> 
		<table id="price_his_tab" class="table table-stripped new_range_table" style="margin-top: 20px;">
				<thead class="table-primary">
					 <tr>
						 <th>Sr</th>
						<th>Start Range</th>
						<th>End Range</th>
						<th>Price</th>
						<th>Rati Standard</th>
						<th>Date</th>
						</tr>
					</thead>
				<tbody> 
					@foreach($rateProfiles as $val )
						 
						 <tr>
							 <td>{{$loop->iteration}}</td>
							 <td>{{$val->from}}</td>  
							<td> {{$val->to}} </td>
							<td> {{$val->historyProductRateProfileWeightRange->ratti_rate ?? 'No'}} </td>
						
							<td>{{$val->rati_standard}}</td>
							<td>{{ \Carbon\Carbon::parse($val->historyProductRateProfileWeightRange->updated_at)->toDayDateTimeString() }}</td>
							 </tr>
							 @endforeach
				  </tbody>
	</table>
</div>
    


 </div>
    <a href="{{route('rate.profile')}}" class="btn btn-warning btn-sm text-lg">Back Rate Profile</a>
</div>

@endsection

@section('script')

<script type="text/javascript">
	
 $(document).ready(function(){
 	$("#price_his_tab").DataTable();
 })

</script>

@endsection