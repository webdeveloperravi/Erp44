@extends('layouts.warehouse.app')
@section('css')
@endsection
@section('content')
<div class="row"> 
   <div class="col">
      <button class="btn btn-dark float-right mb-3" onclick="create()">Create Vendor</button>
    </div>
 </div>
  
 
<!---Create form ----Div --->
<div id="create">

</div>

<!---Manager List -----Div ---->
<div id="all">
           
</div>

<!---Edit Manager  -----Div ---->
<div id="edit">
           
</div>

@endsection
@section('script')
<script type="text/javascript">

all();

function create() {

    var url = "{{route('warehouse.vendor.create')}}";

    $.get(url, function(data) {

        $("#create").html(data);
    });
    var offset = $("#create").offset();
    $('html, body').animate({
        scrollTop: offset.top,
        scrollLeft: offset.left
    }, 1000);

}

function save() {

    var form_data = $("#createForm").serialize();
    $.ajax({
        url: "{{route('warehouse.vendor.store')}}",
        type: "POST",
        data: form_data,
        success: function(data) {
            if ($.isEmptyObject(data.errors)) {
                $("#add_vendor_form")[0].reset();
                closeForm();
                $(".success_msg").show();
                $(".success_msg").html(data.success);
                all();
                setTimeout(hideSuccess, 5000);
            } else {
                $.each(data.errors, function(field_name, error) {
                    $(document).find('[name=' + field_name + ']').after('<span class="text-strong text-danger">' + error + '</span>');

                });
                setTimeout(hiderrors, 10000);
            }


        }


    });

}

function hideSuccess() {
    $(".success_msg").hide();
}

function all() {

    var url = "{{route('warehouse.vendor.all')}}";

    $.get(url, function(data) {

        $("#all").html(data);
    });
    var offset = $("#all").offset();
    $('html, body').animate({
        scrollTop: offset.top,
        scrollLeft: offset.left
    }, 1000);

}


function status(id){
    var url ="{{route('warehouse.vendor.status',['/'])}}/"+id;
    $.get(url,function(data){
        all();
    });


}






</script>

@endsection