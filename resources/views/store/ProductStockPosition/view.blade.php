<div class="card-body">
   @if(count($accounts))
   <div class="table-responsive">
      <table class="table" id="table_id2" style="width:100">
         <thead>
            <tr>
               <th id="click">UID</th>
               <th> Name</th>
               <th>Pieces</th> 
            </tr>
         </thead>
         <tbody>
            @php
            $authUserId = auth('store')->user()->id;
            $authUserStoreId = App\Helpers\StoreHelper::getStoreId();

            $authUserStoreResult = App\Services\ProductStockPosition::getUserStockPosition($authUserStoreId,$requestData)
            @endphp
@if ($authUserStoreResult['show'])
<tr class="text-center">
   <td>{{ $authUserStore->id ?? "" }}</td> 
   <td>{{ $authUserStore->company_name ?? "" }}</td> 
   <td>{{ $authUserStoreResult['count'] ?? "" }}</td>
</tr>
@endif
            @foreach($accountGroups as $group) 
            <tr class="table-active">
               <td colspan="3">{{ $group->name }} </td>
            </tr>
            @if (isset($accounts[$group->id]))
           
            @foreach($accounts[$group->id] as $account)
            {{-- Manager --}}
            @if ($account->type == 'user')  
            @php
                $result = App\Services\ProductStockPosition::getUserStockPosition($account->id,$requestData)
            @endphp
            @if ($result['show'])
            <tr class="text-center">
               <td>{{ $account->id ?? "" }}</td> 
               <td>{{ $account->name ?? "" }}</td> 
               <td>{{ $result['count'] ?? "" }}</td>
            </tr>
            @endif 
            @endif 


            {{-- Org --}}
            @if ($account->type == 'org' || $account->type == 'lab')
            @php
                $result = App\Services\ProductStockPosition::getUserStockPosition($account->id,$requestData)
            @endphp
            @if ($result['show'])
            <tr class="text-center">
               <td>{{ $account->id ?? "" }}</td> 
               <td>{{ $account->company_name ?? "" }} - ({{ $account->headOfficeAddress->city->name ?? "" }})</td> 
               <td>{{ $result['count'] ?? "" }}</td>
            </tr>
            @endif
            @foreach (App\Services\ProductStockPosition::getStoreManagers($account->id) as $item)
            @php
            $result = App\Services\ProductStockPosition::getUserStockPosition($item->id,$requestData)
            @endphp
            @if ($result['show'])
            <tr class="text-center table-info">
               <td>{{ $item->id }}</td>
               <td>{{ $item->parentStore->company_name ?? "" }} - ({{ $item->name ?? "" }})</td>  
               <td>{{ $result['count'] ?? "" }}</td>
            </tr>
            @endif
            @endforeach
           
            @endif
            @endforeach 
            @endif
            @endforeach
            
         </tbody>
      </table>
   </div>
   @else
   <h2 class="text-center"><i class="fa fa-inbox"></i>&nbsp; Empty</h2>
   @endif
</div>