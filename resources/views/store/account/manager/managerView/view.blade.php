 <div class="row">
<div class="col-md-12">
    <button id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right mr-3 m-2" onclick="edit('{{$managerAccount->id}}')">
        Edit
    </button>
</div>

    <div id="edit">
        
    </div>
    
    <div class="col-lg-12 col-xl-6">
        <div class="table-responsive">
            <table class="table m-0">
                <tbody>
                    <tr>
                        <th scope="row">Company</th>
                        <td>{{ $managerAccount->parentStore->company_name ?? ""}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Owner Name</th>
                        <td>{{ $managerAccount->name ?? ""}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Phone</th>
                        <td>+{{ $managerAccount->getPhoneWithCode($managerAccount->id) ?? ""}}</td>
                    </tr>
                </tbody>
              </table>    
             </div>
            </div>

    <div class="col-lg-12 col-xl-6">
        <div class="table-responsive">
            <table class="table m-0">
                <tbody>
                    <tr>
                        <th scope="row">Whats App</th>
                        <td>+{{ $managerAccount->getWhatsAppWithCode($managerAccount->id) ?? ""}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>{{ $managerAccount->email ?? ""}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Role Name</th>
                        <td>{{ $managerAccount->managerRole->name ?? ""}}</td>
                    </tr>
                </tbody>
              </table>    
             </div>
            </div>
       </div> 
                     