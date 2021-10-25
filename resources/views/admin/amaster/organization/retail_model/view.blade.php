 
  <div class="card">
    <div class="card-footer p-0" style="background-color: #04a9f5">
      <h5 class="text-white m-b-0 text-left" style="padding-top:11px; padding-bottom:11px; border-left:8px solid white; margin-left:10px; padding-left:10px;">{{$retailModel->name}}</h5>
     </div> 
    
    <div class="card-body">
      
       
      <div class="row justify-content-center">
        <div class="col-md-12">
            <button class="btn btn-success float-right my-2" onclick="edit({{$retailModel->id}})">Edit</button> 
        </div>
        <div class="col-md-12">
        <div class="table-responsive ">
            <table class="table table-bordered table-hover display" id="example">
              <thead class="table-active">
                <tr>
                  <th>Name</th> 
                  <th>Alias</th>
                  <th>Description</th>
                  <th>Discount</th>
                  <th>Parent</th>
                  
                </tr>
              </thead>
              <tbody>
                                        <tr class="text-center"> 
                  <td><label>1</label></td>
                  <td><label>Ahmedgarh</label></td> 
                  
                </tr>  
                                      <tr class="text-center"> 
                  <td><label>2</label></td>
                  <td><label>Alawalpur</label></td> 
                  
                </tr>  
                                      <tr class="text-center"> 
                  <td><label>3</label></td>
                  <td><label>Verka</label></td> 
                  
                </tr>  
                                      <tr class="text-center"> 
                  <td><label>4</label></td>
                  <td><label>Ajnala</label></td> 
                  
                </tr>  
                                     
              </tbody>
            </table>
            </div> 
        </div>
    </div>   
      
    </div>
    
  </div>


  <script>
    
  </script>