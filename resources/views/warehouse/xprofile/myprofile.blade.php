@extends('layouts.warehouse.app')
@section('content')
<div class="container" >
	<p id="timer"></p>
<div class="card col-md-5  offset-md-3 " >
<h4 class="text-center m-10">My Profile</h3>
<hr>
<div class="row"> 
<div class="col-4 offset-1 col-sm-3 offset-sm-1 col-md-3 "><h6 class="font-weight-bold">Name</h6></div>
<div class="col-7 col-sm-6 col-md-8"><h6 class="font-weight-bold">{{$warehouse_data->name}}</h6></div>
</div>

<div class="row"> 
<div class="col-4 offset-1 col-sm-3 offset-sm-1 col-md-3"><h6 class="font-weight-bold">Role</h6></div>
<div class="col-7 col-sm-6 col-md-8"><h6 class="font-weight-bold">{{$warehouse_data->role->name}}</h6></div>
</div>

<div class="row"> 
<div class="col-4 offset-1 col-sm-3 offset-sm-1 col-md-3 "><h6 class="font-weight-bold">Email</h6></div>
<div class="col-7 col-sm-6 col-md-8"><h6 class="font-weight-bold">{{$warehouse_data->email_primary}}</h6></div>
</div>

<div class="row"> 
<div class="col-4 offset-1 col-sm-3 offset-sm-1 col-md-3"><h6 class="font-weight-bold">Contact</h6> </div>
<div class="col-7 col-sm-6 col-md-8"><h6 class="font-weight-bold">{{$warehouse_data->whatsapp}}</h6></div>
</div>
<div class="row m-20">

<!-- <a href="{{route('warehouse.edit.myprofile',['id'=>$warehouse_data->id])}}" class="btn btn-block btn-warning">Edit</a>	 -->

</div>


</div>
</div>

@section('script')
<script type="text/javascript">
</script>
@endsection
@endsection