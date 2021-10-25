@extends('layouts.admin.app')
@section('css')
<style>
    /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>  
@endsection
@section('content')
<div class="card">
    <div class="card-footer p-2" style="background-color: #04a9f5">
       <h5 class="text-white m-b-0 text-left d-inline" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Settings</h5>
    </div>
    <div class="card-body">
       <form  onsubmit="event.preventDefault();" id="updateForm">
          @csrf
          <div class="row">
              @foreach ($settings as $setting)
              @if ($setting->type == 'login-otp')
                <div class="col-md-12">
                  <div class="form-group">
                      <label for="parentId">{{ $setting->name }}</label>
                      <label class="switch">
                          <input type="checkbox" {{ $setting->status == 1 ? 'checked' : '' }} name="{{ $setting->slug }}">
                          <span class="slider round"></span>
                        </label>
                    </div>
                </div>
              @endif
              @endforeach
             <div class="col-md-3">
                <div class="form-group">
                  <button type="submit" onclick="update()">Update</button>
                </div>
             </div>
               
        </div> 
       </form>
       <div id="tempChallanDetails">
       </div>
    </div>
 </div>
 
@endsection
@section('script')
<script>
function update(){
    var url = "{{ route('settings.update') }}";
    $.ajax({
        method:"POST",
        url : url,
        data : $("#updateForm").serialize(),
        success:function(data){
             swal('Updated','success');
        }
    });
}
</script>

@endsection