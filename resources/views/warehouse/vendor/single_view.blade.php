@extends('layouts.warehouse.app')
@section('content')
    <div class="page-header">
       <div class="row align-items-end">
          <div class="col-lg-8">
             <div class="page-header-title">
                <div class="d-inline">
                   <h4 class="mb-3">Vendor Profile</h4>
                </div>
             </div>
       </div>
    </div>
    <div class="page-body">
              <div class="row">
          <div class="col-lg-12">
             <div class="tab-header card">
                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                   <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Personal Info</a>
                      <div class="slide"></div>
                </ul>
             </div>
             <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                   <div class="card">
                      <div class="card-header">
                         <h5 class="card-header-text">About Store</h5>
                         <a href="{{ route('warehouse.vendor.edit',$vendor->id) }}" id="edit-btn" type="button" class="btn btn-sm btn-primary  f-right">
                         <i class="icofont icofont-edit"></i>Edit
                         </a>
                      </div>
                      <div class="card-block">
                         <div class="view-info">
                            <div class="row">
                               <div class="col-lg-12">
                                  <div class="general-info">
                                     <div class="row">
                                        <div class="col-lg-12 col-xl-6">
                                           <div class="table-responsive">
                                              <table class="table m-0">
                                                 <tbody>
                                                    <tr>
                                                       <th scope="row">Vendor Name</th>
                                                       <td>{{ $vendor->company_name }}</td>
                                                    </tr>
                                                    <tr>
                                                       <th scope="row">User</th>
                                                       <td>{{ $vendor->name }}</td>
                                                    </tr>
                                                    <tr>
                                                       <th scope="row">Email</th>
                                                       <td>{{ $vendor->email }}</td>
                                                    </tr>
                                                    <tr>
                                                       <th scope="row">GST Number</th>
                                                       <td>{{ $vendor->gst_number }}</td>
                                                    </tr>
                                                    <tr>
                                                 </tbody>
                                              </table>
                                           </div>
                                        </div>
                                        <div class="col-lg-12 col-xl-6">
                                           <div class="table-responsive">
                                              <table class="table">
                                                 <tbody>
                                                    <tr>
                                                       <th scope="row">Country</th>
                                                       <td>{{ $vendor->country->name }}</td>
                                                    </tr>
                                                    <tr>
                                                       <th scope="row">State</th>
                                                       <td>{{ $vendor->state->name }}</td>
                                                    </tr>
                                                    <tr>
                                                       <th scope="row">City</th>
                                                       <td>{{ $vendor->city->name }}</td>
                                                    </tr>
                                                    <tr>
                                                       <th scope="row">Address</th>
                                                       <td>{{ $vendor->address }}</td>
                                                    </tr>
                                                    <tr>
                                                       <th scope="row">Locality</th>
                                                       <td>{{ $vendor->locality }}</td>
                                                    </tr>
                                                    <tr>
                                                       <th scope="row">Landmark</th>
                                                       <td>{{ $vendor->landmark }}</td>
                                                    </tr>
                                                    <tr>
                                                       <th scope="row">Pincode</th>
                                                       <td>{{ $vendor->pincode }}</td>
                                                    </tr>
                                                 </tbody>
                                              </table>
                                           </div>
                                        </div>
                                     </div>
                                  </div>
                               </div>
                            </div>
                         </div>
  <a href="{{url()->previous()}}" class="btn btn-sm btn-warning"> Back </a>


@endsection                         