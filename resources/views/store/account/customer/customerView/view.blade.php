 <div class="row">
<div class="col-md-12">
    <button id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right mr-3 m-2" onclick="edit('{{$customerAccount->id}}')">
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
                        <td>{{ $customerAccount->parentStore->company_name ?? ""}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Owner Name</th>
                        <td>{{ $customerAccount->name ?? ""}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Phone</th>
                        <td>+{{ $customerAccount->getPhoneWithCode($customerAccount->id) ?? ""}}</td>
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
                        <td>+{{ $customerAccount->getWhatsAppWithCode($customerAccount->id) ?? ""}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>{{ $customerAccount->email ?? ""}}</td>
                    </tr>
                     <tr>
                        <th scope="row">Account Group</th>
                        <td>{{ $customerAccount->accountGroup->name ?? ""}}</td>
                    </tr>
                  
                </tbody>
              </table>    
             </div>
            </div>
       </div> 
                     