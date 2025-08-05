<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LeftingController;
use App\Http\Controllers\PowerController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\CertificationsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DailyInspaction;
use App\Http\Controllers\MonthlyInspaction;
use App\Http\Controllers\MaintenanceLog;
use App\Http\Controllers\ServiceReport;
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

//API Routes
Route::group(['prefix'=>'api'], function(){

    Route::post('/login',[UserController::class, 'login']);
    Route::post('/register',[UserController::class, 'RegisterForm']);
    Route::get('/logout',[UserController::class, 'logout']);

    Route::get('/get/equipment',[EquipmentController::class, 'Index']);
    Route::post('/add/employee',[EquipmentController::class, 'store']);
    Route::post('/get/equipment/{id}',[EquipmentController::class, 'getSingleEquipment']);
    Route::post('/update/equipment/{id}',[EquipmentController::class, 'updateEquipment']);
    Route::get('/delete/equipment/{id}', [EquipmentController::class, 'DeleteEquipment']);

    // DailyInspaction Modules

    Route::post('/add/dailyinspact',[DailyInspaction::class, 'Store']);
    Route::get('/dailyinspact',[DailyInspaction::class, 'Index']);
    Route::post('/single/dailyinspact/{id}',[DailyInspaction::class, 'getSingleIntegration']);
    Route::post('/update/dailyinspact/{id}',[DailyInspaction::class, 'updateIntegration']);
    Route::get('/delete/dailyinspact/{id}', [DailyInspaction::class, 'DailyInspactionDelete']);

    // MonthlyInspaction Modules
    Route::get('monthlyinspact',[MonthlyInspaction::class, 'Index']);
    Route::post('/add/monthlyinspact',[MonthlyInspaction::class, 'Store']);
    Route::post('/single/monthlyinspact/{id}',[MonthlyInspaction::class, 'Show']);
    Route::post('/update/monthlyinspact/{id}',[MonthlyInspaction::class, 'updateMonthlyInspaction']);
    Route::get('/delete/monthlyinspact/{id}', [MonthlyInspaction::class, 'MonthlyInspactionDelete']);

    // MaintenanceLog Modules
    Route::get('/maintenancelog',[MaintenanceLog::class, 'Index']);
    Route::post('/single/maintenancelog/{id}',[MaintenanceLog::class, 'Show']);
    Route::post('/update/maintenancelog/{id}',[MaintenanceLog::class, 'Show']);
    Route::get('/delete/maintenancelog/{id}', [MaintenanceLog::class, 'MaintenanceLogDelete']);
    Route::post('/add/maintenancelog',[MaintenanceLog::class, 'Store']);
    
    // ServiceReport Modules
    Route::get('/servicereport',[ServiceReport::class, 'Index']);
    Route::post('/add/servicereport',[ServiceReport::class, 'Store']);
    Route::post('/single/servicereport/{id}',[ServiceReport::class, 'Show']);
    Route::post('/update/servicereport/{id}',[ServiceReport::class, 'updateServiceReport']);
    Route::get('/delete/servicereport/{id}', [ServiceReport::class, 'ServiceReportDelete']);

    // LeftingController Modules

    Route::get('/leftingtool',[LeftingController::class, 'Index']);
    Route::post('/add/lefting',[LeftingController::class, 'Store']);
    Route::post('/get/lefting/{id}',[LeftingController::class, 'getSinglelefting']);
    Route::post('/update/lefting/{id}',[LeftingController::class, 'updatelefting']);
    Route::get('/delete/lefting/{id}', [LeftingController::class, 'Deletelefting']);
    
    // PowerController Modules

    Route::get('/powertool',[PowerController::class, 'Index']);
    Route::post('/add/powertool',[PowerController::class, 'Store']);
    Route::post('/get/powertool/{id}',[PowerController::class, 'getSinglePower']);
    Route::post('/update/powertool/{id}',[PowerController::class, 'updatePower']);
    Route::get('/delete/powertool/{id}', [PowerController::class, 'DeletePower']);

    // VehiclesController Modules

    Route::get('/vehiclestool',[VehiclesController::class, 'Index']);
    Route::post('/add/vehicles',[VehiclesController::class, 'store']);
    Route::post('/get/vehicles/{id}',[VehiclesController::class, 'getSingleVehicles']);
    Route::post('/update/vehicles/{id}',[VehiclesController::class, 'updateVehicles']);
    Route::get('/delete/vehicles/{id}', [VehiclesController::class, 'DeleteVehicles']);

    // OperatorController Modules

    Route::get('/operator',[OperatorController::class, 'Index']);
    Route::post('/add/operator',[OperatorController::class, 'Store']);
    Route::post('/get/operator/{id}',[OperatorController::class, 'getSingleOperator']);
    Route::post('/update/operator/{id}',[OperatorController::class, 'updateOperator']);
    Route::get('/delete/operator/{id}', [OperatorController::class, 'DeleteOperator']);

    // OperatorController Modules

    Route::get('/maintenance',[MaintenanceController::class, 'Index']);
    Route::post('/add/maintenance',[MaintenanceController::class, 'Store']);
    Route::post('/get/maintenance/{id}',[MaintenanceController::class, 'getSingleMaintenance']);
    Route::post('/update/maintenance/{id}',[MaintenanceController::class, 'updateMaintenance']);
    Route::get('/delete/maintenance/{id}', [MaintenanceController::class, 'DeleteMaintenance']);

    // CertificationsController Modules

    Route::get('/certifications',[CertificationsController::class, 'Index']);
    Route::post('/add/certifications',[CertificationsController::class, 'Store']);
    Route::post('/get/certifications/{id}',[CertificationsController::class, 'getSingleCertifications']);
    Route::post('/update/certifications/{id}',[CertificationsController::class, 'updateCertifications']);
    Route::get('/delete/certifications/{id}', [CertificationsController::class, 'DeleteCertifications']);

    // ProjectsController Modules

    Route::get('/projects',[ProjectsController::class, 'Index']);
    Route::post('/add/projects',[ProjectsController::class, 'Store']);
    Route::post('/get/projects/{id}',[ProjectsController::class, 'getSingleProjects']);
    Route::post('/update/projects/{id}',[ProjectsController::class, 'updateProjects']);
    Route::get('/delete/projects/{id}', [ProjectsController::class, 'DeleteProjects']);

    // DocumentsController Modules

    Route::get('/documents',[DocumentsController::class, 'Index']);
    Route::post('/add/documents',[DocumentsController::class, 'Store']);
    Route::post('/get/documents/{id}',[DocumentsController::class, 'getSingleDocuments']);
    Route::post('/update/documents/{id}',[DocumentsController::class, 'updateDocuments']);
    Route::get('/delete/documents/{id}', [DocumentsController::class, 'DeleteDocuments']);

    // IntegrationController Modules

    Route::get('/integration',[IntegrationController::class, 'Index']);
    Route::post('/add/integration',[IntegrationController::class, 'Store']);
    Route::post('/get/integration/{id}',[IntegrationController::class, 'getSingleIntegration']);
    Route::post('/update/integration/{id}',[IntegrationController::class, 'updateIntegration']);
    Route::get('/delete/integration/{id}', [IntegrationController::class, 'DeleteIntegration']);

});
