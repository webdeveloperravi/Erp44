<?php

Route::get('/',function(){
  return redirect()->route('admin'); 
});

Route::get('/login','AdminAuthController@index')->name('admin'); 
Route::get('/loginform','AdminAuthController@loginForm')->name('admin.loginForm');
Route::post('/resendOtp','AdminAuthController@resendOtp')->name('admin.resendOtp');
Route::post('/voiceOtp','AdminAuthController@voiceOtp')->name('admin.voiceOtp');

Route::post('/verifyAccount','AdminAuthController@verifyAccount')->name('admin.verifyAccount'); 
Route::get('/logout-1', 'AdminAuthController@logout')->name('admin.logout'); 
Route::post('/otp-verify-check','AdminAuthController@verifyOTP')->name('admin.verifyOTP'); 
  
Route::group(['middleware'=>['admin'],  'namespace' =>'Auth'], function(){

    //Security Pin
    Route::post('security-pin','AdminAuthController@securityPinVerify')->name('admin.security.pin');
    Route::get('security-pin-set/{status}','AdminAuthController@setSecurityPinStatus')->name('admin.set.security.status');
  	Route::get('security-pin-status-get/','AdminAuthController@getSecurityPinStatus')->name('admin.get.security.status');
});	

Route::group(['middleware'=> ['admin','admin_role_module']],function(){
    
  Route::group(['namespace'=> 'Profile'] ,function(){ 
      
    //Store Profile
    Route::get('profile','AdminProfileController@index')->name('adminProfile');
    Route::get('profile-edit-basic-information','AdminProfileController@editBasicInformation')->name('adminProfile.editBasicInformation');
    Route::post('profile-update-basic-information','AdminProfileController@updateBasicInformation')->name('adminProfile.updateBasicInformation');  

    //Store Profile Address
    Route::get('profile-address-all','AdminProfileAddressController@all')->name('adminProfile.getAddresses'); Route::get('profile-address-create','AdminProfileAddressController@create')->name('adminProfile.createAddress');
    Route::post('profile-address-store','AdminProfileAddressController@store')->name('adminProfile.storeAddress');
    Route::get('profile-address-edit/{addressId}','AdminProfileAddressController@edit')->name('adminProfile.editAddress');
    Route::post('profile-address-update','AdminProfileAddressController@update')->name('adminProfile.updateAddress');
    Route::get('profile-address-delete/{id}','AdminProfileAddressController@deleteAddress')->name('adminProfile.deleteAddress');
    
  });

  //Dashboard
  Route::get('/dashboard','DashboardController@index')->name('admin.dashboard');
  
  Route::group(['namespace' =>'Setting'], function(){
      
      Route::get('settings','SettingsController@index')->name('settings.index');
      Route::post('settings-update','SettingsController@update')->name('settings.update');
  
      //Warehouse Role
      Route::get('warehouse-role','WarehouseRoleController@create')->name('warehouse.role.create');
      Route::get('warehouse-role-index','WarehouseRoleController@roleList')->name('warehouse.role.index');
      Route::post('warehouse-role-store','WarehouseRoleController@store')->name('warehouse.role.store');
      Route::get('warehouse-role-edit/{id}','WarehouseRoleController@edit')->name('warehouse.role.edit');
      Route::post('warehouse-role-update','WarehouseRoleController@update')->name('warehouse.role.update');
      Route::get('warehouse-role-status-update/{id}','WarehouseRoleController@statusUpdate')->name('warehouse.role.status.update'); 
      // Route::get('warehouse-role-modules/create/{id}','WarehouseRoleModuleController@create')->name('warehouse.role.module.create');
      // Route::get('warehouse-role-modules/index/{id}','WarehouseRoleModuleController@index')->name('warehouse.role.module.index');
      // Route::post('warehouse-role-modules-save','WarehouseRoleModuleController@store')->name('warehouse.role.module.store');
      // Route::get('warehouse-role-modules-edit/{id}','WarehouseRoleModuleController@edit')->name('warehouse.role.module.edit');
      // Route::post('warehouse-role-modules-update','WarehouseRoleModuleController@update')->name('warehouse.role.module.update');
      
      //Warehouse Role Modules
      Route::get('warehouse-role-modules-edit/{id}','WarehouseRoleModuleController@edit')->name('warehouseRoleModule.edit');
      Route::post('warehouse-role-modules-update','WarehouseRoleModuleController@update')->name('warehouseRoleModule.update');
  
      //Admin Role
      Route::get('admin-role','AdminRoleController@create')->name('admin.role.create');
      Route::get('admin-role-index','AdminRoleController@roleList')->name('admin.role.index');
      Route::post('admin-role-store','AdminRoleController@store')->name('admin.role.store');
      Route::get('admin-role-edit/{id}','AdminRoleController@edit')->name('admin.role.edit');
      Route::post('admin-role-update','AdminRoleController@update')->name('admin.role.update');
      Route::get('admin-role-status-update/{id}','AdminRoleController@statusUpdate')->name('admin.role.status.update'); 

      //Admin Role Modules
      Route::get('admin-role-modules-edit/{id}','AdminRoleModuleController@edit')->name('adminRoleModule.edit');
      Route::post('admin-role-modules-update','AdminRoleModuleController@update')->name('adminRoleModule.update');


      // Route::get('admin-role-modules/create/{id}','AdminRoleModuleController@create')->name('admin.role.module.create');
      // Route::get('admin-role-modules/index/{id}','AdminRoleModuleController@index')->name('admin.role.module.index');
      // Route::post('admin-role-modules-save','AdminRoleModuleController@store')->name('admin.role.module.store');
      // Route::get('admin-role-modules-edit/{id}','AdminRoleModuleController@edit')->name('admin.role.module.edit');
      // Route::post('admin-role-modules-update','AdminRoleModuleController@update')->name('admin.role.module.update');
  
      //Modules
      Route::get('modules','ModuleController@index')->name('modules'); 
      Route::get('menu-list','ModuleController@moduleList')->name('menu.list'); 
      Route::get('menu-parent-list/{id?}','ModuleController@parentMenu')->name('menu.parent.menu'); 
      Route::post('menu-save','ModuleController@store')->name('menu.store'); 
      Route::get('menu-edit/{id}','ModuleController@edit')->name('menu.edit'); 
      Route::post('menu-update','ModuleController@update')->name('menu.update'); 
      Route::get('menu-delete/{id}','ModuleController@destroy')->name('menu.destroy'); 
      Route::get("menu-parentsort",'ModuleController@parentSort')->name('menu.parentsort'); 
      Route::get("menu-childsort",'ModuleController@childSort')->name('menu.childsort'); 
      Route::get("menu-sub-childsort",'ModuleController@subChildSort')->name('menu.subchildsort');
  });

  
Route::group(['namespace' =>'Organization'], function(){

  //Address type
   Route::get('address-type','AddressTypeController@index')->name('address-type');
   Route::get('address-type-list','AddressTypeController@typeList')->name('addresstype.list');
   Route::post('address-type-store','AddressTypeController@store')->name('addresstype.store');
   Route::post('address-type-update','AddressTypeController@update')->name('addresstype.update');
   Route::get('address-type-status/{id}/{status}','AddressTypeController@status')->name('addresstype.status');
 
   //Discount Rate
   Route::get('discount-rate','DiscountRateController@index')->name('org-role-discount-rate');
   Route::get('discount-rate-list','DiscountRateController@rateList')->name('discountrate.list');
   Route::post('discount-rate-store','DiscountRateController@store')->name('discountrate.store');
   Route::post('discount-rate-update','DiscountRateController@update')->name('discountrate.update');
   Route::get('discount-rate-status/{id}/{status}','DiscountRateController@status')->name('discountrate.status');
 
   //Tax Type
    Route::get('tax-type','TaxTypeController@index')->name('tax-type');
    Route::get('tax-type-list','TaxTypeController@taxTypeList')->name('taxtype.list');
    Route::post('tax-type-store','TaxTypeController@store')->name('taxtype.store');
    Route::post('tax-type-update','TaxTypeController@update')->name('taxtype.update');
    Route::get('tax-type-status/{id}/{status}','TaxTypeController@status')->name('taxtype.status');
 
    //Tax rate
    Route::get('tax-rate','TaxRateController@index')->name('tax-rate');
    Route::get('tax-rate-list','TaxRateController@taxRateList')->name('taxrate.list');
    Route::post('tax-rate-store','TaxRateController@store')->name('taxrate.store');
    Route::get('tax-rate-edit/{id}','TaxRateController@edit')->name('taxrate.edit');
    Route::post('tax-rate-update','TaxRateController@update')->name('taxrate.update');
    Route::get('tax-rate-status/{id}/{status}','TaxRateController@status')->name('taxrate.status');
 
    //Unit
    Route::get('unit','UnitController@index')->name('unit');
    Route::get('unit-list','UnitController@unitList')->name('unit.list');
    Route::post('unit-store','UnitController@store')->name('unit.store');
    Route::post('unit-update','UnitController@update')->name('unit.update');
    Route::get('unit-status/{id}/{status}','UnitController@status')->name('unit.status');
 
    //Unit Conversion
    Route::get('unit-conversion','UnitConversionController@index')->name('unit-conversion');
    Route::get('unit-conversion-list','UnitConversionController@unitConversionList')->name('unitconversion.list');
    Route::get('unit-conversion-subunit/{id}','UnitConversionController@getSubUnit')->name('unitconversion.subunit');
    Route::post('unit-conversion-store','UnitConversionController@store')->name('unitconversion.store');
    Route::get('unit-conversion-edit/{id}','UnitConversionController@edit')->name('unitconversion.edit');
    Route::post('unit-conversion-update','UnitConversionController@update')->name('unitconversion.update');
    Route::get('unit-conversion-status/{id}/{status}','UnitConversionController@status')->name('unit.status');
 
    //Org Role 
    Route::get('org-role','OrgRoleController@index')->name('org-role');  
    Route::get('org-role-list','OrgRoleController@orgRoleList')->name('org-role-list');  
    Route::post('org-role-store','OrgRoleController@store')->name('org-role-store');  
    Route::post('org-role-update','OrgRoleController@update')->name('org-role-update');  
    Route::get('org-role-status/{id}/{status}','OrgRoleController@status')->name('org-role-status');  
    Route::get('org-role-config/{id}','OrgRoleController@editConfig')->name('org.role.config.edit');  
    Route::post('org-role-config-update','OrgRoleController@updateConfig')->name('org.role.config.update');   
    Route::get('org-role-module-edit/{roleId}','OrgRoleModuleController@edit')->name('org.role.module.edit');
    Route::post('org-role-module-update','OrgRoleModuleController@update')->name('org.role.module.update');
     
    //Retail Model
    Route::get('retail-model','RetailModelController@index')->name('retail.model.index');
    Route::get('retail-model-create','RetailModelController@create')->name('retail.model.create');
    Route::get('retail-model-view/{id}','RetailModelController@oneView')->name('retail.model.view');
    Route::get('retail-model-parent-list','RetailModelController@showParentList')->name('retail.model.parent');
    Route::get('retail-model-list','RetailModelController@view')->name('retail.model.list');
    Route::post('retail-model-store','RetailModelController@store')->name('retail.model.store');
    Route::get('retail-model-edit/{id}','RetailModelController@edit')->name('retail.model.edit');
    Route::post('retail-model-update','RetailModelController@update')->name('retail.model.update');
    Route::get('retail-model-get-discount-rate/{id}','RetailModelController@getDiscountRates')->name('retail.model.getdiscountrates');
    Route::get('retail-model-status-update/{id}','RetailModelController@statusUpdate')->name('retail.model.status.update');
 });

 
 
Route::group(['namespace'=>'Master'],function(){

  //Social Media Type 
  Route::get('social-media-type','SocialMediaTypeController@index')->name('socialMediaType.index');
  Route::get('social-media-type-create','SocialMediaTypeController@create')->name('socialMediaType.create');
  Route::post('social-media-type-store','SocialMediaTypeController@store')->name('socialMediaType.store');
  Route::get('social-media-type-all','SocialMediaTypeController@all')->name('socialMediaType.all');
  Route::get('social-media-type-edit/{id}','SocialMediaTypeController@edit')->name('socialMediaType.edit');
  Route::post('social-media-type-update','SocialMediaTypeController@update')->name('socialMediaType.update');

  // Voucher 
  Route::get('voucher','VoucherController@index')->name('voucher.index');
  Route::get('voucher-create','VoucherController@create')->name('voucher.create');
  Route::post('voucher-store','VoucherController@store')->name('voucher.store');
  Route::get('voucher-all','VoucherController@all')->name('voucher.all');
  Route::get('voucher-edit/{id}','VoucherController@edit')->name('voucher.edit');
  Route::post('voucher-update','VoucherController@update')->name('voucher.update');

  //Polish Crud
  Route::get('polish','PolishController@index')->name('polish.index');
  Route::get('polish-create','PolishController@create')->name('polish.create');
  Route::post('polish-store','PolishController@store')->name('polish.store');
  Route::get('polish-all','PolishController@all')->name('polish.all');
  Route::get('polish-edit/{id}','PolishController@edit')->name('polish.edit');
  Route::post('polish-update','PolishController@update')->name('polish.update');
  Route::get('polish-status/{id}','PolishController@status')->name('polish.status');

  // Symmetry Crud
  Route::get('symmetry','SymmetryController@index')->name('symmetry.index');
  Route::get('symmetry-create','SymmetryController@create')->name('symmetry.create');
  Route::post('symmetry-store','SymmetryController@store')->name('symmetry.store');
  Route::get('symmetry-all','SymmetryController@all')->name('symmetry.all');
  Route::get('symmetry-edit/{id}','SymmetryController@edit')->name('symmetry.edit');
  Route::post('symmetry-update','SymmetryController@update')->name('symmetry.update');
  Route::get('symmetry-status/{id}','SymmetryController@status')->name('symmetry.status');
    
  // Gridel Crud
  Route::get('gridle','GridleController@index')->name('gridle.index');
  Route::get('gridle-create','GridleController@create')->name('gridle.create');
  Route::post('gridle-store','GridleController@store')->name('gridle.store');
  Route::get('gridle-all','GridleController@all')->name('gridle.all');
  Route::get('gridle-edit/{id}','GridleController@edit')->name('gridle.edit');
  Route::post('gridle-update','GridleController@update')->name('gridle.update'); 
  Route::get('gridle-status/{id}','GridleController@status')->name('gridle.status'); 

  //Culet Crud
  Route::get('culet','CuletController@index')->name('culet.index');
  Route::get('culet-create','CuletController@create')->name('culet.create');
  Route::post('culet-store','CuletController@store')->name('culet.store');
  Route::get('culet-all','CuletController@all')->name('culet.all');
  Route::get('culet-edit/{id}','CuletController@edit')->name('culet.edit');
  Route::post('culet-update','CuletController@update')->name('culet.update');  
  Route::get('culet-status/{id}','CuletController@status')->name('culet.status');  
  
  //Fluorescence Crud
  Route::get('fluorescence','FluorescenceController@index')->name('fluorescence.index');
  Route::get('fluorescence-create','FluorescenceController@create')->name('fluorescence.create');
  Route::post('fluorescence-store','FluorescenceController@store')->name('fluorescence.store');
  Route::get('fluorescence-all','FluorescenceController@all')->name('fluorescence.all');
  Route::get('fluorescence-edit/{id}','FluorescenceController@edit')->name('fluorescence.edit');
  Route::post('fluorescence-update','FluorescenceController@update')->name('fluorescence.update'); 
  Route::get('fluorescence-status/{id}','FluorescenceController@status')->name('fluorescence.status'); 
  
  //Make Type
  Route::get('make-type','MakeTypeController@index')->name('make.type');
  Route::get('make-type-list','MakeTypeController@makeTypeList')->name('make.type.list');
  Route::post('make-type-store','MakeTypeController@store')->name('make.type.store');
  Route::post('make-type-update','MakeTypeController@update')->name('make.type.update');
  Route::get('make-type-status/{id}/{status}','MakeTypeController@status')->name('make.type.status');

  //Cut
  Route::get('cut','CutController@index')->name('cut');
  Route::get('cut-list','CutController@cutList')->name('cut.list');
  Route::post('cut-store','CutController@store')->name('cut.store');
  Route::post('cut-update','CutController@update')->name('cut.update');
  Route::get('cut-status/{id}/{status}','CutController@status')->name('cut.status');

  //Master
  Route::get('master','MasterController@index')->name('master');
  Route::get('master-list','MasterController@master_list')->name('master.list.view');
  Route::post('master-store','MasterController@store')->name('master.store');
  Route::post('master-update','MasterController@update')->name('master.update');
  Route::get('master-status/{id}/{status}','MasterController@status')->name('master.status');

  //Pending Task
  Route::get('pending-task','CommonController@index')->name('pending-task');  

  //HSN Code 
  Route::get('hsn-code','HSNCodeController@index')->name('hsn.code');
  Route::get('hsn-code-view','HSNCodeController@view')->name('hsn.code.view');
  Route::get('hsn-code-edit/{id}','HSNCodeController@edit')->name('hsn.code.edit');
  Route::post('hsn-code-store','HSNCodeController@store')->name('hsn.code.store');
  Route::post('hsn-code-update','HSNCodeController@update')->name('hsn.code.update');
  Route::get('hsn-code-status/{id}/{status}','HSNCodeController@status')->name('hsn.code.status'); 
  Route::get('hsn-code-assign/{id}/{hsncode}','HSNCodeController@assign_hsncode_rate')->name('hsn.code.assign.rate');
  Route::post('hsn-code-assign-store','HSNCodeController@assign_rate_store')->name('hsn.code.assign.rate.store');
  Route::get('hsn-code-assign-edit/{id}','HSNCodeController@assign_hsn_code_edit')->name('hsn.code.assign.edit');
  Route::post('hsn-code-assign-update','HSNCodeController@assign_hsn_code_update')->name('hsn.code.assign.update');

  //Department User
  Route::get('department-user','DepartmentUserController@index')->name('department-user'); 
  Route::post('user-store','DepartmentUserController@store')->name('user.store'); 
  Route::get('user-view','DepartmentUserController@viewAll')->name('user.view'); 
  Route::get('user-view/{id}','DepartmentUserController@randomTableView')->name('user.random.table'); 
  Route::get('user-edit/{id}/{role_id}','DepartmentUserController@randomTableREdit')->name('user.random.table.redit'); 
  Route::post('user-update','DepartmentUserController@update')->name('user.update'); 
  Route::get('user-role/{id}','DepartmentUserController@getRole')->name('user.role');
  Route::get('user-role/123','DepartmentUserController@super');
  Route::post('user-role-send-otp','DepartmentUserController@send_email_otp')->name('user.send.otp'); 
  Route::post('user-role-email','DepartmentUserController@email_verify')->name('user.email.verify'); 
  Route::post('user-role-reg-email','DepartmentUserController@reg_email_verify')->name('user.reg.email.verify'); 
  Route::get('user-department_view/{id}/{role_id}','DepartmentUserController@department_view')->name('user.department.view'); 
  Route::get('user-department-status/{id}/{role_id}/{status}','DepartmentUserController@status')->name('user.department.status'); 
  Route::get('user-department-get-phonecode/{id}','DepartmentUserController@getPhoneCode')->name('user.department.get.countrycode');
   
  //Warehouse User 
  Route::get('warehouse-user','WarehouseUserController@index')->name('warehouseUser.index');
  Route::get('warehouse-user-create','WarehouseUserController@create')->name('warehouseUser.create');
  Route::post('warehouse-user-store','WarehouseUserController@store')->name('warehouseUser.store');
  Route::get('warehouse-user-all','WarehouseUserController@all')->name('warehouseUser.all');
  Route::get('warehouse-user-edit/{id}','WarehouseUserController@edit')->name('warehouseUser.edit');
  Route::post('warehouse-user-update','WarehouseUserController@update')->name('warehouseUser.update');
  Route::get('warehouse-user-status-update/{userId}','WarehouseUserController@updateUserStatus')->name('warehouseUser.changeStatus');
  
  //Admin User 
  Route::get('admin-user','AdminUserController@index')->name('adminUser.index');
  Route::get('admin-user-create','AdminUserController@create')->name('adminUser.create');
  Route::post('admin-user-store','AdminUserController@store')->name('adminUser.store');
  Route::get('admin-user-all','AdminUserController@all')->name('adminUser.all');
  Route::get('admin-user-edit/{id}','AdminUserController@edit')->name('adminUser.edit');
  Route::post('admin-user-update','AdminUserController@update')->name('adminUser.update');
  Route::get('admin-user-status-update/{userId}','AdminUserController@updateUserStatus')->name('adminUser.changeStatus');


  //Product
  Route::get('product','ProductController@index')->name('product');
  Route::get('category-list','ProductController@index')->name('category.list');
  Route::post('product-category-store','ProductController@store')->name('product.cat.store');
  Route::post('product-category-assign-color','ProductController@assign_category')->name('product.cat.assign.color'); 
  Route::post('product-category-assign-single','ProductController@assign_from_to')->name('product.cat.assign.single');
  Route::post('product-category-update','ProductController@update')->name('product.category.update');

  //Product Category
  Route::get('product-category','ProductCategoryController@index')->name('product-category');
  Route::get('product-category-list','ProductCategoryController@productCategoryList')->name('product.cat.list');
  Route::get('product-type-create','ProductCategoryController@create')->name('admin.product_type.create');
  Route::post('product-type','ProductCategoryController@store')->name('product-type.store');
  Route::get('product-type-status/{id}/{status}','ProductCategoryController@status')->name('product.type.status');
  Route::get('product-type-edit/{id}','ProductCategoryController@edit')->name('product.type.edit');
  Route::post('product-type-update','ProductCategoryController@update')->name('product.type.update');
  Route::get('product-type-destroy/{id}','ProductCategoryController@destroy')->name('product.type.destroy');
  // Route::get('product-type-unit/{id}/{assign}','ProductCategoryController@unitAssigned')->name('product.type.unit');
  // Route::post('product-type-unit-store','ProductCategoryController@storeUnit')->name('product.type.store.unit');
 
  // Attach Master View And Create
  Route::get('product-category-master/{productCategoryId}','ProductCategoryController@masterAttachView')->name('productCategoryMasterAttach.view');
  Route::post('product-category-master-attach','ProductCategoryController@masterAttach')->name('productCategory.masterAttach');
   // Attach Units View And Create
   Route::get('product-category-unit/{productCategoryId}','ProductCategoryController@unitAttachView')->name('productCategoryunitAttach.view');
   Route::post('product-category-unit-attach','ProductCategoryController@unitAttach')->name('productCategory.unitAttach');
  
  //product Grade Rate Profile
  Route::get('product-grade-rate-assignment','ProductGradeRateProfileController@index')->name('product-grade-rate-assignment');
  Route::post('product-grade-rate-profile-store','ProductGradeRateProfileController@store')->name('grade.rate.prof.store'); 
  Route::get('get-grade-list/{id}','ProductGradeRateProfileController@getGradeList')->name('product.getGradeList');
  Route::get('get-rate-profile-list/{id}','ProductGradeRateProfileController@getRateProfileList')->name('product.getRateProfileList');
  Route::get('get-unsigned-grades-rate-profiles/{id}','ProductGradeRateProfileController@getUnsignedGradesAndRateProfiles')->name('getUnsignedGradesAndRateProfiles');
  Route::get('edit-product-grade-rate-profile/{productId}/{gradeId}/{rateProfileId}','ProductGradeRateProfileController@editGradeRateProfile')->name('editProductGradeRateProfile');
  Route::get('status-product-grade-rate-profile/{productId}/{gradeId}/{rateProfileId}','ProductGradeRateProfileController@statusGradeRateProfile')->name('statusProductGradeRateProfile');
  Route::post('update-product-grade-rate-profile','ProductGradeRateProfileController@updateProductGradeRateProfile')->name('updateProductGradeRateProfile');
  Route::get('product-grade/{id}','ProductGradeRateProfileController@getRateProfile')->name('assign.item.rateprofile');
  Route::get('assign-grade_view','ProductGradeRateProfileController@assignGradeView')->name('assign.grade.view');  
  Route::get('product-grade-rate-profile-status/{id}/{status}','ProductGradeRateProfileController@status')->name('product.grade.rate.profile.status');
  Route::post('product-grade-rate-update','ProductGradeRateProfileController@update')->name('category-grade-rate.update');
  Route::get('product-category-grade-view','ProductGradeRateProfileController@view')->name('category.grade.view');
  Route::post('product-category-assigned-viewall','ProductGradeRateProfileController@viewAll')->name('view.all');
  Route::post('catagory-filter','ProductGradeRateProfileController@filterCategory')->name('category.filter');
   
  //Origin
  Route::get('origin','ProductMOriginController@index')->name('origin');
  Route::post('origin-save','ProductMOriginController@store')->name('origin.store');
  Route::post('origin-update','ProductMOriginController@update')->name('origin.update');
  Route::get('origin-delete/{id}','ProductMOriginController@destroy')->name('origin.del');
  Route::get('origin-status/{id}/{status}','ProductMOriginController@status')->name('origin.status');
  Route::get('origin-exist/{name}','ProductMOriginController@originExist');
  Route::get('origin-alias-exist/{name}','ProductMOriginController@aliasExist');
  Route::get('origin-exist-edit/{id}/{name}','ProductMOriginController@originEditExist');
  Route::get('origin-alias-exist-edit/{id}/{name}','ProductMOriginController@aliasEditExist');
  
  //Color 
  Route::get('color','ProductMColourController@index')->name('colour');
  Route::get('color1','ProductMColourController@fetchData')->name('color1');
  Route::post('color-save','ProductMColourController@store')->name('color.store');
  Route::post('color-update','ProductMColourController@update')->name('color.update');
  Route::get('color-delete/{id}','ProductMColourController@destroy')->name('color.del');
  Route::get('color-status/{id}/{status}','ProductMColourController@status')->name('color.status');
  Route::get('color-exist/{name}','ProductMColourController@colorExist');
  Route::get('color-alias-exist/{name}','ProductMColourController@aliasExist');
  Route::get('color-exist-edit/{id}/{name}','ProductMColourController@colorEditExist');
  Route::get('color-alias-exist-edit/{id}/{name}','ProductMColourController@aliasEditExist');
  Route::get('color-type/{type}','ProductMColourController@notification');
  
   //Clarity
  Route::get('clarity','ProductMClarityController@index')->name('clarity');
  Route::post('clarity-save','ProductMClarityController@store')->name('clarity.store');
  Route::post('clarity-update','ProductMClarityController@update')->name('clarity.update');
  Route::get('clarity-delete/{id}','ProductMClarityController@destroy')->name('clarity.del');
  Route::get('clarity-status/{id}/{status}','ProductMClarityController@status')->name('clarity.status');
  Route::get('clarity-exist/{name}','ProductMClarityController@clarityExist');
  Route::get('clarity-alias-exist/{name}','ProductMClarityController@aliasExist');
  Route::get('clarity-exist-edit/{id}/{name}','ProductMClarityController@clarityEditExist');
  Route::get('clarity-alias-exist-edit/{id}/{name}','ProductMClarityController@aliasEditExist');
  Route::get("clarity-parentsort",'ProductMClarityController@parentSort')->name('clarity.parentsort');
  
  //Shape
  Route::get('shape','ProductMShapeController@index')->name('shape');
  Route::post('shape-save','ProductMShapeController@store')->name('shape.store');
  Route::post('shape-update','ProductMShapeController@update')->name('shape.update');
  Route::get('shape-delete/{id}','ProductMShapeController@destroy')->name('shape.del');
  Route::get('shape-status/{id}/{status}','ProductMShapeController@status')->name('shape.status');
  Route::get('shape-exist/{name}','ProductMShapeController@shapeExist');
  Route::get('shape-alias-exist/{name}','ProductMShapeController@aliasExist');
  Route::get('shape-exist-edit/{id}/{name}','ProductMShapeController@shapeEditExist');
  Route::get('shape-alias-exist-edit/{id}/{name}','ProductMShapeController@aliasEditExist');
  
  // Grade
  Route::get('grade','ProductMGradeController@index')->name('grade');
  Route::post('grade-save','ProductMGradeController@store')->name('grade.store');
  Route::post('grade-update','ProductMGradeController@update')->name('grade.update');
  Route::get('grade-delete/{id}','ProductMGradeController@destroy')->name('grade.del');
  Route::get('grade-status/{id}/{status}','ProductMGradeController@status')->name('grade.status');
  Route::get('grade-exist/{name}','ProductMGradeController@gradeExist');
  Route::get('grade-alias-exist/{name}','ProductMGradeController@aliasExist');
  Route::get('grade-exist-edit/{id}/{name}','ProductMGradeController@gradeEditExist');
  Route::get('grade-alias-exist-edit/{id}/{name}','ProductMGradeController@aliasEditExist'); 
  Route::get("grade-parentsort",'ProductMGradeController@parentSort')->name('grade.parentsort');
  
  //Species
  Route::get('species','ProductMSpeciesController@index')->name('species');
  Route::post('species-save','ProductMSpeciesController@store')->name('species.store');
  Route::post('species-update','ProductMSpeciesController@update')->name('species.update');
  Route::get('species-delete/{id}','ProductMSpeciesController@destroy')->name('species.del');
  Route::get('species-status/{id}/{status}','ProductMSpeciesController@status')->name('species.status');
  Route::get('species-exist/{name}','ProductMSpeciesController@specieExist');
  Route::get('species-alias-exist/{name}','ProductMSpeciesController@aliasExist');
  Route::get('species-exist-edit/{id}/{name}','ProductMSpeciesController@specieEditExist');
  Route::get('species-alias-exist-edit/{id}/{name}','ProductMSpeciesController@aliasEditExist');
  
  //SG
  Route::get('sg','ProductMSgController@index')->name('sg');
  Route::post('sg-save','ProductMSgController@store')->name('sg.store');
  Route::post('sg-update','ProductMSgController@update')->name('sg.update');
  Route::get('sg-delete/{id}','ProductMSgController@destroy')->name('sg.destroy');
  Route::get('sg-status/{id}/{status}','ProductMSgController@status')->name('sg.status');
  Route::get('sg-from-exist/{name}','ProductMSgController@sgFromExist');
  Route::get('sg-to-exist/{name}','ProductMSgController@sgToExist');
  Route::get('sg-from-exist-edit/{id}/{name}','ProductMSgController@sgFromExistEdit');
  Route::get('sg-to-exist-edit/{id}/{name}','ProductMSgController@sgToExistEdit');
  
  //RI
  Route::get('ri','ProductMRiController@index')->name('ri');
  Route::post('ri-save','ProductMRiController@store')->name('ri.store');
  Route::post('ri-update','ProductMRiController@update')->name('ri.update');
  Route::get('ri-delete/{id}','ProductMRiController@destroy')->name('ri.destroy');
  Route::get('ri-status/{id}/{status}','ProductMRiController@status')->name('ri.status');
  Route::get('ri-from-exist/{name}','ProductMRiController@riFromExist');
  Route::get('ri-to-exist/{name}','ProductMRiController@riToExist');
  Route::get('ri-from-exist-edit/{id}/{name}','ProductMRiController@riFromExistEdit');
  Route::get('ri-to-exist-edit/{id}/{name}','ProductMRiController@riToExistEdit');
  
  //Treatment 
  Route::get('treatment','ProductMTreatmentController@index')->name('treatment');
  Route::post('treatment-save','ProductMTreatmentController@store')->name('treatment.store');
  Route::post('treatment-update','ProductMTreatmentController@update')->name('treatment.update');
  Route::get('treatment-delete/{id}','ProductMTreatmentController@destroy')->name('treatment.destroy');
  Route::get('treatment-status/{id}/{status}','ProductMTreatmentController@status')->name('treatment.status');
  Route::get('treatment-name-exist/{name}','ProductMTreatmentController@treatmentNameExist');
  Route::get('treatment-desc-exist/{name}','ProductMTreatmentController@treatmentDescExist');
  Route::get('treatment-name-exist-edit/{id}/{name}','ProductMTreatmentController@treatmentNameExistEdit');
  Route::get('treatment-desc-exist-edit/{id}/{name}','ProductMTreatmentController@treatmentDescExistEdit');
 
  //Rate profile
  Route::get('rate-profile','ProductRateProfileController@index')->name('rate.profile');
  Route::post('rate-profile-save','ProductRateProfileController@store')->name('rate.profile.store');
  Route::post('rate-profile-update','ProductRateProfileController@update')->name('rate.profile.update');
  Route::get('rate-profile-delete/{id}','ProductRateProfileController@destroy')->name('rate.profile.del');
  Route::get('rate-profile-status/{id}/{status}','ProductRateProfileController@status')->name('rate.profile.status');
  Route::get('rate-profile-name-exist/{name}','ProductRateProfileController@rateProfileExist')->name('rate.profile.name');
  Route::get('rate-profile-desc-exist/{name}','ProductRateProfileController@rateProfileDescExist');
  Route::get('rate-profile-name-exist-edit/{id}/{name}','ProductRateProfileController@editRateProfileExist');
  Route::get('rate-profile-desc-exist-edit/{id}/{name}','ProductRateProfileController@editRateProfileDescExist'); 
  Route::get("rate-profile-parentsort",'ProductRateProfileController@parentSort')->name('rate.profile.parentsort');
  
  //Weight Range
  Route::get('weight-range','ProductMWeightRangeController@index')->name('weight.range');
  Route::post('weight-range-save','ProductMWeightRangeController@store')->name('weight.range.store');
  Route::post('weight-range-update','ProductMWeightRangeController@update')->name('weight.range.update');
  Route::get('weight-range-delete/{id}','ProductMWeightRangeController@destroy')->name('weight.range.destroy');
  Route::get('weight-range-status/{id}/{status}','ProductMWeightRangeController@status')->name('weight.range.status');
  Route::get('add-new-weight-range','ProductMWeightRangeController@add_new_weight_range')->name('weight.new.range'); 
  Route::any('rate-profile-assign-weight-range/{id}','ProductRateProfileController@assignWeightRange')->name('r.w.rate_profile_assign_weight_range');
  Route::get('rate-profile-weight-range/{id}','ProductRateProfileController@new_range')->name('profile_weight_range.new_range');
  Route::post('rate-profile-weight-range-store','ProductRateProfileController@rateWeightStore')->name('rate.profile.rate.weight.range.price'); 
  Route::post('rate-profile-weight-range-update','ProductRateProfileController@update_price')->name('profile_weight_price_update.update_price'); 
  Route::get('rate-profile-price-history/{rateProfileId}','ProductRateProfileController@store_price_history')->name('price.history.store_price_history');
  Route::get('rate-profile-price-history-data/{id}/{date}','ProductRateProfileController@get_price_history');
  Route::get('rate-profile-fetch-price-history','ProductRateProfileController@fetchPriceHistory')->name('price.history.fetch');
  
  //Tax
  Route::get('tax-profile','ProductTaxProfileController@index')->name('taxprofile');
  Route::post('tax-profile-save','ProductTaxProfileController@store')->name('taxprofile.store');
  Route::get('tax-profile-status/{id}/{status}','ProductTaxProfileController@status')->name('taxprofile.status');
 
  // Account Group
  Route::get('account-group','AccountGroupController@index')->name('account.group.index');
  Route::get('account-group-create','AccountGroupController@create')->name('account.group.create');
  Route::post('account-group-store','AccountGroupController@store')->name('account.group.store');
  Route::get('account-group-all','AccountGroupController@all')->name('account.group.all');
  Route::get('account-group-edit/{id}','AccountGroupController@edit')->name('account.group.edit');
  Route::post('account-group-update','AccountGroupController@update')->name('account.group.update');
  Route::get('account-group-status-update/{groupId}/{status}','AccountGroupController@statusUpdate')->name('account.group.statusUpdate');

});

//Zone Crud
Route::get('zone','Master\ZoneController@index')->name('zone.index');
Route::get('zone-all','Master\ZoneController@all')->name('zone.all');
Route::get('zone-view/{countryId?}/{stateId?}','Master\ZoneController@view')->name('zone.view');
Route::get('zone-view-two/{zoneId}','Master\ZoneController@viewTwo')->name('zone.view.two');
Route::get('zone-create','Master\ZoneController@create')->name('zone.create');
Route::get('zone-states/{id}','Master\ZoneController@states')->name('zone.states');
Route::get('zone-states-index/{id}','Master\ZoneController@statesindex')->name('zone.states.index');
Route::post('zone-store','Master\ZoneController@store')->name('zone.store');
Route::get('zone-edit/{id}','Master\ZoneController@edit')->name('zone.edit');
Route::post('zone-update','Master\ZoneController@update')->name('zone.update');
Route::get('zone-delete','Master\ZoneController@delete')->name('zone.delete');

//Area Attach
Route::get('area-attach-view/{zoneId}','Master\ZoneController@areasAttachView')->name('areas.attach.view');
Route::post('area-attach','Master\ZoneController@areasAttach')->name('areas.attach');


//Area Crud
Route::get('area-index/{zoneId}','Master\AreaController@index')->name('area.index');
Route::get('area-create/{zoneId}','Master\AreaController@create')->name('area.create');
Route::post('area-store','Master\AreaController@store')->name('area.store');
Route::get('area-edit/{id}','Master\AreaController@edit')->name('area.edit');
Route::post('area-update','Master\AreaController@update')->name('area.update');
Route::get('area-delete','Master\AreaController@delete')->name('area.delete');


//City Crud
Route::get('city','Master\StateCityController@index')->name('city.index');
Route::get('city-view/{stateId}','Master\StateCityController@view')->name('city.view');
Route::get('city-create/{stateId}','Master\StateCityController@create')->name('city.create');
Route::post('city-store','Master\StateCityController@store')->name('city.store');
Route::get('city-edit/{id}','Master\StateCityController@edit')->name('city.edit');
Route::post('city-update','Master\StateCityController@update')->name('city.update');
Route::get('city-delete','Master\StateCityController@delete')->name('city.delete');
Route::get('city-states/{id}','Master\StateCityController@states')->name('city.states');

// //WhiteList Ip Address 
// Route::get('whitelist-ip-address','WhitelistIpAddressController@index')->name('whitelistIpAddress.index');
// Route::post('whitelist-ip-address-save','WhitelistIpAddressController@save')->name('whitelistIpAddress.save');
// Route::get('whitelist-ip-address-all','WhitelistIpAddressController@all')->name('whitelistIpAddress.all');
// Route::get('whitelist-ip-address-delete/{id}','WhitelistIpAddressController@delete')->name('whitelistIpAddress.delete');
     
});
 
 