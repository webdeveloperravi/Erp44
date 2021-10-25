<style>
th {
	text-align: left !important;
}

td {
	text-align: left !important;
}

td,  th {
	border: 1px solid #ddd;
	padding: 8px;
}

tr:nth-child(even) {
	background-color: #f2f2f2;
}

tr:hover {
	background-color: #ddd;
}

th {
	padding-top: 12px;
	padding-bottom: 12px;
	text-align: left;
	background-color: #04AA6D;
	color: white;
}
input[type=checkbox]{
      width: 20px;
      height: 20px;
    }
</style>
<form target="_blank"  action="{{ route('managerStockReport.printSelected') }}" method="POST">
{{-- <a class="btn btn-primary float-right mb-3" target="_blank" href="{{ route('managerStockReport.print',$managerId) }}">Print Report</a> --}}

<button  class="btn btn-inverse float-right mb-3" type="submit">Print Report</button> 
<input type="checkbox" name="check" id="checkAll">
<label for=""><h4>Select All</h4></label>
<div id="printArea">
 @csrf
 <input type="hidden" name="managerId" value="{{ $managerId }}">
 @foreach ($products->sortBy('name') as $product)
 @if (!empty($data[$product['id']])) 
 {{-- <input type="checkbox" class="form-control" name="products[]" value="{{ $product->id }}">
 <h3>{{ $product->name }}</h3> --}}
 <h3>
    <span>
        <input type="checkbox" class="products" name="products[]" value="{{ $product->id }}"> 
        {{ $product->name }} 
    </span>
 </h3>
 <div class="table-responsive">
    <table class="table"  id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100">
        <thead> 
            <tr>
                <th>Grade Rattis</th>
                @php
                    $rattis = $product->getUniqueRattis($product->id,$productStockIds)
                @endphp
                    
            @foreach ($rattis->sortBy('rati_standard') as $ratti) 
                  <th>

                    {{ $ratti->rati_standard }}+          
                </th>
                @endforeach
            </tr>  
            @foreach ($product->getUniqueGrades($product->id,$productStockIds) as $grade) 
            <tr>
                <td>{{ $grade->alias }}</td>
            @if (!empty($data[$product['id']][$grade['id']]))
                 @foreach ($rattis->sortBy('rati_standard') as $ratti) 
                 @if (!empty($data[$product['id']][$grade['id']][$ratti['id']]))
                        <td>{{ count($data[$product['id']][$grade['id']][$ratti['id']]) }}</td>
                @else 
                <td></td>
                @endif
                 @endforeach
            @else 
            <td></td>
            @endif 
            </tr>
         @endforeach 
         </tr>   
        </thead>
        <tbody> 
        </tbody>
    </table>
</div>
 @endif
 @endforeach 
 
</div>
</form>
 <script>
 

$("#checkAll").change(function() { 
   
    if(this.checked) { 
        $(".products").prop('checked', this.checked); 
    }else{ 
        $(".products").prop('checked', this.checked); 
    }  
});

function printSelected(){
    var url = "{{ route('managerStockReport.printSelected') }}";
    $.ajax({
        method:'POST',
        url:url,
        data:  $("#formCheckbox").serialize(),
        success:function(data){
            alert('success');
        }
    })
}
 </script>