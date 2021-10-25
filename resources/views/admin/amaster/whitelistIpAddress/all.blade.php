   <div class="row">
       <div class="col-md-8">
        @if(count($ips))
        <div class="table-responsive">
        <table class="table" id="table_id2" style="width:100">
                <thead>
                    <tr>
                        <th id="click">UID</th>
                        <th> Name</th> 
                        <th> Action</th> 
                    </tr>
                </thead>
                <tbody> 
                @foreach($ips as $ip)
                    <tr class="text-center">
                        <td>{{ $ip->id }}</td>
                        <td>{{$ip->ip_address}}</td> 
                        <td><button class="btn btn-danger btn-sm" onclick="remove({{ $ip->id }})">Remove</button></td> 
                    </tr> 
                    @endforeach
                </tbody>
                  <tfoot>
                        <tr> 
                        <th>Sr.</th>
                        <th> Name</th> 
                        <th> Action</th> 
                        </tr>
                     </tfoot>
            </table>
        </div>
        @else
        <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
                                @endif
            
          
       </div>
   </div>
   
    <script> 
       
    
        $(document).ready(function() {
        $('#table_id2 tfoot th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
       }); 
       
        var table = $('#table_id2').DataTable({
            dom: 'Bfrtip', 
            "order": [],
            "aaSorting": [],
            initComplete: function() {
                this.api().columns().every(function() {
                    var that = this;
                    $('input', this.footer()).on('keyup change clear', function() {
                        if(that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
            }
        });
    });
    </script>
     