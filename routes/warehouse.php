<?php 

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Model\Admin\Setting\WarehouseAction;

Route::group(['namespace'=>'Guard'],function(){

	Route::get('/','WareHouseAuthController@index')->name('warehouse'); 
	Route::get('/loginform','WareHouseAuthController@loginForm')->name('warehouse.loginForm');
	Route::post('/resendOtp','WareHouseAuthController@resendOtp')->name('warehouse.resendOtp');
	Route::post('/voiceOtp','WareHouseAuthController@voiceOtp')->name('warehouse.voiceOtp');
	Route::post('/verifyAccount','WareHouseAuthController@verifyAccount')->name('warehouse.verifyAccount'); 
	Route::get('/logout', 'WareHouseAuthController@logout')->name('warehouse.logout'); 
	Route::post('/otp-verify-check','WareHouseAuthController@verifyOTP')->name('warehouse.verifyOTP');
}); 

Route::group(['middleware'=>"warehouse"],function(){ 

	Route::get('myprofile','Guard\WareHouseAuthController@myprofile')->name('warehouse.myprofile');
	Route::get('edit-myprofile/{id}','Guard\WareHouseAuthController@editmyprofile')->name('warehouse.edit.myprofile');
	Route::post('update-myprofile','Guard\WareHouseAuthController@updateMyprofile')->name('warehouse.update.myprofile');
 

});

// Route::group(['middleware'=>['warehouse','warehouse_role_module'],  'namespace' =>'Warehouse'], function(){
Route::group(['middleware'=>['warehouse','warehouse_role_module'],  'namespace' =>'Warehouse'], function(){
    
	Route::group(['namespace'=> 'Profile'] ,function(){ 
      
		//Warehouse Profile
		Route::get('profile','WarehouseProfileController@index')->name('warehouseProfile');
		Route::get('profile-edit-basic-information','WarehouseProfileController@editBasicInformation')->name('warehouseProfile.editBasicInformation');
		Route::post('profile-update-basic-information','WarehouseProfileController@updateBasicInformation')->name('warehouseProfile.updateBasicInformation');  
	
		//Warehouse Profile Address
		Route::get('profile-address-all','WarehouseProfileAddressController@all')->name('warehouseProfile.getAddresses'); Route::get('profile-address-create','WarehouseProfileAddressController@create')->name('warehouseProfile.createAddress');
		Route::post('profile-address-store','WarehouseProfileAddressController@store')->name('warehouseProfile.storeAddress');
		Route::get('profile-address-edit/{addressId}','WarehouseProfileAddressController@edit')->name('warehouseProfile.editAddress');
		Route::post('profile-address-update','WarehouseProfileAddressController@update')->name('warehouseProfile.updateAddress');
		Route::get('profile-address-delete/{id}','WarehouseProfileAddressController@deleteAddress')->name('warehouseProfile.deleteAddress');
		
	});

	//Dashboard
	Route::get('/dashboard','DashboardController@index')->name('warehouse.dashboard');
	Route::get('dashboard-pending-invoices','DashboardController@pendingInvoices')->name('warehouse.dashboard.invoice.pending'); 
	Route::get('dashboard-completed-invoices','DashboardController@completedInvoices')->name('warehouse.dashboard.invoice.complete');
	Route::get('dashboard-gradesort-pending-invoices','DashboardController@gradesortPendingInvoices')->name('warehouse.dashboard.invoice.gradesortPending');
	Route::get('dashboard-generate-id-pending-invoices','DashboardController@generateIdPendingInvoices')->name('warehouse.dashboard.invoice.generateIdPending');
	Route::get('dashboard-issue-to-manager-pending-invoices','DashboardController@notIssuedToManagerInvoices')->name('warehouse.dashboard.invoice.notIssuedToManager');
	Route::get('dashboard-challans-for-weight','DashboardController@challansForWeight')->name('warehouse.dashboard.challansForWeight');
	Route::get('dashboard-challans-for-packet-processing','DashboardController@packetProcessChallans')->name('warehouse.dashboard.invoice.challan.packet.proceesing');
	Route::get('dashboard-invoice-view/{id}','DashboardController@productPurchaseView')->name('warehouse.dashboard.invoice');
	Route::get('dashboard-weight-challan-completed','DashboardController@managerWeightCompleted')->name('warehouse.dashboard.manager.weight.completed');
	Route::get('dashboard-weight-challan-pending','DashboardController@managerWeightPending')->name('warehouse.dashboard.manager.weight.pending');
	Route::get('dashboard-packet-process-completed','DashboardController@managerPacketProcessCompleted')->name('warehouse.dashboard.manager.packet.process.completed');
	Route::get('dashboard-packet-process-issue-pending','DashboardController@packetProcessNotIssued')->name('warehouse.dashboard.manager.packetProcessNotIssued');
	Route::get('dashboard-packet-process-issued','DashboardController@packetProcessIssued')->name('warehouse.dashboard.manager.packetProcessIssued');
	Route::get('dashboard-manager-weight-challan-packets','DashboardController@managerWeightChallanPackets')->name('warehouse.dashboard.manager.weightChallanPackets');

	Route::get('dashboard-packet-process-detail/{packet_id}','DashboardController@managerPacketProcessDetail')->name('warehouse.dashboard.manager.packet.process.detail');

	//return to super pending packets process
	Route::get('dashboard-packet-return-super-pending','DashboardController@managerPacketReturnSuperPending')->name('warehouse.dashboard.packet.return.super.pending');

	//return to super completed packets process
	Route::get('dashboard-packet-return-super-completed','DashboardController@managerPacketReturnSuperCompleted')->name('warehouse.dashboard.packet.return.super.completed');

	//issued Packets From Super for Final Product Processing
	Route::get('dashboard-issue_packets','DashboardController@issuedPackets')->name('warehouse.dashboard.issue.packets.processing');

	//GinProductProcessCompleted
	Route::get('dashboard-packet-product-gin-completed','DashboardController@ginCompleted')->name('warehouse.dashboard.product.gin.completed');

	//Authorization Invoice
	Route::get('authorization-invoice','AuthorizationController@invoiceIndex')->name('authorization.invoiceIndex');
	Route::get('authorization-invoices','AuthorizationController@invoices')->name('authorization.invoices');
	Route::get('authorization-invoice/{invoiceId}','AuthorizationController@invoice')->name('authorization.invoice');
	Route::get('authorization-invoice-authorize/{invoiceId}','AuthorizationController@invoiceAuthorize')->name('authorization.invoice.authorize');

	//Authorization Weight Packet
	Route::get('authorization-receive-packet','AuthorizationController@receivePacketIndex')->name('authorization.receivePacketIndex');
	Route::get('authorization-receive-packets','AuthorizationController@receivePackets')->name('authorization.receive.packets');
	Route::get('authorization-receive-packet/{packetId}','AuthorizationController@receivePacket')->name('authorization.receive.packet');

	//Authorization Packet Process
	Route::get('authorization-packet-process','AuthorizationController@packetProcessIndex')->name('authorization.packetProcessIndex');
	Route::get('authorization-receive_packet_process','AuthorizationController@receivePacketProcess')->name('authorization.receive.packet.process');
	Route::get('authorization-receive_packet_process/{packetProcessingChallan}','AuthorizationController@receivePacketProcess2')->name('authorization.receive.packet.process.2');
	  
 
	 // vendor create 
	Route::get('vendor','VendorController@index')->name('warehouse.vendor.index');
	Route::get('vendor-create','VendorController@create')->name('warehouse.vendor.create');
	Route::get('vendor-all','VendorController@all')->name('warehouse.vendor.all');
	Route::get('vendor-view','VendorController@index')->name('warehouse.vendor.view');
	Route::post('vendor-store','VendorController@store')->name('warehouse.vendor.store');
	Route::get('vendor-country/{id}','VendorController@getState')->name('warehouse.vendor.country'); 
	Route::get('vendor-state/{id}','VendorController@getCity')->name('warehouse.vendor.state');
	Route::get('vendor-status/{id}','VendorController@status')->name('warehouse.vendor.status');
	Route::get('vendor-edit/{id}','VendorController@edit')->name('warehouse.vendor.edit');
	Route::post('vendor-update','VendorController@update')->name('warehouse.vendor.update');
	Route::get('vendor-show/{id}','VendorController@show')->name('warehouse.vendor.show');

    // Invoice CRUD
    Route::get('invoices','ProductPurchaseController@all_invoices')->name('invoice.index');
    Route::get('invoice-view/{organization}/{invoice}','ProductPurchaseController@invoice_view')->name('invoice.view');
    Route::get('invoice/{invoice}','ProductPurchaseController@viewInvoice')->name('view.invoice.detail');
	Route::get('invoice-edit/{id}','ProductPurchaseController@invoiceDetailEdit')->name('invoice.detail.edit');
	Route::post('invoice-update','ProductPurchaseController@invoiceDetailUpdate')->name('invoice.detail.update');
	Route::post('invoice-delete','ProductPurchaseController@invoiceDetailDelete')->name('invoice.detail.delete');
 
    // Invoice Product CRUD
	Route::get('product-purchase','ProductPurchaseController@index')->name('product-purchase');
	Route::get('product-purchase-pro-cate/{productId}/{vendorId}/{invoiceNumber}','ProductPurchaseController@get_product_category')->name('product.purchase.pro.cate');
	Route::get('product-purchase-list','ProductPurchaseController@pro_purchase_list')->name('product.purchase.list');
	Route::get('product-purchase-form','ProductPurchaseController@pro_purchase_form')->name('product.purchase.form');
	Route::post('product-purchase-store','ProductPurchaseController@store')->name('product.purchase.store');
	Route::get('product-purchase-authorize-status-check/{id}','ProductPurchaseController@checkInvoiceAuthorization')->name('check.invoice.authorization');
	Route::get('product-purchase-complete/{id}/{type}','ProductPurchaseController@complete')->name('product.purchase.complete');
	

    //GradeSort Invoice Details
	Route::get('gradesort/invoice/{id}','InvoiceDetailGradeController@index')->name('gradesort.index');
	Route::get('gradesortcreate/{id}','InvoiceDetailGradeController@gradesortCreate')->name('gradesort.create');
	Route::get('gradesortview/{id}','InvoiceDetailGradeController@gradesortView')->name('gradesort.view');
	Route::post('gradesort/store','InvoiceDetailGradeController@store')->name('gradesort.store');
	Route::get('gradesort/edit/{id}','InvoiceDetailGradeController@edit')->name('gradesort.edit');
	Route::post('gradesort/update','InvoiceDetailGradeController@update')->name('gradesort.update');
	Route::post('gradesort/delete','InvoiceDetailGradeController@delete')->name('gradesort.delete');

	//GradeSort Product
	Route::get('gradesort/products/generate/{sort_id}','InvoiceDetailGradeProductController@generateProducts')->name('gradesort.product.generate');
	Route::get('gradesort/products/printpdf/{sort_id}','InvoiceDetailGradeProductController@printLabel')->name('gradesort.product.print.pdf');
	Route::get('gradesort/products/print-excel/{sort_id}','InvoiceDetailGradeProductController@exportExcel')->name('gradesort.product.export.excel');

	//Issue To Manager
	Route::get('issue-to-manager-all','IssueToManagerController@index')->name('issueToManager.index');
	Route::get('issue-to-manager/{grade_sort_id}','IssueToManagerController@create')->name('issueToManager.create');
	Route::post('issue-to-manager/','IssueToManagerController@store')->name('issueToManager.store');
	Route::get('issue-to-manager/{id}','IssueToManagerController@edit')->name('issueToManager.edit');
	Route::post('issue-to-manager/{id}','IssueToManagerController@destroy')->name('issueToManager.delete');
	
	//All Packets
	Route::get('packets','PacketController@index')->name('packet.index');
	Route::get('packet-issue-to-manager/{packetId}','PacketController@issueToManager')->name('packet.issueToManager');
	Route::post('packet-issue-to-manager/','PacketController@issueToManagerStore')->name('packet.issueToManager.store');

	//PacketProducts
	Route::get('packet-products','PacketProductController@index')->name('packet.product.index');
	Route::get('packet-products-list/{packetId}','PacketProductController@products')->name('packet.products');
	Route::get('packet-product-view/{productId}','PacketProductController@view')->name('packet.product.view');

	//Timeline 
	// Route::get('invoice-timeline','InvoiceTimelineController@index')->name('invoice.timeline');
	
	//Media
    Route::get('media','ProductMediaController@index')->name('media.index');
    Route::get('media-create/{gin}','ProductMediaController@create')->name('media.create');

	//Images
	Route::get('images/{productId}','ProductImageController@index')->name('image.index');
	Route::get('image-create/{productId}','ProductImageController@create')->name('image.create');
	Route::post('image-store/','ProductImageController@store')->name('image.store');
	Route::get('image-edit/{productId}','ProductImageController@edit')->name('image.edit');
	Route::get('image-update/{productId}','ProductImageController@update')->name('image.update');
	Route::get('image-delete/{productId}','ProductImageController@delete')->name('image.delete');

	//Videos
	Route::get('videos/{productId}','ProductVideoController@index')->name('video.index');
	Route::get('video-create/{productId}','ProductVideoController@create')->name('video.create');
	Route::post('video-store/','ProductVideoController@store')->name('video.store');
	Route::get('video-edit/{productId}','ProductVideoController@edit')->name('video.edit');
	Route::get('video-update/{productId}','ProductVideoController@update')->name('video.update');
	Route::get('video-delete/{productId}','ProductVideoController@delete')->name('video.delete');

    //Foxpro Data Importing
	Route::get('foxpro-data-import','FoxproDataImportController@index')->name('foxproDataImport.index');
	Route::post('foxpro-data-import-store-tables','FoxproDataImportController@storeTables')->name('foxproDataImport.storeTables');
	Route::get('foxpro-data-import-get-left-products-to-replace-with-erp-id','FoxproDataImportController@getLeftPRoductsToReplaceWithErpId')->name('foxproDataImport.getLeftPRoductsToReplaceWithErpId');
	Route::post('foxpro-data-import-columns-replace-with-erp-id','FoxproDataImportController@columnsReplaceWithErpId')->name('foxproDataImport.columnsReplaceWithErpId'); 
	Route::get('foxpro-data-import-left-product-stock-import','FoxproDataImportController@leftProductStockImport')->name('foxproDataImport.leftProductStockImport'); 
	Route::post('foxpro-data-import-latest-data-to-product-stock','FoxproDataImportController@insertProductsInProductStock')->name('foxproDataImport.insertProductsInProductStock'); 

	Route::get('export-csv-magento','FoxproDataImportController@exportCsvMagento');

Route::group(['namespace'=> 'Manager'],function(){
	
	//Manager Challan
	Route::get('challans','ManagerChallanController@index')->name('manager.challan.index');
	Route::get('challan-preview/{id}','ManagerChallanController@preview')->name('manager.challan.preview');
	Route::get('challan-accept/{challanId}','ManagerChallanController@acceptChallan')->name('manager.challan.accept');
	Route::get('challan-reject/{challanId}','ManagerChallanController@rejectChallan')->name('manager.challan.reject');
 
    //Manager Weight Challan
	Route::post('manager-weight','ManagerWeightController@index')->name('manager.weight.index'); 
	Route::get('manager-weight-create/{id}','ManagerWeightController@create')->name('manager.weight.create');
	Route::post('manager-weight-product','ManagerWeightController@getProduct')->name('manager.weight.product'); 
	Route::post('manager-weight-store','ManagerWeightController@store')->name('manager.weight.store'); 
	Route::get('manager-weight-edit/{id}','ManagerWeightController@edit')->name('manager.weight.edit');
	Route::get('manager-weight-finish/{id}','ManagerWeightController@finish')->name('manager.weight.finish');
	Route::get('manager-weight-left-product/{id}','ManagerWeightController@leftProducts')->name('manager.weight.left.product');
  
	//After Weight Complete Ready for packaging
	Route::get('manager-challan-packet','ManagerChallanPacketController@index')->name('manager.challan.packet.index'); 
	Route::get('manager-challan-packet-all/{id}','ManagerChallanPacketController@all')->name('manager.challan.packet.all');
	Route::get('manager-challan-packet-create/{rattiId}/{gradeId}','ManagerChallanPacketController@create')->name('manager.challan.packet.create');
	Route::get('manager-challan-packet-store/{rattiId}/{gradeId}','ManagerChallanPacketController@store')->name('manager.challan.packet.store');
	Route::get('manager-challan-packet-list/{gradeId}','ManagerChallanPacketController@listPackets')->name('manager.challan.packet.list');

	//After Packaging Return To Super
	Route::get('manager-challan-packet-return_to-super/{packetId}','ManagerChallanPacketController@returnToSuper')->name('packet.return');
	Route::get('manager-challan-packet-print-packet-label/{packetId}','ManagerChallanPacketController@printPacketLabel')->name('packet.labelPrint');
	
	
   //Manager Packet Process
    Route::get('manager-packets','PacketProcessController@index')->name('packetProcess.index');
    Route::get('manager-packet-preview/{id}','PacketProcessController@preview')->name('packetProcess.preview');
	Route::get('manager-packet-reject/{challanId}','PacketProcessController@rejectPacketChallan')->name('packetProcess.rejectPacket');
	Route::get('manager-packet-accept/{challanId}','PacketProcessController@acceptPacketChallan')->name('packetProcess.accept');
    Route::get('manager-packet-create/{id}','PacketProcessController@create')->name('packetProcess.create'); 
	Route::post('manager-packet-store','PacketProcessController@store')->name('packetProcess.store'); 
	Route::get('manager-packet-edit/{id}','PacketProcessController@edit')->name('packetProcess.edit');
	Route::get('manager-packet-finish/{id}','PacketProcessController@finish')->name('packetProcess.finish');
	Route::get('manager-packet-left-product/{id}','PacketProcessController@leftProducts')->name('packetProcess.left.product');
	Route::get('manager-packet-left-product-view/{id}','PacketProcessController@leftProductsView')->name('packetProcess.left.product_view');
	Route::get('manager-packet-products-list/{id}','PacketProcessController@productsList')->name('packetProcess.products_list');
	Route::get('manager-packet-print-label/{id}','PacketProcessController@printLabel')->name('packetProcess.printLabel');
	
    //Packet Process Product Final
	Route::post('packet-product-create','PacketProcessController@productCreate')->name('packet.product.create');
	Route::get('items-all','PacketProcessController@allItem')->name('packet.product.all');//->middleware('warehouse');
    Route::get('items-product/{id}','PacketProcessController@associate_data')->name('packet.product.records');
    Route::post('items-save','PacketProcessController@store')->name('packet.product.store');
    Route::get('items-status/{id}/{status}','PacketProcessController@status')->name('packet.product.status');
    Route::get('items-create','PacketProcessController@create')->name('packet.product');
    Route::get('items-edit/{id}','PacketProcessController@edit')->name('packet.product.edit');
    Route::post('items-update','PacketProcessController@update')->name('packet.product.update');
    Route::get('items-delete/{id}','PacketProcessController@destroy')->name('packet.product.destroy');
    Route::get('items-grade-rate/{cid}/{gid}','PacketProcessController@getRateProfile')->name('packet.product.grade-rate');
    Route::get('items-calculate-weight/{val}/{id}','PacketProcessController@getCalculateWeight')->name('packet.product.calculate.weight');
    Route::get('items-generate-gin','PacketProcessController@generateGin')->name('packet.product.generate.gin'); 
    Route::get('items-packet-return_to-super/{challanId}','PacketProcessController@returnToSuper')->name('packet.returnToSuper'); 
	
	// Route::get('final-labels-generate/{id}',function(){
    //        return view('')
	// });

});
 //Product Stock Update
 Route::get('product-stock-update','ProductStockUpdateController@index')->name('warehouseProductStockUpdate.index'); 
 Route::get('product-stock-update-detail/{gin}','ProductStockUpdateController@getTimeLine')->name('warehouseProductStockUpdate.getDetail');
 Route::post('product-stock-update-update','ProductStockUpdateController@update')->name('warehouseProductStockUpdate.update');
}); 

// Route::group(['namespace'=>'Store','middleware'=>'warehouse'],function(){
    
// });


 




?>