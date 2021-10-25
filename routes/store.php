<?php

use App\Services\Balance;
use Illuminate\Support\Facades\Route;


Route::get('/', 'Guard\StoreAuthController@index')->name('store');
Route::get('/loginform', 'Guard\StoreAuthController@loginForm')->name('store.loginForm');
Route::post('/resendOtp', 'Guard\StoreAuthController@resendOtp')->name('store.resendOtp');
Route::post('/voiceOtp', 'Guard\StoreAuthController@voiceOtp')->name('store.voiceOtp');
Route::post('/verifyAccount', 'Guard\StoreAuthController@verifyAccount')->name('store.verifyAccount');
Route::get('/logout', 'Guard\StoreAuthController@logout')->name('store.logout');
Route::post('/otp-verify-check', 'Guard\StoreAuthController@verifyOTP')->name('store.verifyOTP');

Route::get('reauthenticate', 'ReauthenticateController@reauthenticate')->name('reauthenticate.index');
Route::post('reauthenticate/process', 'ReauthenticateController@processReauthenticate')->name('reauthenticate.process');

// Route::domain('{subdomain}.'.config('app.short_url'))->group(function () {

Route::group(['middleware' => ['store', 'store_role_module', 'StoreIpMiddleware', 'Reauthenticate']], function () {
  // Route::group(['middleware'=>"store"],function(){   

  Route::group(['namespace' => 'Store'], function () {

    Route::group(['namespace' => 'Profile'], function () {

      //Store Profile
      Route::get('profile', 'StoreProfileController@index')->name('storeProfile');
      Route::get('profile-edit-basic-information', 'StoreProfileController@editBasicInformation')->name('storeProfile.editBasicInformation');
      Route::post('profile-update-basic-information', 'StoreProfileController@updateBasicInformation')->name('storeProfile.updateBasicInformation');

      //Store Profile Address
      Route::get('profile-address-all', 'StoreProfileAddressController@all')->name('storeProfile.getAddresses');
      Route::get('profile-address-create', 'StoreProfileAddressController@create')->name('storeProfile.createAddress');
      Route::post('profile-address-store', 'StoreProfileAddressController@store')->name('storeProfile.storeAddress');
      Route::get('profile-address-edit/{addressId}', 'StoreProfileAddressController@edit')->name('storeProfile.editAddress');
      Route::post('profile-address-update', 'StoreProfileAddressController@update')->name('storeProfile.updateAddress');
    });




    ####BY ravi kumar####

    //blogs

    Route::prefix('cms')->group(function () {
      Route::get('/list_all_blogs', [StoreBlogController::class, 'getStoreAllBlogs'])->name('store.allblogs');
      Route::get('/{category}/list_all_blogs', [StoreBlogController::class, 'list_all_blogs'])->name('store.listallblogs');
      // Route::get('/{category}/view_blog/{blog_slug}/{blogname}', [StoreBlogController::class, 'post_details'])->name('9gem_blog_details');
      Route::view('/create_new_blog', 'store.blog.create_new_blog')->name('store.create_new_blog');
      Route::get('/{id}/edit', [StoreBlogController::class, 'blogEdit'])->name('store.blog_edit');
      Route::post('/update_post', [StoreBlogController::class, 'updatepost'])->name('store.blog_update');
      Route::post('/create_new_blog', [StoreBlogController::class, 'create_new_post'])->name('9gem_blog_submit');
      Route::get('/{blog_id}/toggleBlogStatus/{update_to}', [StoreBlogController::class, 'toggleBlogStatus'])->name('store.toggle_blog_status');
      Route::view('/create_new_category', 'store.blog.create_new_category')->name('store.create_cat');
      Route::post('/create_new_category', [StoreBlogController::class, 'createCat'])->name('store.create_cat');
      Route::get('/edit_category/{cat_name}/{cat_id}', [StoreBlogController::class, 'editCat'])->name('store.edit_cat');
      Route::post('/edit_category', [StoreBlogController::class, 'editCatPost'])->name('store.update_cat');
      Route::get('/{category_id}/{update_to}/update_cat_status', [StoreBlogController::class, 'updateCatStatus'])->name('store.update_cat_status');
      Route::get('/{category_id}/delete_category', [StoreBlogController::class, 'deleteCat'])->name('store.delete_cat');
      Route::get('{id}/delete', [StoreBlogController::class, 'blogDelete'])->name('store.delete_blog');
      Route::get('/list_all_blogs_categories', [StoreBlogController::class, 'getBlogCategories'])->name('store.blog_list_all_cats');



      #### Pages Routes ####
      Route::prefix('pages')->group(function () {
        Route::get('/list_all_pages', [PageController::class, 'getStoreAllPages'])->name('store.all_pages');
        Route::view('/create_new_page', 'store.pages.create_new_page')->name('store.create_new_page');
        Route::get('/{id}/edit', [PageController::class, 'pageEdit'])->name('store.page_edit');
        Route::get('{id}/delete', [PageController::class, 'pageDelete'])->name('store.delete_page');
        Route::post('/update_post', [PageController::class, 'updatepage'])->name('store.page_update');
        Route::post('/create_new_page', [PageController::class, 'create_new_page'])->name('9gem_page_submit');
        Route::get('/{page_id}/togglePageStatus/{update_to}', [PageController::class, 'togglePageStatus'])->name('store.toggle_page_status');
        Route::get('/{page_id}/togglePageVisibility/{update_to}', [PageController::class, 'togglePageVisibility'])->name('store.toggle_page_visibility');
      });
    });


    Route::prefix('uploads')->group(function () {
      Route::get('/upload_new_media', [UploadsController::class, 'uploadNewMedia'])->name('store.upload_new_media');
    });


    //settings
    Route::view('/settings', 'store.settings.settings')->name('store.store_settings');

    ####BY ravi kumar####


    //Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('store.dashboard');

    Route::group(['namespace' => 'Lead'], function () {

      //Lead
      Route::get('lead', 'LeadController@index')->name('lead.index');
      Route::get('lead-all', 'LeadController@all')->name('lead.all');
      Route::get('lead-create', 'LeadController@create')->name('lead.create');
      Route::post('lead-store', 'LeadController@store')->name('lead.store');
      Route::get('lead-view/{id}', 'LeadController@view')->name('lead.view');
      Route::get('lead-edit/{id}', 'LeadController@edit')->name('lead.edit');
      Route::post('lead-update', 'LeadController@update')->name('lead.update');
      Route::post('lead-status', 'LeadController@status')->name('lead.status');
      Route::get('lead-state/{id}', 'LeadController@getState')->name('lead.get.state');
      Route::get('lead-city/{id}', 'LeadController@getCity')->name('lead.get.city');
      Route::get('lead-town/{id}', 'LeadController@getTown')->name('lead.get.town');
      Route::get('lead-subLeadType/{id}', 'LeadController@getsubLeadType')->name('lead.get.subLeadType');

      //Lead Comments
      Route::get('lead-comment-all/{id}', 'LeadController@getComments')->name('lead.comment.all');
      Route::post('lead-comment-store', 'LeadController@storeComment')->name('lead.comment.store');
      Route::get('lead-comment-delete/{id}', 'LeadController@deleteComment')->name('lead.comment.delete');
      Route::get('lead-comment-edit/{id}', 'LeadController@editComment')->name('lead.comment.edit');
      Route::post('lead-comment-update', 'LeadController@updateComment')->name('lead.comment.update');

      //Lead Social  
      Route::get('lead-social/{leadId}', 'LeadSocialController@index')->name('leadSocial.index');
      Route::get('lead-social-create/{leadId}', 'LeadSocialController@create')->name('leadSocial.create');
      Route::post('lead-social-store', 'LeadSocialController@store')->name('leadSocial.store');
      Route::get('lead-social-all/{leadId}', 'LeadSocialController@all')->name('leadSocial.all');
      Route::get('lead-social-edit/{id}', 'LeadSocialController@edit')->name('leadSocial.edit');
      Route::post('lead-social-update', 'LeadSocialController@update')->name('leadSocial.update');

      //Lead Images
      Route::get('lead-image-all/{id}', 'LeadController@getImages')->name('lead.image.all');
      Route::post('lead-image-store', 'LeadController@storeImage')->name('lead.image.store');
      Route::get('lead-image-view/{id}', 'LeadController@viewImage')->name('lead.image.view');

      //Lead To Store
      Route::get('lead-to-store-index/{id}', 'LeadToStoreController@index')->name('leadtostore.index');
      Route::post('lead-to-store-send-email', 'LeadToStoreController@sendEmailOtp')->name('leadtostore.sendemail');
      Route::get('lead-to-store-get-sms-token/{id}', 'LeadToStoreController@getSmsToken')->name('leadtostore.getsmstoken');
      Route::post('lead-to-store-convert', 'LeadToStoreController@convert')->name('leadtostore.convert');
      Route::get('lead-to-store-check-verification-status/{id}', 'LeadToStoreController@checkVerificationStatus')->name('leadtostore.checkverificationstatus');

      //Lead Assign
      Route::get('lead-assign/{id}', 'LeadController@assign')->name('lead.assign');
      Route::post('lead-assign-save', 'LeadController@assignSave')->name('lead.assignSave');

      //Lead Contacts
      Route::get('lead-contact/{leadId}', 'LeadContactController@index')->name('leadContact.index');
      Route::get('lead-contact-create/{leadId}', 'LeadContactController@create')->name('leadContact.create');
      Route::get('lead-contact-getLeadContact/{leadId}', 'LeadContactController@all')->name('leadContact.all');
      Route::post('lead-contact-save', 'LeadContactController@save')->name('leadContact.save');
      Route::get('lead-contact-edit/{id}', 'LeadContactController@edit')->name('leadContact.edit');
      Route::post('lead-contact-update', 'LeadContactController@update')->name('leadContact.update');
    });

    //Store Manager Roles
    Route::get('manager-role', 'ManagerRoleController@index')->name('manager.role.index');
    Route::get('manager-role-all', 'ManagerRoleController@all')->name('manager.role.all');
    Route::get('manager-role-create', 'ManagerRoleController@create')->name('manager.role.create');
    Route::post('manager-role-store', 'ManagerRoleController@store')->name('manager.role.store');
    Route::get('manager-role-edit/{id}', 'ManagerRoleController@edit')->name('manager.role.edit');
    Route::post('manager-role-update', 'ManagerRoleController@update')->name('manager.role.update');
    Route::post('manager-role-status', 'ManagerRoleController@status')->name('manager.role.status');

    //Store Manager Role Modules
    Route::get('manager-role-modules-edit/{id}', 'ManagerRoleModuleController@edit')->name('manager.role.module.edit');
    Route::post('manager-role-modules-update', 'ManagerRoleModuleController@update')->name('manager.role.module.update');

    //Purchase Order
    Route::get('purchase-order', 'PurchaseOrderController@index')->name('purchaseorder.index');
    Route::get('purchase-order-create', 'PurchaseOrderController@create')->name('purchaseorder.create');
    Route::get('purchase-order-create-order', 'PurchaseOrderController@createOrder')->name('purchaseorder.createorder');
    Route::get('purchase-order-create-page', 'PurchaseOrderController@createPage')->name('purchaseorder.createpage');
    Route::get('purchase-order-get-grades/{productCategoryId}', 'PurchaseOrderController@getGrades')->name('purchaseorder.getGrades');
    Route::get('purchase-order-get-products/{productCategoryId}', 'PurchaseOrderController@getProducts')->name('purchaseorder.getproducts');
    Route::post('purchase-order-detail-store', 'PurchaseOrderController@storePurchaseOrderDetail')->name('purchaseorder.detail.store');
    Route::get('purchase-order-detail-get', 'PurchaseOrderController@getAllPurchaseOrderDetails')->name('purchaseorder.getAllDetails');
    Route::get('purchase-order-detail-delete/{id}', 'PurchaseOrderController@purchaseOrderDetailDelete')->name('purchaseorder.detail.delete');

    Route::post('purchase-order-place-order', 'PurchaseOrderController@placeOrder')->name('purchaseorder.placeorder');
    Route::get('purchase-order-all-orders', 'PurchaseOrderController@allOrders')->name('purchaseorder.allorders');
    Route::get('purchase-order-received', 'PurchaseOrderController@receivedAllOrders')->name('purchaseorder.receivedAllOrder');
    Route::get('purchase-order-view/{id}', 'PurchaseOrderController@orderView')->name('purchaseorder.orderView');
    Route::get('purchase-order-view-all/{id}', 'PurchaseOrderController@viewAll')->name('purchaseorder.order.viewAll');
    Route::get('purchase-order-detail-edit/{id}', 'PurchaseOrderController@purchaseOrderDetailedit')->name('purchaseorder.detail.edit');
    Route::post('purchase-order-detail-update', 'PurchaseOrderController@updatePurchaseOrderDetail')->name('purchaseorder.detail.update');
    Route::get('purchase-order-all-orders', 'PurchaseOrderController@allOrders')->name('purchaseorder.allorders');
    Route::get('purchase-order-detail/{orderId}', 'PurchaseOrderController@orderDetail')->name('purchaseorder.order.detail');
    Route::get('purchase-order-view-detail/{orderId}', 'PurchaseOrderViewController@orderDetails')->name('purchaseorder.view.orderDetail');

    //Purchase Order Request
    Route::get('purchase-order-request', 'PurchaseOrderRequestController@index')->name('purchaseOrderRequest.index');
    Route::get('purchase-order-request-all/{id}', 'PurchaseOrderRequestController@all')->name('purchaseOrderRequest.all');
    Route::get('purchase-order-request-view/{orderId}', 'PurchaseOrderRequestController@view')->name('purchaseOrderRequest.view');
    Route::get('purchase-order-request-view-detail/{orderId}', 'PurchaseOrderRequestController@viewDetail')->name('purchaseOrderRequest.viewDetail');
    Route::get('purchase-order-request-edit-qty/{id}', 'PurchaseOrderRequestController@editQty')->name('purchaseOrderRequest.editQty');
    Route::post('purchase-order-request-update-qty', 'PurchaseOrderRequestController@updateQty')->name('purchaseOrderRequest.updateQty');
    Route::get('purchase-order-request-delete-detail/{id}', 'PurchaseOrderRequestController@deleteDetail')->name('purchaseOrderRequest.deleteDetail');
    Route::get('purchase-order-request-edit/{orderId}', 'PurchaseOrderRequestController@edit')->name('purchaseOrderRequest.edit');
    Route::post('purchase-order--request-detail-save', 'PurchaseOrderRequestController@saveDetail')->name('purchaseOrderRequest.saveDetail');

    Route::post('purchase-order-request-update', 'PurchaseOrderRequestController@update')->name('purchaseOrderRequest.update');
    Route::post('purchase-order-request-approve', 'PurchaseOrderRequestController@approve')->name('purchaseOrderRequest.approve');




    //Sale Order Index
    Route::get('sale-order', 'SaleOrderController@index')->name('saleOrder.index');
    Route::get('sale-order-all/{id}', 'SaleOrderController@all')->name('saleOrder.all');
    Route::get('sale-order-view/{id}', 'SaleOrderController@view')->name('saleOrder.view');
    Route::post('sale-order-update', 'SaleOrderController@updateQuantity')->name('saleOrder.update');

    //Sale Order Create
    Route::get('sale-order-create', 'SaleOrderController@create')->name('saleOrder.create');
    Route::get('sale-order-create-page', 'SaleOrderController@createPage')->name('saleOrder.createpage');
    Route::get('sale-order-get-products/{productCategoryId}', 'SaleOrderController@getProducts')->name('saleOrder.getproducts');
    Route::get('sale-order-get-grades/{productCategoryId}', 'SaleOrderController@getGrades')->name('saleOrder.getGrades');
    Route::post('sale-order-detail-store', 'SaleOrderController@storePurchaseOrderDetail')->name('saleOrder.detail.store');
    Route::get('sale-order-details-get/', 'SaleOrderController@getAllPurchaseOrderDetails')->name('saleOrder.getAllDetails');
    Route::get('sale-order-detail-delete/{id}', 'SaleOrderController@purchaseOrderDetailDelete')->name('saleOrder.detail.delete');
    Route::get('sale-order-place-order/{id}', 'SaleOrderController@placeOrder')->name('saleOrder.placeorder');

    //Sale Order Prepare Vue Js
    Route::get('sale-order-prepare/{orderId}', 'SaleOrderPrepareController@index')->name('store.saleOrderPrepare.index');
    Route::get('sale-order-prepare-get-accounts/{storeId?}', 'SaleOrderPrepareController@getAccounts')->name('saleOrderPrepare.getAccounts');
    Route::get('sale-order-prepare-get-left-qty-to-add/{storeId?}', 'SaleOrderPrepareController@getLeftQtyToAdd')->name('saleOrderPrepare.getLeftQtyToAdd');
    Route::get('sale-order-prepare-all', 'SaleOrderPrepareController@all')->name('store.saleChallan.all');
    Route::post('sale-order-prepare-save-gins', 'SaleOrderPrepareController@saveGins')->name('saleOrderPrepare.saveGins');
    Route::get('sale-order-refresh/{id?}', 'SaleOrderPrepareController@refreshSaleOrder')->name('saleOrderPrepare.refreshSaleOrder');
    Route::get('sale-order-prepare-get-all-details', 'SaleOrderPrepareController@getAllDetails')->name('saleOrderPrepare.getAllDetails');
    Route::post('sale-order-prepare-save-challan', 'SaleOrderPrepareController@save')->name('saleOrderPrepare.save');
    Route::post('sale-order-prepare-delete-product', 'SaleOrderPrepareController@delete')->name('saleOrderPrepare.deleteProduct');

    //Opening Stock 
    Route::get('opening-stock', 'OpeningStockController@index')->name('store.openingStock.index');
    Route::get('opening-stock-find/{voucherNumber}', 'OpeningStockController@find')->name('openingStock.find');
    Route::get('opening-stock-view/{id}', 'OpeningStockController@view')->name('store.openingStock.view');
    Route::get('opening-stock-print-report/{challanId}/{type}', 'OpeningStockController@printReport')->name('openingStock.printReport');
    Route::get('opening-stock-print-details/{ledgerId}', 'OpeningStockController@detailsPrint')->name('openingStock.detailsPrint');

    Route::get('opening-stock-create', 'OpeningStockController@create')->name('store.openingStock.create');
    Route::post('opening-stock-save-gins', 'OpeningStockController@saveGins')->name('store.openingStock.saveGins');
    Route::get('opening-stock-get-all-details', 'OpeningStockController@getAllDetails')->name('openingStock.getAllDetails');
    Route::get('opening-stock-delete-product/{id?}', 'OpeningStockController@delete')->name('openingStock.deleteProduct');
    Route::post('opening-stock-save', 'OpeningStockController@saveOpeningStock')->name('store.openingStock.save');

    //Sale Challan
    Route::get('sale-challan', 'SaleChallanController@index')->name('saleChallan.index');
    Route::get('sale-challan-issue-all', 'SaleChallanController@issueChallanAll')->name('saleChallan.issueChallanAll');
    Route::get('sale-challan-issueChallanDetail/{id?}', 'SaleChallanController@issueChallanDetail')->name('saleChallan.issueChallanDetail');
    Route::get('sale-challan/{userId}', 'SaleChallanController@all')->name('saleChallan.all');
    Route::get('sale-challan-view/{id}', 'SaleChallanController@view')->name('saleChallan.view');
    Route::get('sale-challan-print-report/{challanId}/{type}', 'SaleChallanController@printReport')->name('saleChallan.printReport');
    Route::get('sale-challan-print-details/{ledgerId}', 'SaleChallanController@detailsPrint')->name('saleChallan.detailsPrint');

    Route::get('sale-challan-create', 'SaleChallanController@create')->name('saleChallan.create');
    Route::get('sale-challan-get-accounts/{storeId?}', 'SaleChallanController@getAccounts')->name('saleChallan.getAccounts');
    Route::post('sale-challan-save-gins', 'SaleChallanController@saveGins')->name('saleChallan.saveGins');
    Route::get('sale-challan-get-all-details', 'SaleChallanController@getAllDetails')->name('saleChallan.getAllDetails');
    Route::get('sale-challan-delete-product/{id?}', 'SaleChallanController@delete')->name('saleChallan.deleteProduct');
    Route::post('sale-challan-save-challan', 'SaleChallanController@save')->name('saleChallan.save');

    //Update Sale Challan 
    Route::get('sale-challan-update/{saleChallanId}', 'SaleChallanUpdateController@index')->name('saleChallanUpdate.index');
    Route::get('sale-challan-update-all1/{saleChallanId}', 'SaleChallanUpdateController@all')->name('saleChallanUpdate.all');
    Route::post('sale-challan-update-add-product', 'SaleChallanUpdateController@addProduct')->name('saleChallanUpdate.addProduct');
    Route::get('sale-challan-update-delete-product/{ledgerDetailId}', 'SaleChallanUpdateController@deleteProduct')->name('saleChallanUpdate.deleteProduct');

    //Receive Challan 
    Route::get('receive-challan', 'ReceiveChallanController@index')->name('receiveChallan.index');
    Route::get('receive-challan/{userId}', 'ReceiveChallanController@all')->name('receiveChallan.all');
    Route::get('receive-challan-view/{id}', 'ReceiveChallanController@view')->name('receiveChallan.view');

    Route::get('receive-challan-create', 'ReceiveChallanController@create')->name('receiveChallan.create');
    Route::get('receive-challan-get-accounts/{storeId?}', 'ReceiveChallanController@getAccounts')->name('receiveChallan.getAccounts');
    Route::post('receive-challan-save-gins', 'ReceiveChallanController@saveGins')->name('receiveChallan.saveGins');
    Route::get('receive-challan-get-all-details', 'ReceiveChallanController@getAllDetails')->name('receiveChallan.getAllDetails');
    Route::get('receive-challan-delete-product/{id?}', 'ReceiveChallanController@delete')->name('receiveChallan.deleteProduct');
    Route::post('receive-challan-save-challan', 'ReceiveChallanController@save')->name('receiveChallan.save');

    //Update Receive Challan 
    Route::get('receive-challan-update/{receiveChallanId}', 'ReceiveChallanUpdateController@index')->name('receiveChallanUpdate.index');
    Route::get('receive-challan-update-all1/{receiveChallanId}', 'ReceiveChallanUpdateController@all')->name('receiveChallanUpdate.all');
    Route::post('receive-challan-update-add-product', 'ReceiveChallanUpdateController@addProduct')->name('receiveChallanUpdate.addProduct');
    Route::get('receive-challan-update-delete-product/{ledgerDetailId}', 'ReceiveChallanUpdateController@deleteProduct')->name('receiveChallanUpdate.deleteProduct');

    //Sale Invoice 
    Route::get('sale-invoice', 'SaleInvoiceController@index')->name('saleInvoice');
    Route::get('sale-invoice/{userId}', 'SaleInvoiceController@all')->name('saleInvoice.all');
    Route::get('sale-invoice-view/{id}', 'SaleInvoiceController@view')->name('saleInvoice.view');
    Route::get('sale-invoice-print-report/{ledgerId}/{type}', 'SaleInvoiceController@printReport')->name('saleInvoice.printReport');

    Route::get('sale-invoice-create', 'SaleInvoiceController@create')->name('saleInvoice.create');
    Route::get('sale-invoice-get-accounts/{storeId?}', 'SaleInvoiceController@getAccounts')->name('saleInvoice.getAccounts');
    Route::post('sale-invoice-save-gins', 'SaleInvoiceController@saveGins')->name('saleInvoice.saveGins');
    Route::get('sale-invoice-get-all-details', 'SaleInvoiceController@getAllDetails')->name('saleInvoice.getAllDetails');
    Route::get('sale-invoice-delete-product/{id?}', 'SaleInvoiceController@delete')->name('saleInvoice.deleteProduct');
    Route::post('sale-invoice-save-challan', 'SaleInvoiceController@save')->name('saleInvoice.save');

    //Sale Return Vue Js 
    Route::get('sale-return', 'SaleReturnController@index')->name('saleReturn.index');
    Route::get('sale-return/{userId}', 'SaleReturnController@all')->name('saleReturn.all');
    Route::get('sale-return-view/{id}', 'SaleReturnController@view')->name('saleReturn.view');
    Route::get('sale-return-print-report/{ledgerId}', 'SaleReturnController@printReport')->name('saleReturn.printReport');

    Route::get('sale-return-create', 'SaleReturnController@create')->name('saleReturn.create');
    Route::post('sale-return-save-gins', 'SaleReturnController@saveGins')->name('saleReturn.saveGins');
    Route::get('sale-return-get-all-details', 'SaleReturnController@getAllDetails')->name('saleReturn.getAllDetails');
    Route::get('sale-return-delete-product/{id?}', 'SaleReturnController@delete')->name('saleReturn.deleteProduct');
    Route::post('sale-return-save-return', 'SaleReturnController@save')->name('saleReturn.save');

    Route::get('sale-return-issue-all', 'SaleReturnController@issueReturnAll')->name('saleReturn.issueReturnAll');
    Route::get('sale-return-issueReturnDetail/{id}', 'SaleReturnController@issueReturnDetail')->name('saleReturn.issueReturnDetail');

    //Bank Accounts
    Route::get('bank-account', 'BankController@index')->name('bank.account.index');
    Route::get('bank-account-create', 'BankController@create')->name('bank.account.create');
    Route::get('bank-account-all', 'BankController@all')->name('bank.account.all');
    Route::post('bank-account-store', 'BankController@store')->name('bank.account.store');
    Route::get('bank-account-edit/{id}', 'BankController@edit')->name('bank.account.edit');
    Route::post('bank-account-update', 'BankController@update')->name('bank.account.update');

    //Store Account
    Route::get('store-account', 'StoreAccountController@storeAccountIndex')->name('storeAccount.index');
    Route::get('store-account-create', 'StoreAccountController@createStoreAccount')->name('storeAccount.create');
    Route::post('store-account-save', 'StoreAccountController@saveStoreAccount')->name('storeAccount.save');
    Route::post('store-account-search-store', 'StoreAccountController@searchStore')->name('storeAccount.searchStore');
    Route::get('store-get-accounts', 'StoreAccountController@getStoreAccounts')->name('store.getAccounts');
    Route::get('store-account-view/{id}', 'StoreAccountController@viewStoreAccount')->name('storeAccount.view');
    Route::get('store-account-verify-view/{id}', 'StoreAccountController@verificationComponentView')->name('store.verify.view');
    Route::get('store-account-edit/{id}', 'StoreAccountController@editStoreAccount')->name('storeAccount.edit');
    Route::post('store-account-update', 'StoreAccountController@updateStoreAccount')->name('storeAccount.update');
    Route::get('store-account-status/{storeId}', 'StoreAccountController@changeStoreAccountStatus')->name('storeAccount.changeStatus');

    Route::group(['namespace' => 'Account'], function () {
      //Other Account
      Route::get('other-account', 'OtherAccountController@index')->name('otherAccount.index');
      Route::get('other-account-create', 'OtherAccountController@create')->name('otherAccount.create');
      Route::post('other-account-save', 'OtherAccountController@save')->name('otherAccount.save');
      Route::get('other-get-accounts', 'OtherAccountController@all')->name('otherAccount.all');
      Route::get('other-account-view/{id}', 'OtherAccountController@view')->name('otherAccount.view');
      Route::get('other-account-edit/{id}', 'OtherAccountController@edit')->name('otherAccount.edit');
      Route::post('other-account-update', 'OtherAccountController@update')->name('otherAccount.update');
      Route::get('other-account-status/{otherId}', 'OtherAccountController@updateStatus')->name('otherAccount.changeStatus');

      Route::get('other-account-sub-index/{storeId}', 'OtherAccountController@subIndex')->name('otherAccount.subIndex');
      Route::get('other-account-sub-view/{storeId}', 'OtherAccountController@subView')->name('otherAccount.subView');

      // //Other Account Address
      // Route::get('other-account-address-index/{accountId}','AccountAddressesController@otherAddressIndex')->name('otherAccount.address.index');
      // Route::get('other-account-address-all/{accountId}','AccountAddressesController@getOtherAddresses')->name('otherAccount.address.all');
      // Route::get('other-account-address-create/{accountId}','AccountAddressesController@createOtherAddress')->name('otherAccount.address.create');
      // Route::post('other-account-address-save/','AccountAddressesController@saveOtherAddress')->name('otherAccount.address.save');
      // Route::get('other-account-address-edit/{id}','AccountAddressesController@editOtherAddress')->name('otherAccount.address.edit');
      // Route::post('other-account-address-update','AccountAddressesController@updateOtherAddress')->name('otherAccount.address.update');
      // Route::get('other-account-address-delete/{id}','AccountAddressesController@deleteOtherAddress')->name('otherAccount.address.delete');
      // });

    });


    // Sub Store 
    Route::get('sub-store-account-index/{storeId}', 'SubStoreAccountController@index')->name('subStoreAccount.index');
    Route::get('sub-store-account-view/{storeId}', 'SubStoreAccountController@view')->name('subStoreAccount.view');
    //Sub Store manager Account 
    Route::get('sub-store-manager-account/{id}', 'SubStoreAccountController@managerAccountIndex')->name('subStore.managerAccount.index');
    Route::get('sub-store-manager-account-create/{id}', 'SubStoreAccountController@createManagerAccount')->name('subStore.managerAccount.create');
    Route::post('sub-store-manager-account-save', 'SubStoreAccountController@saveManagerAccount')->name('subStore.managerAccount.save');
    Route::get('sub-store-manager-get-accounts/{id}', 'SubStoreAccountController@getManagerAccounts')->name('subStore.manager.getAccounts');
    Route::get('sub-store-manager-account-view/{id}', 'SubStoreAccountController@viewManagerAccount')->name('subStore.manager.view');
    Route::get('sub-store-manager-verify-view/{id}', 'SubStoreAccountController@verificationComponentManager')->name('subStore.manager.verify.view');
    Route::get('sub-store-manager-account-edit/{id}', 'SubStoreAccountController@editManagerAccount')->name('subStore.managerAccount.edit');
    Route::post('sub-store-manager-account-update', 'SubStoreAccountController@updateManagerAccount')->name('subStore.managerAccount.update');

    //Store Account Address
    Route::get('store-account-address-index/{accountId}', 'AccountAddressesController@storeAddressIndex')->name('storeAccount.address.index');
    Route::get('store-account-address-all/{accountId}', 'AccountAddressesController@getStoreAddresses')->name('storeAccount.address.all');
    Route::get('store-account-address-create/{accountId}', 'AccountAddressesController@createStoreAddress')->name('storeAccount.address.create');
    Route::post('store-account-address-save/', 'AccountAddressesController@saveStoreAddress')->name('storeAccount.address.save');
    Route::get('store-account-address-edit/{id}', 'AccountAddressesController@editStoreAddress')->name('storeAccount.address.edit');
    Route::post('store-account-address-update', 'AccountAddressesController@updateStoreAddress')->name('storeAccount.address.update');
    Route::get('store-account-address-delete/{id}', 'AccountAddressesController@deleteStoreAddress')->name('storeAccount.address.delete');

    //Manager Account
    Route::get('manager-account', 'StoreAccountController@managerAccountIndex')->name('managerAccount.index');
    Route::get('manager-account-create', 'StoreAccountController@createManagerAccount')->name('managerAccount.create');
    Route::post('manager-account-save', 'StoreAccountController@saveManagerAccount')->name('managerAccount.save');
    Route::get('manager-get-accounts', 'StoreAccountController@getManagerAccounts')->name('manager.getAccounts');
    Route::get('manager-account-view/{id}', 'StoreAccountController@viewManagerAccount')->name('manager.view');
    Route::get('manager-account-status/{managerId}', 'StoreAccountController@changeManagerAccountStatus')->name('manager.changeStatus');

    //ManagerViewController
    Route::get('manager-account-all-action/{id}', 'ManagerViewController@index')->name('manager.view.index');
    Route::get('manager-account-detail/{id}', 'ManagerViewController@view')->name('manager.view.view');
    Route::get('manager-account-edit/{id}', 'ManagerViewController@edit')->name('manager.view.edit');
    Route::post('manager-account-update', 'ManagerViewController@update')->name('manager.view.update');
    Route::get('manager-verify-view/{id}', 'ManagerViewController@verificationComponentManager')->name('manager.view.verify.view');

    //ManagerComment
    Route::get('manager-comment-index/{managerId}', 'CommentController@index')->name('manager.comment.index');
    Route::get('manager-comment-all/{managerId}', 'CommentController@all')->name('manager.comment.all');
    Route::post('manager-comment-store', 'CommentController@store')->name('manager.comment.store');
    Route::get('manager-comment-edit/{managerId}', 'CommentController@edit')->name('manager.comment.edit');
    Route::post('manager-comment-update', 'CommentController@update')->name('manager.comment.update');

    //Manager Image
    Route::get('manager-image-index/{managerId}', 'ImageController@index')->name('manager.image.index');
    Route::get('manager-image-all/{managerId}', 'ImageController@all')->name('manager.image.all');
    Route::post('manager-image-store', 'ImageController@store')->name('manager.image.store');

    //Manager Account Address
    Route::get('manager-account-address-index/{accountId}', 'AccountAddressesController@managerAddressIndex')->name('managerAccount.address.index');
    Route::get('manager-account-address-all/{accountId}', 'AccountAddressesController@getManagerAddresses')->name('managerAccount.address.all');
    Route::get('manager-account-address-create/{accountId}', 'AccountAddressesController@createManagerAddress')->name('managerAccount.address.create');
    Route::post('manager-account-address-save/', 'AccountAddressesController@saveManagerAddress')->name('managerAccount.address.save');
    Route::get('manager-account-address-edit/{id}', 'AccountAddressesController@editManagerAddress')->name('managerAccount.address.edit');
    Route::post('manager-account-address-update', 'AccountAddressesController@updateManagerAddress')->name('managerAccount.address.update');
    Route::get('manager-account-address-delete/{id}', 'AccountAddressesController@deleteManagerAddress')->name('managerAccount.address.delete');

    //Manager Zone
    Route::get('manager-zone-attach/{managerId}', 'ManagerAttachZoneController@index')->name('managerZoneAttachIndex');
    Route::get('manager-attach-zones-get-states/{countryId}', 'ManagerAttachZoneController@attachZonesGetStates')->name('managerZoneAttach.getStates');
    Route::get('manager-attach-zones-get-cities/{stateId}', 'ManagerAttachZoneController@attachZonesGetCities')->name('managerZoneAttach.getCities');
    Route::post('manager-zone-attach-view', 'ManagerAttachZoneController@zoneAttachView')->name('managerZoneAttachView');
    Route::post('manager-zone-attach', 'ManagerAttachZoneController@zoneAttach')->name('managerZoneAttach');

    //Manager IP Whitelist      
    Route::get('manager-ip-attach/{managerId}', 'ManagerAttachIpController@index')->name('managerIpAttach.index');
    Route::get('manager-ip-attach-get-ip-list/', 'ManagerAttachIpController@getIpList')->name('managerIpAttach.getIpList');
    Route::post('manager-ip-attach-view', 'ManagerAttachIpController@view')->name('managerIpAttach.view');
    Route::post('manager-ip-attach', 'ManagerAttachIpController@attach')->name('managerIpAttach');

    //Customer Account
    Route::get('customer-account', 'StoreAccountController@customerAccountIndex')->name('customerAccount.index');
    Route::get('customer-account-create', 'StoreAccountController@createCustomerAccount')->name('customerAccount.create');
    Route::post('customer-account-save', 'StoreAccountController@saveCustomerAccount')->name('customerAccount.save');
    Route::get('customer-get-accounts', 'StoreAccountController@getCustomerAccounts')->name('customer.getAccounts');
    Route::get('customer-account-view/{id}', 'StoreAccountController@viewCustomerAccount')->name('customer.view');
    Route::get('customer-verify-view/{id}', 'StoreAccountController@verificationComponentCustomer')->name('customer.verify.view');
    Route::get('customer-account-edit/{id}', 'StoreAccountController@editCustomerAccount')->name('customerAccount.edit');
    Route::post('customer-account-update', 'StoreAccountController@updateCustomerAccount')->name('customerAccount.update');

    //Customer View 
    Route::get('customer-account-all-action/{id}', 'CustomerViewController@index')->name('customer.view.index');
    Route::get('customer-account-detail/{id}', 'CustomerViewController@view')->name('customer.view.view');
    Route::get('customer-account-edit/{id}', 'CustomerViewController@edit')->name('customer.view.edit');
    // Route::post('customer-account-update','CustomerViewController@update')->name('customer.view.update');
    Route::get('customer-verify-view/{id}', 'CustomerViewController@verificationComponentCustomer')->name('customer.view.verify.view');

    //Customer Comment
    Route::get('customer-comment-index/{customerId}', 'CommentController@index')->name('customer.comment.index');
    Route::get('customer-comment-all/{customerId}', 'CommentController@all')->name('customer.comment.all');
    Route::post('customer-comment-store', 'CommentController@store')->name('customer.comment.store');
    Route::get('customer-comment-edit/{customerId}', 'CommentController@edit')->name('customer.comment.edit');
    Route::post('customer-comment-update', 'CommentController@update')->name('customer.comment.update');

    //Customer Image
    Route::get('customer-image-index/{customerId}', 'ImageController@index')->name('customer.image.index');
    Route::get('customer-image-all/{customerId}', 'ImageController@all')->name('customer.image.all');
    Route::post('customer-image-store', 'ImageController@store')->name('customer.image.store');

    //Customer Address 
    Route::get('customer-account-address-index/{accountId}', 'AccountAddressesController@customerAddressIndex')->name('customerAccount.address.index');
    Route::get('customer-account-address-all/{accountId}', 'AccountAddressesController@getCustomerAddresses')->name('customerAccount.address.all');
    Route::get('customer-account-address-create/{accountId}', 'AccountAddressesController@createCustomerAddress')->name('customerAccount.address.create');
    Route::post('customer-account-address-save/', 'AccountAddressesController@saveCustomerAddress')->name('customerAccount.address.save');
    Route::get('customer-account-address-edit/{id}', 'AccountAddressesController@editCustomerAddress')->name('customerAccount.address.edit');
    Route::post('customer-account-address-update', 'AccountAddressesController@updateCustomerAddress')->name('customerAccount.address.update');
    Route::get('customer-account-address-delete/{id}', 'AccountAddressesController@deleteCustomerAddress')->name('customerAccount.address.delete');

    //Check Routes
    Route::post('store-account-sendEmail/{accountId}', 'StoreAccountController@sendEmailOtp')->name('store.account.sendemail');
    Route::get('store-account-sendSmsToken/{accountId}', 'StoreAccountController@getSmsToken')->name('store.account.getsmstoken');
    Route::get('store-account-getVerificationComponent/{accountId}', 'StoreAccountController@getVerificationComponent')->name('store.account.getVerificationComponent');
    Route::get('lead-to-store-check-verification-status/{id}', 'StoreAccountController@checkVerificationStatus')->name('leadtostore.checkverificationstatus');

    //My Stock
    Route::get('my-stock', 'MyStockController@index')->name('myStock.index');
    Route::post('my-stock-get-products', 'MyStockController@getProducts')->name('myStock.getProducts');

    //Product Filter
    Route::get('product-filter', 'ProductStockFilterController@index')->name('productStockFilter.index');
    Route::post('product-filter-get-products', 'ProductStockFilterController@getProducts')->name('productStockFilter.getProducts');

    //Verify Stock
    Route::get('stock-verify', 'StockVerifyController@index')->name('stockVerify.index');
    Route::get('stock-verify-get-accounts/{storeId?}', 'StockVerifyController@getAccounts')->name('stockVerify.getAccounts');
    Route::post('stock-verify-save-gins', 'StockVerifyController@saveGins')->name('stockVerify.saveGins');
    Route::post('stock-verify-get-products', 'StockVerifyController@getProducts')->name('stockVerify.getProducts');

    //Verify Stock Second
    Route::get('stock-verify-second', 'StockVerifySecondController@index')->name('stockVerifySecond.index');
    Route::get('stock-verify-second-get-accounts/{storeId?}', 'StockVerifySecondController@getAccounts')->name('stockVerifySecond.getAccounts');
    Route::post('stock-verify-second-save-gins', 'StockVerifySecondController@saveGins')->name('stockVerifySecond.saveGins');
    Route::post('stock-verify-second-get-products', 'StockVerifySecondController@getProducts')->name('stockVerifySecond.getProducts');

    //Stock Ledger Final
    Route::group(['namespace' => 'StockLedger'], function () {

      //CurrentStockLedger
      Route::get('current-stock-ledger', 'CurrentLedgerController@index')->name('currentStockLedger.index');
      Route::get('current-stock-ledger-details/{ledgerId}', 'CurrentLedgerController@details')->name('currentStockLedger.details');

      //StoreToManagerStockLedger
      Route::get('manager-stock-ledger', 'ManagerStockLedgerController@index')->name('managerStockLedger.index');
      Route::get('manager-stock-ledger/{managerId}', 'ManagerStockLedgerController@all')->name('managerStockLedger.all');
      Route::get('manager-stock-ledger-details/{ledgerId}', 'ManagerStockLedgerController@details')->name('managerStockLedger.details');

      //StoreToStoreLedger
      Route::get('store-stock-ledger', 'StoreStockLedgerController@index')->name('storeStockLedger.index');
      Route::get('store-stock-ledger/{storeId}', 'StoreStockLedgerController@all')->name('storeStockLedger.all');
      Route::get('store-stock-ledger-details/{ledgerId}', 'StoreStockLedgerController@details')->name('storeStockLedger.details');
    });

    //Cheque
    Route::group(['namespace' => 'Cheque'], function () {

      Route::get('cheque', 'ChequeController@index')->name('cheque.index');
      Route::get('cheque-create', 'ChequeController@create')->name('cheque.create');
      Route::get('cheque-all', 'ChequeController@all')->name('cheque.all');
      Route::post('cheque-store', 'ChequeController@store')->name('cheque.store');
      Route::get('cheque-edit/{id}', 'ChequeController@edit')->name('cheque.edit');
      Route::post('cheque-update', 'ChequeController@update')->name('cheque.update');

      //Cheque Issue 
      Route::get('cheque-issue', 'ChequeIssueController@index')->name('chequeIssue.index');
      Route::get('cheque-issue-create', 'ChequeIssueController@create')->name('chequeIssue.create');
      Route::get('cheque-issue-all', 'ChequeIssueController@all')->name('chequeIssue.all');
      Route::post('cheque-issue-store', 'ChequeIssueController@store')->name('chequeIssue.store');
      Route::get('cheque-issue-edit/{id}', 'ChequeIssueController@edit')->name('chequeIssue.edit');
      Route::post('cheque-issue-update', 'ChequeIssueController@update')->name('chequeIssue.update');

      //Cheque Receive 
      Route::get('cheque-receive', 'ChequeReceiveController@index')->name('chequeReceive.index');
      Route::get('cheque-receive-create', 'ChequeReceiveController@create')->name('chequeReceive.create');
      Route::post('cheque-receive-get-cheques', 'ChequeReceiveController@getCheques')->name('chequeReceive.getCheques');
      Route::post('cheque-receive-store', 'ChequeReceiveController@store')->name('chequeReceive.store');
      Route::get('cheque-receive-all', 'ChequeReceiveController@all')->name('chequeReceive.all');
      Route::get('cheque-receive-edit/{id}', 'ChequeReceiveController@edit')->name('chequeReceive.edit');
      Route::post('cheque-receive-update', 'ChequeReceiveController@update')->name('chequeReceive.update');

      //Cheque Clear 
      Route::get('cheque-clear', 'ChequeClearController@index')->name('chequeClear.index');
      Route::get('cheque-clear-create', 'ChequeClearController@create')->name('chequeClear.create');
      Route::post('cheque-clear-get-cheques', 'ChequeClearController@getCheques')->name('chequeClear.getCheques');
      Route::post('cheque-clear-store', 'ChequeClearController@store')->name('chequeClear.store');
      Route::get('cheque-clear-all', 'ChequeClearController@all')->name('chequeClear.all');
      Route::get('cheque-clear-edit/{id}', 'ChequeClearController@edit')->name('chequeClear.edit');
      Route::post('cheque-clear-update', 'ChequeClearController@update')->name('chequeClear.update');
    });

    //Stock Report FinalRoutes
    Route::group(['namespace' => 'StockReport'], function () {

      //StoreToManagerStockLedger
      Route::get('manager-stock-report', 'ManagerStockReportController@index')->name('managerStockReport.index');
      Route::get('manager-stock-report/{managerId}', 'ManagerStockReportController@all')->name('managerStockReport.all');
      Route::get('manager-stock-report-print/{managerId}', 'ManagerStockReportController@print')->name('managerStockReport.print');
      Route::post('manager-stock-report-print-selected', 'ManagerStockReportController@printSelected')->name('managerStockReport.printSelected');
      Route::get('manager-stock-report-details/{ledgerId}', 'ManagerStockReportController@details')->name('managerStockReport.details');

      //Trial Rreport
      Route::get('trial-stock-report', 'TrialStockReportController@index')->name('trialStockReport.index');
      Route::get('trial-stock-report-print', 'TrialStockReportController@printReport')->name('trialStockReport.printReport');
      Route::get('trial-stock-report-view/{userId}', 'TrialStockReportController@view')->name('trialStockReport.view');
      Route::get('trial-stock-report-current-view', 'TrialStockReportController@currentView')->name('trialStockReport.currentView');
      Route::get('trial-stock-report-view-stock/{accountId}/{voucherTypeId}', 'TrialStockReportController@viewStock')->name('trialStockReport.viewStock');
    });

    //Product Stock Position
    Route::get('product-stock-availability', 'ProductStockPositionController@index')->name('productStockPosition.index');
    Route::get('product-stock-availability-get-product-properties/{productId}', 'ProductStockPositionController@getProductProperties')->name('productStockPosition.getProductProperties');
    Route::post('product-stock-availability-get-report', 'ProductStockPositionController@getReport')->name('productStockPosition.getReport');


    Route::get('product-stock-availability-get-accounts/{accountGroupId}', 'ProductStockPositionController@getAccounts')->name('productStockPosition.getAccounts');
    Route::get('product-stock-availability-get-trialReports/{accountGroupId}/{accountId}', 'ProductStockPositionController@getTrialReports')->name('productStockPosition.getTrialReports');


    Route::get('product-stock-availability-view/{userId}', 'ProductStockPositionController@view')->name('productStockPosition.view');
    Route::get('product-stock-availability-view-stock/{accountId}/{voucherTypeId}', 'ProductStockPositionController@viewStock')->name('productStockPosition.viewStock');
    //Payment
    Route::group(['namespace' => 'Payment'], function () {


      //Payment Issue
      Route::get('payment-issue', 'PaymentIssueController@index')->name('paymentIssue.index');
      Route::get('payment-issue-create', 'PaymentIssueController@create')->name('paymentIssue.create');
      Route::get('payment-issue-get-payment-mode-accounts/{paymentMode}', 'PaymentIssueController@getPaymentModeAccounts')->name('paymentIssue.getPaymentModeAccounts');
      Route::get('payment-issue-get-store-managers/{storeId}', 'PaymentIssueController@getStoreManagers')->name('paymentIssue.getStoreManagers');
      Route::post('payment-issue-save', 'PaymentIssueController@save')->name('paymentIssue.save');
      Route::get('payment-issue-get-last-transactions/{accountId}', 'PaymentIssueController@getLastTransactions')->name('paymentIssue.getLastTransactions');

      //Payment Receive
      Route::get('payment-receive', 'PaymentReceiveController@index')->name('paymentReceive.index');
      Route::get('payment-receive-create', 'PaymentReceiveController@create')->name('paymentReceive.create');
      Route::get('payment-receive-get-payment-mode-accounts/{paymentMode}', 'PaymentReceiveController@getPaymentModeAccounts')->name('paymentReceive.getPaymentModeAccounts');
      Route::get('payment-receive-get-store-managers/{storeId}', 'PaymentReceiveController@getStoreManagers')->name('paymentReceive.getStoreManagers');
      Route::post('payment-receive-save', 'PaymentReceiveController@save')->name('paymentReceive.save');
      Route::get('payment-receive-get-last-transactions/{accountId}', 'PaymentReceiveController@getLastTransactions')->name('paymentReceive.getLastTransactions');

      //Payment Journal
      Route::get('payment-journal', 'PaymentJournalController@index')->name('paymentJournal.index');
      Route::get('payment-journal-create', 'PaymentJournalController@create')->name('paymentJournal.create');
      Route::get('payment-journal-get-payment-mode-accounts/{paymentMode}', 'PaymentJournalController@getPaymentModeAccounts')->name('paymentJournal.getPaymentModeAccounts');
      Route::get('payment-journal-get-stores-lits', 'PaymentJournalController@getStoresList')->name('paymentJournal.getStoresList');
      Route::get('payment-journal-get-store-managers/{storeId}', 'PaymentJournalController@getStoreManagers')->name('paymentJournal.getStoreManagers');
      Route::post('payment-journal-store', 'PaymentJournalController@store')->name('paymentJournal.store');
    });

    //Payment Ledger
    Route::group(['namespace' => 'PaymentDaybook'], function () {

      // //CurrentStockLedger
      // Route::get('current-bank-payment-ledger','CurrentBankPaymentLedgerController@index')->name('currentBankPaymentLedger.index');  

      // //StoreToManagerStockLedger
      // Route::get('store-check-manager-bank-payment-ledger','StoreCheckManagerBankPaymentLedgerController@index')->name('storeCheckManagerBankPaymentLedger.index');
      // Route::get('store-check-manager-bank-payment-ledger/{managerId}','StoreCheckManagerBankPaymentLedgerController@allTransactions')->name('storeCheckManagerBankPaymentLedger.all'); 


      //Manager paymentDaybook.Manager.getStoreAccounts
      Route::get('payment-daybook-manager', 'ManagerPaymentDaybookController@index')->name('paymentDaybookManager.index');
      Route::get('payment-daybook-get-accounts/{storeId}', 'ManagerPaymentDaybookController@getAccounts')->name('paymentDaybook.Manager.getAccounts');
      Route::post('payment-daybook-get-transactions', 'ManagerPaymentDaybookController@getTransactions')->name('paymentDaybook.Manager.getTransactions');
      // Route::get('store-to-store-payment-ledger-get-accounts/{accountGroupId}','StoreToStorePaymentLedgerController@getAccounts')->name('paymentLedger.getAccounts');
      // Route::get('store-to-store-payment-ledger-get/{storeId}','StoreToStorePaymentLedgerController@allTransactions')->name('paymentLedger.all'); 

    });

    //Payment Ledger
    Route::group(['namespace' => 'PaymentLedger'], function () {

      // //CurrentStockLedger
      // Route::get('current-bank-payment-ledger','CurrentBankPaymentLedgerController@index')->name('currentBankPaymentLedger.index');  

      // //StoreToManagerStockLedger
      // Route::get('store-check-manager-bank-payment-ledger','StoreCheckManagerBankPaymentLedgerController@index')->name('storeCheckManagerBankPaymentLedger.index');
      // Route::get('store-check-manager-bank-payment-ledger/{managerId}','StoreCheckManagerBankPaymentLedgerController@allTransactions')->name('storeCheckManagerBankPaymentLedger.all'); 

      //StoreToStoreLedger
      Route::get('manager-payment-ledger', 'ManagerPaymentLedgerController@index')->name('managerPaymentLedger.index');
      Route::get('manager-payment-ledger-all/{storeId}', 'ManagerPaymentLedgerController@all')->name('managerPaymentLedger.all');

      //StoreToStoreLedger
      Route::get('store-payment-ledger', 'StoreToStorePaymentLedgerController@index')->name('storeToStorePaymentLedger.index');
      Route::get('store-payment-ledger-all/{storeId}', 'StoreToStorePaymentLedgerController@all')->name('storeToStorePaymentLedger.all');
    });

    //Payment Ledger Bank
    Route::group(['namespace' => 'PaymentLedger\Bank'], function () {

      //CurrentStockLedger
      Route::get('current-bank-payment-ledger', 'CurrentBankPaymentLedgerController@index')->name('currentBankPaymentLedger.index');

      //StoreToManagerStockLedger
      Route::get('store-check-manager-bank-payment-ledger', 'StoreCheckManagerBankPaymentLedgerController@index')->name('storeCheckManagerBankPaymentLedger.index');
      Route::get('store-check-manager-bank-payment-ledger/{managerId}', 'StoreCheckManagerBankPaymentLedgerController@allTransactions')->name('storeCheckManagerBankPaymentLedger.all');

      //StoreToStoreLedger
      Route::get('store-to-store-bank-payment-ledger', 'StoreToStoreBankPaymentLedgerController@index')->name('storeToStoreBankPaymentLedger.index');
      Route::get('store-to-store-bank-payment-ledger/{storeId}', 'StoreToStoreBankPaymentLedgerController@allTransactions')->name('storeToStoreBankPaymentLedger.all');
    });

    //Payment Ledger Cash
    Route::group(['namespace' => 'PaymentLedger\Cash'], function () {

      //CurrentStockLedger
      Route::get('current-cash-payment-ledger', 'CurrentCashPaymentLedgerController@index')->name('currentCashPaymentLedger.index');

      //StoreToManagerStockLedger
      Route::get('store-check-manager-cash-payment-ledger', 'StoreCheckManagerCashPaymentLedgerController@index')->name('storeCheckManagerCashPaymentLedger.index');
      Route::get('store-check-manager-cash-payment-ledger/{managerId}', 'StoreCheckManagerCashPaymentLedgerController@allTransactions')->name('storeCheckManagerCashPaymentLedger.all');

      //StoreToStoreLedger
      Route::get('store-to-store-cash-payment-ledger', 'StoreToStoreCashPaymentLedgerController@index')->name('storeToStoreCashPaymentLedger.index');
      Route::get('store-to-store-cash-payment-ledger/{storeId}', 'StoreToStoreCashPaymentLedgerController@allTransactions')->name('storeToStoreCashPaymentLedger.all');
    });

    // Payment Ledger Final
    Route::group(['namespace' => 'PaymentLedger\Final1'], function () {

      //StoreToStoreFinalLedger
      Route::get('store-to-store-final-ledger', 'StoreToStoreFinalPaymentLedgerController@index')->name('storeToStoreFinalPaymentLedger.index');
      Route::get('store-to-store-final-ledger/{storeId}', 'StoreToStoreFinalPaymentLedgerController@allTransactions')->name('storeToStoreFinalPaymentLedger.all');
    });

    // Payment Ledger Journal
    Route::group(['namespace' => 'PaymentLedger\Journal'], function () {

      //CurrentJournalLedger
      Route::get('current-journal-payment-ledger', 'CurrentJournalPaymentLedgerController@index')->name('currentJournalPaymentLedger.index');
    });

    //Store Zone Attach+
    Route::get('store-discount', 'StoreDiscountController@index')->name('storeDiscount');
    Route::get('store-discount-get-states/{countryId}', 'StoreDiscountController@getStates')->name('storeDiscount.getStates');
    Route::get('store-discount-get-cities/{stateId}', 'StoreDiscountController@getCities')->name('storeDiscount.getCities');
    Route::post('store-discount-get-stores', 'StoreDiscountController@getStores')->name('storeDiscount.getStores');
    Route::get('store-discount-edit-store-role/{storeId}', 'StoreDiscountController@editStoreRole')->name('storeDiscount.editStoreRole');
    Route::post('store-discount-update-store-role', 'StoreDiscountController@updateStoreRole')->name('storeDiscount.updateStoreRole');
    Route::get('zone-attach-index/{zoneId}', 'StoreDiscountController@zoneAttachIndex')->name('storeDiscount.zoneAttachIndex');
    Route::get('store-discount-attach-zones-get-states/{countryId}', 'StoreDiscountController@attachZonesGetStates')->name('storeDiscount.attachZones.getStates');
    Route::get('store-discount-attach-zones-get-cities/{stateId}', 'StoreDiscountController@attachZonesGetCities')->name('storeDiscount.attachZones.getCities');
    Route::post('zone-attach-view', 'StoreDiscountController@zoneAttachView')->name('storeDiscount.zoneAttachView');
    Route::post('zone-attach', 'StoreDiscountController@zoneAttach')->name('storeDiscount.zoneAttach');

    //Transaction Images Controller 
    Route::get('ledger-media/{ledgerId}', 'LedgerMediaController@index')->name('ledgerMedia.index');
    Route::get('ledger-create/{ledgerId}', 'LedgerMediaController@create')->name('ledgerMedia.create');
    Route::get('ledger--media-all/{ledgerId}', 'LedgerMediaController@all')->name('ledgerMedia.all');
    Route::post('ledger-media-store', 'LedgerMediaController@store')->name('ledgerMedia.store');
    Route::get('ledger-media-finish-uploading/{ledgerId?}', 'LedgerMediaController@finishUploading')->name('ledgerMedia.finishUploading');

    //Product Stock Detail
    Route::get('product-stock-detail', 'ProductStockDetailController@index')->name('productStockDetail.index');
    Route::get('product-stock-get-detail/{gin}', 'ProductStockDetailController@getTimeLine')->name('productStockDetail.getDetail');

    //Product Stock Update
    Route::get('product-stock-update', 'ProductStockUpdateController@index')->name('productStockUpdate.index');
    Route::get('product-stock-update-detail/{gin}', 'ProductStockUpdateController@getTimeLine')->name('productStockUpdate.getDetail');
    Route::post('product-stock-update-update', 'ProductStockUpdateController@update')->name('productStockUpdate.update');

    //Product Timeline
    Route::get('product-timeline', 'ProductTimelineController@index')->name('productTimeline.index');
    Route::get('product-timeline-get-timeline/{gin}', 'ProductTimelineController@getTimeLine')->name('productTimeline.getTimeline');

    //SecurityPinRegenerate
    Route::get('security-pin-regenerate-request', 'StoreSecurityPinRegenerateController@index')->name('securityPinRegenerateRequest.index');
    Route::post('security-pin-regenerate-request-send', 'StoreSecurityPinRegenerateController@sendRequest')->name('securityPinRegenerateRequest.sendRequest');
    Route::get('security-pin-regenerate-request-all', 'StoreSecurityPinRegenerateController@allRequests')->name('securityPinRegenerateRequest.all');
    Route::post('security-pin-regenerate-request-resolve', 'StoreSecurityPinRegenerateController@resolve')->name('securityPinRegenerateRequest.resolve');
    Route::post('security-pin-regenerate-request-reset-direct', 'StoreSecurityPinRegenerateController@resetDirect')->name('securityPinRegenerateRequest.resetDirect');

    // WhiteList Ip Address 
    Route::get('whitelist-ip-address', 'WhitelistIpAddressController@index')->name('whitelistIpAddress.index');
    Route::post('whitelist-ip-address-save', 'WhitelistIpAddressController@save')->name('whitelistIpAddress.save');
    Route::get('whitelist-ip-address-all', 'WhitelistIpAddressController@all')->name('whitelistIpAddress.all');
    Route::get('whitelist-ip-address-view/{id}', 'WhitelistIpAddressController@view')->name('whitelistIpAddress.view');
    Route::get('whitelist-ip-address-delete/{id}', 'WhitelistIpAddressController@delete')->name('whitelistIpAddress.delete');
    Route::post('whitelist-ip-address-detach-users', 'WhitelistIpAddressController@detachUsers')->name('whitelistIpAddress.detachUsers');

    // Customer Invoice
    // Route::get('customer-invoice','CustomerInvoiceController@index')->name('customerInvoice.index');
    Route::get('customer-invoice', 'CustomerInvoiceController@create')->name('customerInvoice.create');
    Route::post('customer-invoice-find-customer', 'CustomerInvoiceController@findCustomer')->name('customerInvoice.findCustomer');
    Route::get('customer-invoice-create-customer', 'CustomerInvoiceController@createCustomer')->name('customerInvoice.createCustomer');
    Route::post('customer-invoice-save-customer', 'CustomerInvoiceController@saveCustomer')->name('customerInvoice.saveCustomer');
    Route::post('customer-invoice-save-gins', 'CustomerInvoiceController@saveGins')->name('customerInvoice.saveGins');
    Route::get('customer-invoice-get-all-details', 'CustomerInvoiceController@getAllDetails')->name('customerInvoice.getAllDetails');
    Route::get('customer-invoice-payment-create', 'CustomerInvoiceController@paymentCreate')->name('customerInvoice.paymentCreate');
    Route::get('customer-invoice-get-payment-accounts/{modeId?}', 'CustomerInvoiceController@getPaymentAccounts')->name('customerInvoice.getPaymentAccounts');
    Route::post('customer-invoice-payment-save', 'CustomerInvoiceController@paymentSave')->name('customerInvoice.paymentSave');
    Route::post('customer-invoice-place-order', 'CustomerInvoiceController@placeOrder')->name('customerInvoice.placeOrder');


    //Store View Master 
    Route::get('store-view-master', 'StoreViewMasterController@index')->name('storeViewMaster.index');
    Route::get('store-view-master-create', 'StoreViewMasterController@create')->name('storeViewMaster.create');
    Route::post('store-view-master-store', 'StoreViewMasterController@store')->name('storeViewMaster.store');
    Route::get('store-view-master-all', 'StoreViewMasterController@all')->name('storeViewMaster.all');
    Route::get('store-view-master-edit/{id}', 'StoreViewMasterController@edit')->name('storeViewMaster.edit');
    Route::post('store-view-master-update', 'StoreViewMasterController@update')->name('storeViewMaster.update');
    Route::get('store-view-master-status-update/{userId}', 'StoreViewMasterController@updateUserStatus')->name('storeViewMaster.changeStatus');
  });


  // ScreenshotServices
  Route::get('opening-stock-screenshot/{ledgerId}', 'ScreenshotServiceController@openingStockScreenshotTake')->name('openingStockScreenshotTake');

  Route::get('get-balance/{accountId}', function ($accountId) {

    $result =  Balance::getTotalBalance($accountId);
    if ($result['type'] == 'dr') {
      return "<span>Balance : </span><span style='color:red'>-" . $result['amount'] . "</span>";
    } else {
      return "<span>Balance : </span><span class='text-success'>" . $result['amount'] . "</span>";
    }
  })->name('getBalance');







  //fallback Clouse
  Route::fallback('Guard\StoreAuthController@routeFallback');
});
Route::view('ip-not-authorized', 'store.ipNotAuthorized')->name('ipNotAuthorized2');

// });
