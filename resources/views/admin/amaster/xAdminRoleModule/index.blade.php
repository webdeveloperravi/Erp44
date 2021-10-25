@extends('layouts.admin.app')
@section('content') 
<div class="container">
  <div class="success_msg" style="display:none">
  </div>
  <div class="card">
    <div class="card-header">
      <h3 text-center><a href="{{ url()->previous() }}
"><button class="btn btn-success float-left mr-5"> Back</button></a>Role Name : {{$role->name}} <a href="{{route('admin.role.module.edit',$role->id)}}"><button class="btn btn-primary float-right"> Edit</button></a></h3>
       
    </div>
    <div class="card-block table-border-style">
      <div class="table-responsive"> 
          <table class="table table-styling">
            <thead>
              <tr class="table-primary">
                <th>#</th>
                <th>Modules</th>
               <!--  <th>Create</th>
                <th>CA</th>
                <th>Read</th>
                <th>RA</th>
                <th>Update</th>
                <th>UA</th>
                <th>Delete</th>
                <th>DA</th> -->
              </tr>
            </thead>
            <tbody>
              @foreach($role->adminModules->sortBy('child_sort') as $module)
              <tr>
                <th scope="row">
                  {{$loop->iteration}}
                </th>
                <td>{{$module->title}}</td> 
                <!-- <td>
                  @if($module->pivot->create == 1)
                     <i class="text-success fa fa-check"></i>
                  @else
                     <i class="text-danger fa fa-times"></i>
                  @endif
                </td>
                <td>
                  @if($module->pivot->ca == 1)
                     <i class="text-success fa fa-check"></i>
                  @else
                     <i class="text-danger fa fa-times"></i>
                  @endif
                </td>
                <td>
                  @if($module->pivot->read == 1)
                     <i class="text-success fa fa-check"></i>
                  @else
                     <i class="text-danger fa fa-times"></i>
                  @endif
                </td>
                <td>
                  @if($module->pivot->ra == 1)
                     <i class="text-success fa fa-check"></i>
                  @else
                     <i class="text-danger fa fa-times"></i>
                  @endif
                </td>
                <td>
                  @if($module->pivot->update == 1)
                     <i class="text-success fa fa-check"></i>
                  @else
                     <i class="text-danger fa fa-times"></i>
                  @endif
                </td>
                <td>
                  @if($module->pivot->ua == 1)
                     <i class="text-success fa fa-check"></i>
                  @else
                     <i class="text-danger fa fa-times"></i>
                  @endif
                </td>
                <td>
                  @if($module->pivot->delete == 1)
                     <i class="text-success fa fa-check"></i>
                  @else
                     <i class="text-danger fa fa-times"></i>
                  @endif
                </td> 
                <td>
                  @if($module->pivot->da == 1)
                     <i class="text-success fa fa-check"></i>
                  @else
                     <i class="text-danger fa fa-times"></i>
                  @endif
                </td> --> 
              </tr>
          
              @endforeach
            </tbody>
          </table>  
      </div>
    </div>
  </div>
</div> 
@endsection


