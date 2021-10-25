@extends('layouts.warehouse.app')
@section('content')
<div class="container">
<div class="card">
<!--Header ---->
<div class="row">
<div class="col-xs-6 col-sm-9 col-md-9 "> 
<div class="card-header text-secondary text-uppercase">Edit My Profile </div>
</div>
</div>   

<div class="card-body">
<form>
<div class="alert alert-danger alert-dismissible" style="display:none" id="edit_error_msg">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<ul id="edit_res">

</ul>
</div>
<div class="card-body">

<div class="alert alert-danger alert-dismissible" style="display: none" id="error_msg">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<ul id="res">
</ul>
</div>

<form id="edit_my_profile">
@csrf
<input type="hidden" name="user_id" value="{{$warehouse_data_info->id}}">

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Department Name </label>
<div class="col col-sm-4 col-md-6">
<label class="font-weight-bold">
	{{$warehouse_data_info->guardName->name}}
</label>
</div>  
</div>


<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Role</label>
<div class="col col-sm-4 col-md-6"><label class="font-weight-bold">{{$department_role}}</label>
</div>  
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Name<span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<input id="edit_name" type="text" class="form-control" name="name"  autocomplete="name" autofocus value="{{$warehouse_data_info->name}}">
</div>  
</div>


<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Email<span class="alert-danger">*</span></label>
<div class="col col-sm-12 col-md-6">
<input type="text" name="edit_email" value="{{$warehouse_data_info->email}}" class="form-control">
</div>
</div>


<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Country</label>
<div class="col col-sm-12 col-md-6">
<select    name="country" class="form-control country" onchange="edit_getPhoneCode()">
<option >Select Country</option>
@foreach($country_code ->sortBy('name') as $cou_code)
<option value="{{$cou_code->id}}"{{$cou_code->id==$warehouse_data_info->country_code_id? 'selected':''}}>{{$cou_code->name}}</option>
@endforeach
</select>
</div>
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Whatsapp No:</label>

<div class="col-md-2 country_code">
<input  type="text" class="form-control country_code" name="country_code"  autocomplete="name" autofocus readonly="true" value="+{{$warehouse_data_info->countryCode->phonecode}}">
</div>
<div class="col-sm-9 col-md-4">
<input type="text" class="form-control only-numeric mobile" name="mobile"  autocomplete="name" autofocus value="{{$warehouse_data_info->phone}}">
</div>
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Security Pin</label>
<div class="col col-sm-12 col-md-6">
<input type="password" name="edit_email" value="{{-- {{$user_edit->email}} --}}" class="form-control">
</div>
</div>


<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
<div class="col col-sm-4 col-md-4">
<button  type="button" class="btn btn-warning" onclick="updateUser()">Update</button> <input type="button" name="cancel"class="btn btn-danger m-l-10" onclick="closeForm()" value="Cancel">  
</div>  
</div>
</form>
</div>
</div>
</div>
</div>

<hr>
@section('script')
@endsection
@endsection