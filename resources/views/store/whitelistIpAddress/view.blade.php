@extends('layouts.store.app') 
@section('content')
<button class="btn btn-dark btn-sm text-white mb-2" onclick="location.href='{{ route('whitelistIpAddress.index') }}'" ><i class="fa fa-arrow-left"></i>Back</button> 

<div class="card">
    <div class="card-footer p-0 mb-2" style="background-color: #04a9f5">
        <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">Whitelisted Users for Ip : {{ $ip->ip_address ?? "" }}</h5> </div>
    <div class="card-body" > 
   
        <div class="row">
            <div class="col-md-8">
             @if(count($ip->managers))
             <form action="{{ route('whitelistIpAddress.detachUsers') }}" method="POST">
                @csrf 
                <input type="hidden" name="ip_id" value="{{ $ip->id }}">
                <div class="table-responsive">
                 <table class="table" id="table_id2" style="width:100"> 
                     <thead>
                     <thead>
                         <tr>
                             <th>Select</th>
                             <th id="click">UID</th>
                             <th> Name</th> 
                             <th> Company</th> 
                             <th> Action</th> 
                         </tr>
                     </thead>
                     <tbody> 
                     @foreach($ip->managers as $manager)
                         <tr class="text-center">
                            <td>
                                <div class="border-checkbox-section">
                                   <div class="border-checkbox-group border-checkbox-group-info">
                                      <input class="border-checkbox" name="managers[]" value="{{ $manager->id }}" type="checkbox" id="checkbox{{ $manager->id }}">
                                      <label class="border-checkbox-label" for="checkbox{{ $manager->id }}"></label>
                                   </div>
                                </div>
                             </td>
                             <td>{{ $manager->id }}</td>
                             <td>{{$manager->name}}</td> 
                             <td>
                              @if(in_array($manager->type,$storeUserTypesAll))
                              {{ $manager->parentStore->company_name }}    
                              @elseif(in_array($manager->type,$storeTypesAll))
                              {{ $manager->company_name }}
                              @endif    
                             </td>  
                            
                         </tr> 
                         @endforeach
                     </tbody> 
                 </table>
             </div>
             <div class="col-xl-4 col-md-6 col-12 my-auto">
                <div class="form-group mt-lg-4"> 
                   <button type="submmit" class="btn btn-primary">Detach Selected Users</button> 
                </div>
             </div>
             </form>
             @else
             <a class="btn btn-inverse btn-sm text-white" href="{{ route('whitelistIpAddress.delete',$ip->id) }}">Delete IP Address</a>
             {{-- <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2> --}}
                                     @endif
                 
               
            </div>
        </div>
        
    </div> 
</div> 



    @endsection
 
     