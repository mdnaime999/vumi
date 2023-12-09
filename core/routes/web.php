<?php

use App\Http\Controllers\DesignationDepartmentController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\PortsController;
use App\Http\Controllers\LandClassificationController;
use App\Http\Controllers\LandTypeController;
use App\Http\Controllers\LsCaseController;
use App\Http\Controllers\TexController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\TofsilController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/', [App\Http\Controllers\IndexController::class, 'front'])->name('/');

// Admin Route
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::post('/update_profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('update_profile');
    Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');
    Route::post('/update_password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update_password');

    /* department */
    Route::get('/add/department', [DesignationDepartmentController::class, 'adddepartment'])->name('add.department');
    Route::post('/save/department', [DesignationDepartmentController::class, 'saveDepartment'])->name('save.department');
    Route::get('/manage/department', [DesignationDepartmentController::class, 'manageDepartment'])->name('manage.department');
    Route::post('/get_department', [DesignationDepartmentController::class, 'getDepartment']);
    Route::get('/edit/department/{id}', [DesignationDepartmentController::class, 'editDepartment'])->name('edit.department');
    Route::post('/update/department', [DesignationDepartmentController::class, 'updateDepartment'])->name('update.department');
    Route::post('/delete_department', [DesignationDepartmentController::class, 'deleteDepartment']);
    /* designation */
    Route::get('/add/designation', [DesignationDepartmentController::class, 'addDesignation'])->name('add.designation');
    Route::post('/save/designation', [DesignationDepartmentController::class, 'saveDesignation'])->name('save.designation');
    Route::get('/manage/designation', [DesignationDepartmentController::class, 'manageDesignation'])->name('manage.designation');
    Route::post('/get_designation', [DesignationDepartmentController::class, 'getDesignation']);
    Route::get('/edit/designation/{id}', [DesignationDepartmentController::class, 'editDesignation'])->name('edit.designation');
    Route::post('/update/designation', [DesignationDepartmentController::class, 'updateDesignation'])->name('update.designation');
    Route::post('/delete_designation', [DesignationDepartmentController::class, 'deleteDesignation']);

    Route::post('/get_designation_for_role', [DesignationDepartmentController::class, 'getDesignationForRole']);
    Route::post('/get_designation_for_role_transfer', [DesignationDepartmentController::class, 'getDesignationForRoleTransfer']);

    //port
    Route::get('/view_ports', [PortsController::class, 'viewPorts'])->name('view_port');
    Route::post('/get_ports', [PortsController::class, 'getPorts'])->name('get_ports');
    Route::post('/save_port', [PortsController::class, 'savePort'])->name('save_port');
    Route::post('/update_port', [PortsController::class, 'updatePort'])->name('update_port');
    Route::post('/delete_port', [PortsController::class, 'deletePort']);
    Route::get('/add_port', [PortsController::class, 'addPort'])->name('add_port');
    Route::get('/edit_port/{id}', [PortsController::class, 'editPort'])->name('edit_port');

    //land classification
    Route::get('/manage/land/classification', [LandClassificationController::class, 'manageLandClassification'])->name('manage.land.classification');
    Route::post('/get_land_classifications', [LandClassificationController::class, 'getLandClassification']);
    Route::post('/save/land/classification', [LandClassificationController::class, 'saveLandClassification'])->name('save.land.classification');
    Route::post('/update/land/classification', [LandClassificationController::class, 'updateLandClassification'])->name('update.land.classification');
    Route::post('/delete_land_classification', [LandClassificationController::class, 'deleteLandClassification']);
    Route::get('/add/land/classification', [LandClassificationController::class, 'addLandClassification'])->name('add.land.classification');
    Route::get('/edit/land/classification/{id}', [LandClassificationController::class, 'editLandClassification'])->name('edit.land.classification');

    //land type
    Route::get('/manage/land/type', [LandTypeController::class, 'manageLandType'])->name('manage.land.type');
    Route::post('/get_land_types', [LandTypeController::class, 'getLandType']);
    Route::post('/save/land/type', [LandTypeController::class, 'saveLandType'])->name('save.land.type');
    Route::post('/update/land/type', [LandTypeController::class, 'updateLandType'])->name('update.land.type');
    Route::post('/delete_land_type', [LandTypeController::class, 'deleteLandType']);
    Route::get('/add/land/type', [LandTypeController::class, 'addLandType'])->name('add.land.type');
    Route::get('/edit/land/type/{id}', [LandTypeController::class, 'editLandType'])->name('edit.land.type');

    // tofsil
    Route::get('/manage/tofsil', [TofsilController::class, 'manageTofsil'])->name('manage.tofsil');
    Route::post('/get_tofsils', [TofsilController::class, 'getTofsil']);
    //ajax call
    Route::post('/get_ls_case_no', [TofsilController::class, 'getLsCaseNo']);
    Route::post('/save/tofsil', [TofsilController::class, 'saveTofsil'])->name('save.tofsil');
    Route::post('/update/tofsil', [TofsilController::class, 'updateTofsil'])->name('update.tofsil');
    Route::post('/delete_tofsil', [TofsilController::class, 'deleteTofsil']);
    Route::get('/add/tofsil/{id}', [TofsilController::class, 'addTofsil'])->name('add.tofsil');
    Route::get('/edit/tofsil/{id}', [TofsilController::class, 'editTofsil'])->name('edit.tofsil');

    //ls case
    Route::get('/manage/ls/case', [LsCaseController::class, 'manageLsCase'])->name('manage.ls.case');
    Route::post('/get_ls_case', [LsCaseController::class, 'getLsCase']);
    Route::post('/save/ls/case', [LsCaseController::class, 'saveLsCase'])->name('save.ls.case');
    Route::post('/update/ls/case', [LsCaseController::class, 'updateLsCase'])->name('update.ls.case');
    Route::post('/delete_ls_case', [LsCaseController::class, 'deleteLsCase']);
    Route::get('/add/ls/case', [LsCaseController::class, 'addLsCase'])->name('add.ls.case');
    Route::get('/edit/ls/case/{id}', [LsCaseController::class, 'editLsCase'])->name('edit.ls.case');

    //establishment
    Route::get('/manage/establishment', [EstablishmentController::class, 'manageEstablishment'])->name('manage.establishment');
    Route::post('/get_establishment', [EstablishmentController::class, 'getEstablishment']);
    Route::post('/save/establishment', [EstablishmentController::class, 'saveEstablishment'])->name('save.establishment');
    Route::post('/update/establishment', [EstablishmentController::class, 'updateEstablishment'])->name('update.establishment');
    Route::post('/delete_establishment', [EstablishmentController::class, 'deleteEstablishment']);
    Route::get('/add/establishment', [EstablishmentController::class, 'addEstablishment'])->name('add.establishment');
    Route::get('/edit/establishment/{id}', [EstablishmentController::class, 'editEstablishment'])->name('edit.establishment');

    /* Requisition */
    Route::post('/send/dispatch', [RequisitionController::class, 'sendSispatch'])->name('send.dispatch');
    Route::get('/requisition/request', [RequisitionController::class, 'requisitionRequest'])->name('requisition.request');
    Route::post('/get_requisition_request', [RequisitionController::class, 'getRequisitionRequest']);
    Route::get('/requisition/approve/{id}', [RequisitionController::class, 'requisitionApprove'])->name('requisition.approve');
    Route::get('/requisition/reject/{id}', [RequisitionController::class, 'requisitionReject'])->name('requisition.reject');

    Route::get('/add/requisition', [RequisitionController::class, 'addRequisition'])->name('add.requisition');
    Route::post('/get_product_stock_items', [RequisitionController::class, 'getProductStockItems']);
    Route::post('/save/requisition', [RequisitionController::class, 'saveRequisition'])->name('save.requisition');
    Route::get('/manage/requisition', [RequisitionController::class, 'manageRequisition'])->name('manage.requisition');
    Route::post('/get_requisition', [RequisitionController::class, 'getRequisition']);
    Route::get('/edit/requisition/{id}', [RequisitionController::class, 'editRequisition'])->name('edit.requisition');
    Route::post('/update/requisition', [RequisitionController::class, 'updateRequisition'])->name('update.requisition');
    Route::post('/delete_requisition', [RequisitionController::class, 'deleteRequisition']);

    /* Product Stock */
    Route::get('/add/product/stock', [ProductStockController::class, 'addProductStock'])->name('add.product.stock');
    Route::post('/save/product/stock', [ProductStockController::class, 'saveProductStock'])->name('save.product.stock');
    Route::get('/manage/product/stock', [ProductStockController::class, 'manageProductStock'])->name('manage.product.stock');
    Route::post('/get_product_stock', [ProductStockController::class, 'getProductStock']);
    Route::post('/update/product/stock', [ProductStockController::class, 'updateProductStock'])->name('update.product.stock');
    Route::post('/delete_product_stock', [ProductStockController::class, 'deleteProductStock']);

    Route::get('/manage/product/stock/details/{id}', [ProductStockController::class, 'manageProductStockDetails'])->name('manage.product.stock.details');
    Route::post('/get_product_stock_details', [ProductStockController::class, 'getProductStockDetails']);
    Route::get('/edit/product/stock/details/{id}', [ProductStockController::class, 'editProductStockDetails'])->name('edit.product.stock.details');
    Route::post('/update/product/stock/details', [ProductStockController::class, 'updateProductStockDetails'])->name('update.product.stock.details');
    Route::post('/delete_product_stock_details', [ProductStockController::class, 'deleteProductStockDetails']);

    // Route::get('/manage/product/stock/info', [ProductStockController::class, 'manageProductStockInfo'])->name('manage.product.stock.info');
    Route::get('/manage/product/stock/info/{id}', [ProductStockController::class, 'manageProductStockInfo'])->name('manage.product.stock.info');
    Route::post('/get_product_stock_info', [ProductStockController::class, 'getProductStockInfo']);
    Route::get('/product/tender/details/{id}', [ProductStockController::class, 'productTenderDetails'])->name('product.tender.details');
    Route::post('/get_product_tender_details', [ProductStockController::class, 'getProductTenderDetails']);
    Route::get('/user/stock/info', [ProductStockController::class, 'userStockInfo'])->name('user.stock.info');
    Route::post('/get_user_stock_info', [ProductStockController::class, 'getUserStockInfo']);
    Route::post('/search_user_stock_info', [ProductStockController::class, 'searchUserStockInfo']);

    // Rrequistion
    Route::get('view/requistion/{id}', [RequisitionController::class, 'viewRequistion'])->name('view.requisition');


    // manage port
    Route::get('/manage/store/report', [PortsController::class, 'portList'])->name('manage.port.list');
    Route::post('/port-data-get', [PortsController::class, 'PortDataGet']);
    Route::get('/manage/tofsil/report/{id}', [PortsController::class, 'tofsilList'])->name('tofsil.list');

    // Building details view
    Route::get('/building/details/{id}', [PortsController::class, 'buildingDetails'])->name('building.details');

    Route::get('/manage/role/transfer', [DesignationDepartmentController::class, 'roleTransfer'])->name('manage.role.transfer');

    // role transfer add
    Route::get('/add/role/transfer', [DesignationDepartmentController::class, 'roleTransferAdd'])->name('add.role.transfer');
    Route::post('/submit/role/transfer', [DesignationDepartmentController::class, 'roleTransferSubmit'])->name('submit.role.transfer');
    Route::post('/get_transfer_role', [DesignationDepartmentController::class, 'roleTransferGet']); // ajax request

    // sthapona details
    Route::get('/get/infrasture/{id}', [PortsController::class, 'infrastureDetails'])->name('infrasture.details');
    Route::get('/depreciation/calclution/{number}', [PortsController::class, 'DepreciationCalclution'])->name('depreciation.calclution');

    // ls case tex
    Route::get('/ls_case_tax/{id}', [TexController::class, 'TexReturn'])->name('ls_case_tax');
    Route::get('/add_tex/{id}', [TexController::class, 'AddTex'])->name('add_tex');
    Route::post('/save_tex', [TexController::class, 'saveTex'])->name('save.tex');
});
