<?php

use App\Models\Monitoring;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RealtimeController;
use App\Http\Controllers\Operator\ScheduleController;
use App\Http\Controllers\WorkorderReportController;

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

//
// Realtime Controller Route
//
Route::middleware(['verified'])->group(function(){
    Route::get('/', [RealtimeController::class,'index'])->name('home');
    Route::get('/ajaxRequest',[RealtimeController::class,'ajaxRequest'])->name('realtime.ajaxRequest');
    Route::get('/speedChart', [RealtimeController::class,'speedChart'])->name('realtime.speedChart');
    Route::get('/getMachines', [RealtimeController::class,'getMachines'])->name('realtime.getMachines');
    Route::get('/workorderOnProcess', [RealtimeController::class,'workorderOnProcess'])->name('realtime.workorderOnProcess');
    Route::post('/searchSpeed',[RealtimeController::class,'searchSpeed'])->name('realtime.searchSpeed');
    Route::post('/searchSpeedProduction',[RealtimeController::class,'searchSpeedProduction'])->name('realtime.searchSpeedProduction');
});

//
// Daily Report Controller Route
//
Route::prefix('dailyReport')->controller(DailyReportController::class)->middleware(['verified'])->group(function(){
    Route::get('/','index')->name('dailyReport.index');
    Route::get('/ajaxRequestAll','ajaxRequestAll')->name('dailyReport.ajaxRequestAll');
    Route::get('/getCustomFilterData','getCustomFilterData')->name('dailyReport.getCustomFilterData');
    Route::post('/calculateSearchResult','calculateSearchResult')->name('dailyReport.calculateSearchResult');
});

//
// Workorder Controller Route
//
Route::prefix('workorder')->controller(WorkorderController::class)->middleware(['verified'])->group(function(){
    Route::get('/','index')->name('workorder.index');
    Route::get('/ajaxRequestWorkorder','ajaxRequestAll')->name('workorder.ajaxRequestAll');
    Route::get('/{workorder}/show','show')->name('workorder.show');
    Route::post('/getDowntime','getDowntime')->name('workorder.getDowntime');
    Route::post('/getOee','getOee')->name('workorder.getOee');
    Route::get('/speedChart','speedChart')->name('workorder.speedChart');

    Route::get('/dataclosed','workordersClosed')->name('workorder.dataclosed');
});

//
// Workorder Controller Route
//
Route::middleware(['verified'])->group(function(){
    Route::get('/workorder/{workorder}/export', [WorkorderReportController::class, 'export'])->name('workorder.export');
    Route::post('/workorder/batchDownload', [WorkorderReportController::class, 'batchDownload'])->name('workorder.batchDownload');
    Route::get('/workorder/downloadFile/{file}', [WorkorderReportController::class, 'downloadFile'])->name('workorder.downloadFile');
    // Route::post('/workorder/downloadStatus', [WorkorderReportController::class, 'downloadStatus'])->name('workorder.batchDownloadStatus');
});

//
// Report Controller Route
//
Route::middleware(['verified'])->group(function(){
    Route::get('/report/{production}/printToPdf',[ReportController::class,'printToPdf'])->name('report.printToPdf');
});

//
// Schedule Controller Route
//
Route::middleware(['verified'])->group(function(){
    Route::get('/operator/schedule',[ScheduleController::class,'index'])->name('schedule.index');
    Route::post('/operator/schedule/{id}/process',[ScheduleController::class,'process']);
	Route::post('/operator/schedule/{id}/check',[ScheduleController::class,'check']);
    Route::get('/operator/showWaiting',[ScheduleController::class,'showWaiting'])->name('workorder.showWaiting');
    Route::get('/operator/showOnProcess',[ScheduleController::class,'showOnProcess'])->name('workorder.showOnProcess');
	Route::get('/operator/showOnCheck',[ScheduleController::class,'showOnCheck'])->name('workorder.showOnCheck');
});

//
// Production Controller Route
//
Route::prefix('operator/production')->controller(Operator\ProductionController::class)->middleware(['verified'])->group(function(){
    Route::get('/','index')->name('production.index');
	Route::get('/{workorder}/show','show')->name('operator.production.show');
    Route::get('/showOnProcess','showOnProcess')->name('operator.production.showOnProcess');

    Route::post('/store','store')->name('production.store');
    Route::get('/{production}/edit','edit')->name('production.edit');
    Route::put('/{production}/update','update')->name('production.update');
    Route::delete('/{production}/delete','destroy')->name('production.delete');
    
    Route::post('/getSmeltingNum','getSmeltingNum')->name('production.getSmeltingNum');
    Route::post('/storeOee','storeOee')->name('production.storeOee');
    Route::post('/getProductionInfo','getProductionInfo')->name('production.getProductionInfo');
    Route::get('/speedChart','speedChart')->name('production.speedChart');

	Route::post('/{workorder}/finish','finish')->name('operator.production.finish');
	Route::post('/{workorder}/finishWithDelete','finishWithDelete')->name('operator.production.finishWithDelete');

    Route::post('/{workorder}/forceCloseInitiation','forceCloseInitiation')->name('operator.production.forceCloseInitiation');
    Route::post('/{workorder}/forceCloseApproved','forceCloseApproved')->name('operator.production.forceCloseApproved');
});

//
// Bypass Workorder
//
Route::prefix('bypass')->controller(BypassWorkorderController::class)->middleware(['auth'])->group(function(){
    Route::get('/','index')->name('bypass.index');
    Route::get('/initiated','initiated')->name('bypass.initiated');
    Route::get('/history','history')->name('bypass.history');
});

//
// SPV Production Controller Route
//
Route::prefix('supervisor/production')->controller(Supervisor\SpvProductionController::class)->middleware(['verified'])->group(function(){
    Route::get('/','index')->name('spvproduction.index');
    Route::get('/showOnCheck','showOnCheck')->name('spvproduction.showOnCheck');
	Route::get('/{workorder}/show','show')->name('spvproduction.show');
    Route::get('/speedChart','speedChart')->name('spvproduction.speedChart');

    Route::post('/store','store')->name('spvproduction.store');
    Route::get('/{production}/edit','edit')->name('spvproduction.edit');
    Route::put('/{production}/update','update')->name('spvproduction.update');
    Route::delete('/{production}/delete','destroy')->name('spvproduction.delete');

	Route::post('/{workorder}/finish','finish')->name('spvproduction.finish');
});

Route::prefix('/supervisor/dowmtimereason')->controller(Supervisor\DowntimeReasonController::class)->middleware(['verified'])->group(function(){
    Route::get('/','index')->name('downtimeReason.index');
    Route::get('/create','create')->name('downtimeReason.create');
    Route::get('/show','show')->name('downtimeReason.show');
    Route::post('/store','store')->name('downtimeReason.store');
    Route::get('/{downtimeReason}/edit','edit')->name('downtimeReason.edit');
    Route::put('/{downtimeReason}/update','update')->name('downtimeReason.update');
    Route::delete('/{downtimeReason}/delete','destroy')->name('downtimeReason.delete');

    Route::get('/loadData','loadData')->name('downtimeReason.loadData');
    Route::get('/getReason','getReason')->name('downtimeReason.getReason');
});


//
// Help Controller Route
//
Route::middleware(['verified'])->controller(HelpController::class)->group(function(){
    route::get('/help','index')->name('help.index');
});

//
// Reset Password Controller
//
Route::middleware(['verified'])->controller(ChangePasswordController::class)->group(function(){
    Route::get('/change-password','index')->name('change.password.index');
    route::post('/change-password','store')->name('change.password');
});

//
// Warehouse Controller
//
Route::middleware(['verified'])->controller(WarehouseController::class)->group(function(){
    Route::get('/warehouse','index')->name('warehouse.index');
});

//
// Downtime Controller
//
Route::middleware(['verified'])->controller(DowntimeController::class)->group(function(){
    Route::post('/update-downtime','updateDataDowntime')->name('downtime.updateDowntime');
    Route::post('/getDowntimeWasteChart','getDowntimeWasteChart')->name('downtime.getDowntimeWasteChart');
    Route::post('/getDowntimeManagementChart','getDowntimeManagementChart')->name('downtime.getDowntimeManagementChart');
});

//
// Downtime Remarks Controller
//
Route::middleware(['verified'])->controller(DowntimeRemarkController::class)->group(function(){
    Route::post('/submit-downtime-remark','submitDowntimeRemark')->name('downtimeRemark.submit');
});





