<div class="modal fade show" id="large_modal" tabindex="-1" role="dialog" style="z-index: 1050; display: block;">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title">Edit Organization Role Configuartion </h4> 
</div>
<div class="modal-body">
<form id="edit_org_role_config_form">
@csrf
<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Org Role Name <span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6" id="div_org_role_name">
<select   id="org_role_name"  name="role_name" class="form-control  @error('tax_type') is-invalid @enderror">
<option >Select Role Name </option>
@foreach($org_role as $role_key => $org_val )

<option value="{{$org_val->id}}" title="{{$org_val->description}}" {{$org_val->id==$id ? 'selected' :''}}>
{{$org_val->name}} 
</option>
@endforeach
</select>
</div>  
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Org Discount Rate  <span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<div id="org_dis_rate">
<select   id="org_role_name"  name="discount_rate" class="form-control  @error('tax_type') is-invalid @enderror">
<option >Select Discount Rate </option>
@foreach($org_discount_rate as $dis_key => $dis_val )
<option value="{{$dis_val->id}}" {{$dis_val->id==$org_dis_id ? 'selected' :''}}>
{{$dis_val->name}} - Rate {{ $dis_val->rate }} %
</option> 
@endforeach
</select>
</div>
</div>  
</div>


<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Tax Type <span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<div id="org_tax_type">
<select   id="tax_rate_id"  name="tax_type" class="form-control  @error('tax_type') is-invalid @enderror">
<option>Select Tax Type </option>
@foreach($org_tax_type as  $tt_key => $tt_val )
<option value="{{$tt_val->id}}" {{$tt_val->id==$org_tax_type_id ? 'selected' :''}}>
{{$tt_val->name}}
</option> 
@endforeach
</select>
</div>
</div>  
</div>

<div class="form-group row">
<label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Unit <span class="alert-danger">*</span></label>
<div class="col col-sm-4 col-md-6">
<div id="org_unit">
<select   id="unit_conversion_id"  name="unit" class="form-control  @error('tax_type') is-invalid @enderror">
<option>Select Unit </option>
@foreach($org_unit as $unit_key => $unit_val )
<option value="{{$unit_val['id']}}" title="{{$unit_val->description}}" {{$unit_val->id==$org_unit_id ? 'selected' :''}}>
{{$unit_val->name}} 
</option> 
@endforeach
</select>
</div>
</div>  
</div>
</form>
<div class="modal-footer">
<button type="button" class="btn btn-default waves-effect " onclick="closeModal()" data-dismiss="modal">Cancel</button>
<button type="button" class="btn btn-primary waves-effect waves-light" onclick="OrgRoleConfigUpdate()">Update</button> 
</div>
</div>
</div>
</div>


<script>




</script>
