<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DataController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SmeltingController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WorkorderController;

Route::middleware(['verified'])->group(function(){
    Route::get('user/data',[DataController::class,'users'])->name('user.data');
    Route::get('nonactiveuser/data',[DataController::class,'nonactiveUsers'])->name('nonactiveuser.data');
    Route::get('workorder/datadraft',[DataController::class,'workordersDraft'])->name('workorder.datadraft');
    Route::get('workorder/datawaiting',[DataController::class,'workordersWaiting'])->name('workorder.datawaiting');
    Route::get('workorder/dataonprocess',[DataController::class,'workordersOnProcess'])->name('workorder.dataonprocess');
    Route::get('workorder/dataclosed',[DataController::class,'workordersClosed'])->name('workorder.dataclosed');
    Route::get('production/data',[DataController::class,'productions'])->name('production.data');
    Route::get('oee/data',[DataController::class,'oees'])->name('oee.data');
    Route::get('smelting/data_wo',[DataController::class,'wo_smeltings'])->name('smelting.data_wo');
    Route::get('smelting/data',[DataController::class,'smeltings'])->name('smelting.data');
    Route::get('smelting/dataChange',[DataController::class,'smeltingsChange'])->name('smelting.dataChange');
    Route::get('supplier/data',[DataController::class,'suppliers'])->name('supplier.data');
    Route::get('nonactivesupplier/data',[DataController::class,'nonactiveSuppliers'])->name('nonactivesupplier.data');
    Route::get('color/data',[DataController::class,'colors'])->name('color.data');
    Route::get('line/data',[DataController::class,'lines'])->name('line.data');
    Route::get('machine/data',[DataController::class,'machines'])->name('machine.data');
    Route::get('customer/data',[DataController::class,'customers'])->name('customer.data');
    Route::get('nonactivecustomer/data',[DataController::class,'nonactiveCustomers'])->name('nonactivecustomer.data');
});

Route::middleware(['verified'])->group(function(){
    Route::post('user/reset-password',[UserController::class,'resetPassword'])->name('user.reset.password');
    Route::delete('user/{user}/inactive',[UserController::class,'inactive'])->name('user.inactive');
    Route::post('user/{user}/activate',[UserController::class,'activate'])->name('user.activate');
    Route::get('user/inactivated',[UserController::class,'inactivated'])->name('user.inactivated');
    Route::resource('user','UserController');
});

Route::middleware(['verified'])->group(function(){
    Route::get('smelting/{workorder}/leburanChangeRequest',[SmeltingController::class,'leburanChangeRequest'])->name('smelting.leburanChangeRequest');
    Route::put('smelting/{workorder}/leburanChangeUpdate',[SmeltingController::class,'leburanChangeUpdate'])->name('smelting.leburanChangeUpdate');
    Route::post('smelting/getDataWoChange',[SmeltingController::class,'getDataWoChange'])->name('smelting.getDataWoChange');
    Route::post('smelting/addSmeltingChange',[SmeltingController::class,'addSmeltingChange'])->name('smelting.addSmeltingChange');
    Route::put('smelting/{smelting}/updateChange',[SmeltingController::class,'updateChange'])->name('smelting.updateChange');
    Route::delete('smelting/{smelting}/deleteChange',[SmeltingController::class,'destroyChange'])->name('smelting.deleteChange');

    Route::post('smelting/getDataWo',[SmeltingController::class,'getDataWo'])->name('smelting.getDataWo');
    Route::post('smelting/addSmelting',[SmeltingController::class,'addSmelting'])->name('smelting.addSmelting');
    Route::put('smelting/{smelting}',[SmeltingController::class,'update'])->name('smelting.update');
    Route::resource('smelting','SmeltingController');
});

Route::middleware(['verified'])->group(function(){
    Route::get('workorder/closed',[WorkorderController::class,'closedWorkorder'])->name('workorder.closed');
    Route::post('workorder/updateOrder',[WorkorderController::class,'updateOrder'])->name('workorder.updateorder');
    Route::post('workorder/setWoStatus',[WorkorderController::class,'setWoStatus'])->name('workorder.setWoStatus');
    Route::get('workorder/{workorder}/changeRequest',[WorkorderController::class,'changeRequest'])->name('workorder.changeRequest');
    Route::put('workorder/{workorder}/changeUpdate',[WorkorderController::class,'changeUpdate'])->name('workorder.changeUpdate');
    Route::post('workorder/calculatePcsPerBundle',[WorkorderController::class,'calculatePcsPerBundle'])->name('workorder.calculatePcsPerBundle');
    Route::post('/confirm-password',[WorkorderController::class,'confirmPassword'])->name('confirm.password');
    Route::resource('workorder','WorkorderController');
});

Route::middleware(['verified'])->resource('color',ColorController::class);

Route::middleware(['verified'])->resource('line',LineController::class);

Route::middleware(['verified'])->resource('machine',MachineController::class);

Route::middleware(['verified'])->group(function(){
    Route::get('schedule/data',[ScheduleController::class,'data'])->name('schedule.data');
    Route::resource('schedule','ScheduleController');
});

Route::middleware(['verified'])->group(function(){
    Route::post('suppllier/getSupplierData',[SupplierController::class,'getSupplierData'])->name('supplier.getSupplierData');
    Route::delete('supplier/{supplier}/inactive',[SupplierController::class,'inactive'])->name('supplier.inactive');
    Route::post('supplier/{supplier}/activate',[SupplierController::class,'activate'])->name('supplier.activate');
    Route::get('supplier/inactivated',[SupplierController::class,'inactivated'])->name('supplier.inactivated');
    Route::resource('supplier','SupplierController');
});

Route::middleware(['verified'])->group(function(){
    Route::post('customer/getCustomerData',[CustomerController::class,'getCustomerData'])->name('customer.getCustomerData');
    Route::delete('customer/{customer}/inactive',[CustomerController::class,'inactive'])->name('customer.inactive');
    Route::post('customer/{customer}/activate',[CustomerController::class,'activate'])->name('customer.activate');
    Route::get('customer/inactivated',[CustomerController::class,'inactivated'])->name('customer.inactivated');
    Route::resource('customer','CustomerController');
});

Route::middleware(['verified'])->group(function(){
    Route::post('color/getColorData',[ColorController::class,'getColorData'])->name('color.getColorData');
    Route::resource('color','ColorController');
});



