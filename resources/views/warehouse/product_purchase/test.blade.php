@extends('layouts.admin.app')
@section('content')
<div class="container">
  <div class="card"><!--Card Start-->
    <div class="card-header"><!--Card header Start-->
    <h4 class="text-left ">Grade Sort</h4>
    </div><!--Card header End-->
  <div class="card-body">
    <div class="table-responsive ">
    <table class="table table-bordered table-hover ">
    <thead class="table-dark">
    <tr>
    <th>Invoice No</th>
    <th>Product Name</th>
    <th>Carat</th>
    <th>Piece</th>
    <th>Grade</th>
    <th>Carat</th>
    <th>Piece</th>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td><label>101</label></td>
    <td><label>Yellow Sapphire</label></td>
    <td><label>1000</label></td>
    <td><label>201</label></td>
    <td>
      <select class=" selectpicker form-control "  data-live-search="true" data-default="Product Type"
      data-flag="true">
      <option value="select Grade">Select Grade</option>
      <option value="Normal">Normal</option>
      <option value="Fine">Fine</option>
      <option value="Premium">Premium</option>
      <option value="Super Premium">Super Premium</option>
      </select><!-- Product type Select Entery End -->
    </td>
    <td><input type="text" class="form-control"></td>
    <td><input type="text" class="form-control"></td>
    <td>
    <button type="button" class="btn btn-success btn-sm">Next</button>
    </td>
    </tr>
    </tbody>
    </table>
    </div>
  </div>
  </div><!--Card End-->

  <div class="card"><!--Card Start-->
    <div class="card-header"><!--Card header Start-->
    <h4 class="text-left ">Grade Sort View</h4>
    </div><!--Card header End-->
  <div class="card-body">
    <div class="table-responsive ">
    <table class="table table-bordered table-hover ">
    <thead class="table-dark">
    <tr>
    <th>S.No</th>
    <th>Product Name</th>
    <th>Grade</th>
    <th>Carat</th>
    <th>Piece</th>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td><label>1</label></td>
    <td><label>Yellow Sapphire</label></td>
    <td><label>Normal</label></td>
    <td><label>500</label></td>
    <td><label>110</label></td>
    <td>
    <button type="button" class="btn btn-warning btn-sm">Edit</button>
    <button type="button" class="btn btn-info btn-sm">Gernate ID</button>
    <button type="button" class="btn btn-secondary btn-sm">Print Label</button>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">Issue to Manager</button>
    <button type="button" class="btn btn-success btn-sm">Received from Manager</button>
    </td>
    </tr>
    </tbody>
    </table>
    </div>
  </div>
  </div><!--Card End-->

<!--Modal Part-->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"><h5 class="modal-title">Modal title</h5>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <h4 class="modal-title ">Issue To Manager</4>
        <div class="form-group row pt-3">
        <label class=" col-md-4 col-form-label text-md-right text-secondary">Manager Name:
        <span class="alert-danger">*</span>
        </label>
        <div class="col-sm-4 col-md-4 col-lg-2 col-xl-6 ">
        <select class="selectpicker form-control m-b-10"  data-live-search="true" data-default="United States"
        data-flag="true">
        <option value="select">Select</option>
        <option value="Name">Name</option>
        <option value="Name">Name</option>
        </select>
        </div>
      </div>
             <div class="form-group row">
             <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Invoice<span class="alert-danger">*</span></label>
             <div class="col col-sm-4 col-md-6">
             <input id="invoice" type="text" class="form-control" name="invoice"  autocomplete="invoice" autofocus>
             </div>
             </div>
             <div class="form-group row">
             <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary">Date<span class="alert-danger">*</span></label>
             <div class="col col-sm-4 col-md-6">
             <input id="date" type="date" class="form-control" name="Date"  autocomplete="date" autofocus>
             </div>
             </div>
             <div class="form-group row">
             <label  class="col-xs-12 col-md-4 col-form-label text-md-right text-secondary"></label>
             <div class="col col-sm-4 col-md-4">
             <button  type="button" class="btn btn-success" onclick="addAddressType()">Submit</button> <input type="button" name="cancel"class="btn btn-warning m-l-10" onclick="closeForm()" value="Cancel">
             </div>
             </div>

      </div>
    </div>
  </div>
</div>

  </div><!--Container End-->
@endsection
