<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/port', 'portController@add_port');
Route::post('/port/save', 'portController@save_port');
Route::post('first-user', [ 'as' => 'first-user', 'uses' => 'UserController@save_first_user']);

Route::group(['middleware' => ['auth']], function () {

    Route::get('rap/pap', 'rappapController@index');
    Route::post('rap/pap/save', 'rappapController@save');
    Route::get('rap/listview', 'rappapController@listview');

    /*New added*/

    Route::post('/store-user', 'HomeController@store')->name('store');

    Route::get('/create', 'HomeController@create');
    Route::get('/user-list', 'HomeController@user_list');
    Route::get('/search-center-name', 'HomeController@search_center_name');
    Route::get('/search-menu-permission', 'HomeController@search_menu_permission');
    Route::get('/delete_user/{a}', 'HomeController@delete_user');
    Route::get('/edit_user/{a}', 'HomeController@edit_user');
    Route::post('/update_user', 'HomeController@update_user');
    Route::get('/change-password', 'HomeController@change_password');
    Route::post('/password-changed', 'HomeController@password_changed');
    Route::get('/search-branch-name', 'HomeController@search_branch_name');

    Route::get('menu/index', 'MenuController@index');

    Route::get('menu/create', 'MenuController@create');
    Route::post('menu/store', 'MenuController@store')->name('storeies');

   // Ware house  add/edit/delete product
   Route::get('/addproduct','WarehouseController@addproduct')->name('addproduct');
   Route::post('/addproduct','WarehouseController@filter_product')->name('filter_product');
   Route::post('/storeaddproduct', 'WarehouseController@storeaddproduct')->name('storeaddproduct');
   Route::get('/reprint_product_code/{id}', 'WarehouseController@reprint_product_code')->name('reprint_product_code');
   Route::get('/editproduct/{a}', 'WarehouseController@editproduct')->name('editproduct');
   Route::post('/updateaddproduct', 'WarehouseController@updateaddproduct')->name('updateaddproduct');
   Route::get('/productdelete/{a}', 'WarehouseController@productdelete')->name('productdelete');


   // Ware house  product details
   Route::get('/productdetails','WarehouseController@productdetails')->name('productdetails');
   Route::post('/productdetails','WarehouseController@productdetails_view')->name('productdetails_view');
   Route::get('/stockin-report','WarehouseController@stockin_report')->name('stockin_report');
   Route::post('/stockin-report','WarehouseController@stockin_report_view')->name('productdetails_view');
   Route::get('/stockout-report','WarehouseController@stockout_report')->name('stockout_report');
   Route::post('/stockout-report','WarehouseController@stockout_report_view')->name('stockout_report_view');


   // Ware house  create product bar code
   Route::get('/productbarcode','WarehouseController@productbarcode')->name('productbarcode');
   Route::post('/storebarcode','WarehouseController@storebarcode')->name('storebarcode');
   Route::get('/barcodereport','WarehouseController@barcodereport')->name('barcodereport');
   Route::get('/barcodereprint/{a}','WarehouseController@barcodereprint')->name('barcodereprint');
   Route::post('ajax_product_type','WarehouseController@ajax_product_type')->name('ajax_product_type');

   // Ware house  stock in product with bar code
   Route::get('/stockin','WarehouseController@stockin')->name('stockin');
   Route::get('/ajaxRequest_stockin','WarehouseController@ajaxRequest_stockin')->name('ajaxRequest_stockin');

   // Ware house  stock out product with bar code
   Route::get('/stockout','WarehouseController@stockout')->name('stockout');
   Route::get('/stockout-m','WarehouseController@stockout_m')->name('stockout_m');
   Route::post('/stockout_m_store','WarehouseController@stockout_m_store')->name('stockout_m_store');
   Route::get('/onload-stockout-m-datas','WarehouseController@Onload_stockout_m_store')->name('Onload_stockout_m_store');
   Route::get('/ajaxRequest_stockout','WarehouseController@ajaxRequest_stockout')->name('ajaxRequest_stockout');


   //product order request
   Route::get('/order_request','OrderrequestController@order_request')->name('order_request');
   Route::post('/ajax_order_request_f_type','OrderrequestController@ajax_order_request_f_type')->name('ajax_order_request_f_type');
   Route::post('/ajax_order_request_filter_product_type','OrderrequestController@ajax_order_request_filter_product_type')->name('ajax_order_request_filter_product_type');
   Route::post('/store_order_request','OrderrequestController@store_order_request')->name('store_order_request');
   Route::get('/order_request/view','OrderrequestController@order_request_view');
   Route::get('/order_request/view/{id}','OrderrequestController@order_request_destroy');
   Route::get('/order_request_report','OrderrequestController@order_request_report')->name('order_request_report');
   Route::get('/ajaxRequest_totalweight','OrderrequestController@ajaxRequest_totalweight')->name('ajaxRequest_totalweight');
   Route::post('/order-report-search','OrderrequestController@order_report_search_by_date')->name('order-report-search');
   Route::post('/search-by-reference','OrderrequestController@search_by_reference')->name('search-by-reference');



   // customer
   Route::get('/customer','CustomerController@index')->name('index');
   Route::post('/storecustomer','CustomerController@store')->name('storecustomer');
   Route::get('/showcustomer','CustomerController@showcustomer')->name('showcustomer');
   Route::get('/customer-report','CustomerController@customer_report')->name('customer-report');

   Route::get('/editcustomer/{a}', 'CustomerController@editcustomer')->name('editcustomer');
   Route::post('/updatecustomer', 'CustomerController@updatecustomer')->name('updatecustomer');

   Route::get('/customerdelete/{a}', 'CustomerController@customerdelete')->name('customerdelete');


   // batcher
   Route::get('/batcher','BatcherController@batcherindex')->name('batcherindex');
   Route::post('/ajax_order_request_r_type','BatcherController@ajax_order_request_r_type')->name('ajax_order_request_r_type');
   Route::get('/showbatcher/{a}/{b}','BatcherController@showbatcher')->name('showbatcher');
   Route::get('/batcherhistory/reprint','BatcherController@batcher_reprint')->name('batcher_reprint');
   Route::post('/batcher-store','BatcherController@batcher_store')->name('/batcher-store');
   Route::post('/insertbatcher','BatcherController@insertbatcher')->name('insertbatcher');
   Route::get('/ajaxRequest_checkbarcode','BatcherController@ajaxRequest_checkbarcode')->name('ajaxRequest_checkbarcode');
   Route::get('/ajaxRequest_productweight','BatcherController@ajaxRequest_productweight')->name('ajaxRequest_productweight');
   Route::get('/print-barcode-unique/{a}/{b}','BatcherController@print_barcode_unique')->name('/print-barcode-unique');
   Route::get('/batcher_reprint_barcode/{a}/{b}','BatcherController@batcher_reprint_barcode')->name('/print-barcode-unique');
   Route::get('/ajaxRequest_mechine_data_read/', 'BatcherController@ajaxRequest_mechine_data_read')->name('ajaxRequest_mechine_data_read');
   Route::get('/batcher-report','BatcherController@batcher_report')->name('batcher_report');
   Route::post('/batcher-report','BatcherController@batcher_report_view')->name('batcher_report_view');


   //   production manager
    Route::get('/batcher-production','BatcherController@batcher_production');
    Route::post('/update-production-list','BatcherController@update_production_list')->name('/update-production-list');
    Route::get('/details-order/{a}','BatcherController@details_order')->name('details-order');
    Route::get('/production-status','BatcherController@search_machine_queue')->name('/production-status');
    Route::get('/packaging-status','BatcherController@packaging_stutas_view')->name('/packaging_stutas_view');
    Route::post('/packaging-status','BatcherController@packaging_stutas')->name('/packaging_stutas');
    Route::post('/packaging-status/{a}','BatcherController@packaging_stutas_by')->name('/packaging_stutas');
    Route::post('/update-production-status','BatcherController@update_production_status')->name('/update-production-status');
    Route::post('/finish-production-status','BatcherController@finish_production_status')->name('/finish-production-status');
    Route::post('/production-start','BatcherController@production_start')->name('/production-start');
    Route::post('/search-machine-queue','BatcherController@search_machine_queue')->name('/search-machine-queue');
    Route::get('/search-machine-queue_by_id/{a}','BatcherController@search_machine_queue_by_id')->name('/search-machine-queue_by_id');

    // Print slip
    Route::get('/print-slip','SlipPrintController@index')->name('/print-slip');
    Route::post('/store-slip-print','SlipPrintController@store')->name('/store-slip-print');
    Route::get('/slip-print-a4/{a}/{b}/{c}','SlipPrintController@slip_print_a4')->name('slip_print_a4');
    Route::get('/print-slip-report','SlipPrintController@slip_print_report')->name('slip_print_report');
    Route::post('/print-slip-report','SlipPrintController@slip_print_report_view')->name('slip_print_report_view');

    // supplier
   Route::get('/supplier','SupplierController@index')->name('index');
   Route::post('/storesupplier','SupplierController@storesupplier')->name('storesupplier');
   Route::get('/viewsupplier','SupplierController@viewsupplier')->name('viewsupplier');
   Route::get('/editsupplier/{a}', 'SupplierController@editsupplier')->name('editsupplier');
   Route::post('/updatesupplier', 'SupplierController@updatesupplier')->name('updatesupplier');
   Route::get('/supplierdelete/{a}', 'SupplierController@supplierdelete')->name('supplierdelete');

   // formula
   Route::get('/addformula','FormulaController@addformula')->name('addformula');
   Route::post('/addformula','FormulaController@filterAddformula')->name('filterAddformula');
   Route::post('/store_formula','FormulaController@store_formula')->name('store_formula');
   Route::get('/viewformula','FormulaController@viewformula')->name('viewformula');
   Route::post('/viewformula','FormulaController@filterformulaview')->name('filterformulaview');
   Route::get('/editformula/{name}','FormulaController@editformula')->name('editformula');
   Route::get('/deleteformula/{name}','FormulaController@deleteformula')->name('deleteformula');

   // machine
   Route::get('/addmachine','MachineController@addmachine')->name('addmachine');
   Route::post('/storemachine','MachineController@storemachine')->name('storemachine');
   Route::get('/viewmachine','MachineController@viewmachine')->name('viewmachine');
   Route::get('/editmachine/{a}', 'MachineController@editmachine')->name('editmachine');
   Route::post('/updatemachine', 'MachineController@updatemachine')->name('updatemachine');
   Route::get('/machinedelete/{a}','MachineController@machinedelete')->name('machinedelete');

//    order status report
    Route::get('/orders-status-report','OrderrequestController@orders_status_report')->name('/orders-status-report');
    Route::post('/order-status-report-search','OrderrequestController@orders_status_report_search')->name('order-status-report-search');



//    create menu
    Route::get('/search-sub-menu', 'MenuController@search_sub_menu');

});

route::get('weightmachine/add', 'WeightMachineController@add_weight_machine');
route::post('weightmachine/add', 'WeightMachineController@store_weight_machine');
route::get('weightmachine/view', 'WeightMachineController@view_weight_machine');
route::get('weightmachine/edit/{id}', 'WeightMachineController@edit_weight_machine');
route::post('weightmachine/update', 'WeightMachineController@update_weight_machine');
route::get('weightmachine/delete/{id}', 'WeightMachineController@delete_weight_machine');


route::get('producttype/add', 'ProductTypeController@add_product_type');
route::post('producttype/add', 'ProductTypeController@store_product_type');
route::get('producttype/view', 'ProductTypeController@view_product_type');
route::get('producttype/edit/{id}', 'ProductTypeController@edit_product_type');
route::post('producttype/update', 'ProductTypeController@update_product_type');
route::get('producttype/delete/{id}', 'ProductTypeController@delete_product_type');
