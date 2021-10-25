@extends('layouts.admin.app')
@section('content')
<div class="container">
  <form action="{{route('warehouse.role.savemodules')}}" method="post">
    <table class="table table-bordered tbl_config_role">
      <thead>
        <tr>
          <th>#</th>
          <th>Module Name </th>
          </t r>
        </thead>
        <tbody>
          
          @csrf
          <input type="hidden" name="role_id" value="{{$role_id}}">
          @foreach($modules as $module)
          <tr>
            <td>
              <input type="checkbox" name="modules[]" value="{{$module->id}}">
            </td>
            <td>
              {{$module->title}}
            </td>
          </tr>
          @endforeach
          
        </tbody>
      </table>
      <button type="submit">Save</button>
    </form>
  </div>
  @endsection