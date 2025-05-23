<?php

use App\Models\Workorder;
use App\Models\Production;
use App\Models\DowntimeReason;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Daily Report
Breadcrumbs::for('dailyReport.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Daily Report', route('dailyReport.index'));
});

// Workorder
Breadcrumbs::for('workorder.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Workorder', route('workorder.index'));
});

// OEE Details
Breadcrumbs::for('workorder.show', function ($trail, $workorder) {
    $trail->push('Home', route('home'));
    $trail->push('Workorder', route('workorder.index'));
    $trail->push('Workorder Detail', route('workorder.show', $workorder));
});

// User Index
Breadcrumbs::for('admin.user.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('User', route('admin.user.index'));
});
// User Index
Breadcrumbs::for('admin.user.inactivated', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('User', route('admin.user.inactivated'));
});

// User Create
Breadcrumbs::for('admin.user.create', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('User', route('admin.user.index'));
    $trail->push('Create User', route('admin.user.create'));
});

// User Edit
Breadcrumbs::for('admin.user.edit', function ($trail, $user) {
    $trail->push('Home', route('home'));
    $trail->push('User', route('admin.user.index'));
    $trail->push('Edit User', route('admin.user.edit', $user));
});

// Product Index
Breadcrumbs::for('admin.product.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Product', route('admin.product.index'));
});

// Workorder Index
Breadcrumbs::for('admin.workorder.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Workorder', route('admin.workorder.index'));
});
Breadcrumbs::for('admin.workorder.changeRequest', function ($trail, Workorder $workorder) {
    $trail->parent('admin.workorder.index');
    $trail->push('Workorder', route('admin.workorder.changeRequest', $workorder));
});

// Workorder Create
Breadcrumbs::for('admin.workorder.create', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Workorder', route('admin.workorder.index'));
    $trail->push('Create Workorder', route('admin.workorder.create'));
});

// Workorder Edit
Breadcrumbs::for('admin.workorder.edit', function ($trail, $workorder) {
    $trail->push('Home', route('home'));
    $trail->push('Workorder', route('admin.workorder.index'));
    $trail->push('Edit Workorder', route('admin.workorder.edit', $workorder));
});

// Workorder Closed
Breadcrumbs::for('admin.workorder.closed', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Closed Workorder', route('admin.workorder.closed'));
});

// Production Index
Breadcrumbs::for('admin.production.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Production', route('admin.production.index'));
});



// Smelting Create
Breadcrumbs::for('admin.smelting.create', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Workorder', route('admin.workorder.index'));
    $trail->push('Create Smelting', route('admin.smelting.create'));
});
Breadcrumbs::for('admin.smelting.leburanChangeRequest', function ($trail, Workorder $workorder) {
    $trail->push('Workorder', route('admin.workorder.index'));
    $trail->push('Leburan', route('admin.smelting.leburanChangeRequest', $workorder));
});

// OEE Index
Breadcrumbs::for('admin.oee.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('OEE', route('admin.oee.index'));
});

// Supplier Index
Breadcrumbs::for('admin.supplier.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Supplier', route('admin.supplier.index'));
});
// Supplier Inactivated
Breadcrumbs::for('admin.supplier.inactivated', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Supplier', route('admin.supplier.inactivated'));
});
// Supplier Create
Breadcrumbs::for('admin.supplier.create', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Supplier', route('admin.supplier.index'));
    $trail->push('Create Supplier', route('admin.supplier.create'));
});
// Supplier Edit
Breadcrumbs::for('admin.supplier.edit', function ($trail, $supplier) {
    $trail->push('Home', route('home'));
    $trail->push('Supplier', route('admin.supplier.index'));
    $trail->push('Edit Supplier', route('admin.supplier.edit', $supplier));
});

// Line Index
Breadcrumbs::for('admin.line.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Line', route('admin.line.index'));
});

// Line Create
Breadcrumbs::for('admin.line.create', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Line', route('admin.line.index'));
    $trail->push('Create Line', route('admin.line.create'));
});

// Line Edit
Breadcrumbs::for('admin.line.edit', function ($trail, $line) {
    $trail->push('Home', route('home'));
    $trail->push('Supplier', route('admin.line.index'));
    $trail->push('Edit Line', route('admin.line.edit', $line));
});

// Machine Index
Breadcrumbs::for('admin.machine.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Machine', route('admin.machine.index'));
});

// Machine Create
Breadcrumbs::for('admin.machine.create', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Machine', route('admin.machine.index'));
    $trail->push('Create Machine', route('admin.machine.create'));
});

// Machine Edit
Breadcrumbs::for('admin.machine.edit', function ($trail, $machine) {
    $trail->push('Home', route('home'));
    $trail->push('Machine', route('admin.machine.index'));
    $trail->push('Edit Machine', route('admin.machine.edit', $machine));
});

// Customer Index
Breadcrumbs::for('admin.customer.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Customer', route('admin.customer.index'));
});

// Customer Inactivated
Breadcrumbs::for('admin.customer.inactivated', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Customer', route('admin.customer.inactivated'));
});

// Customer Create
Breadcrumbs::for('admin.customer.create', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Customer', route('admin.customer.index'));
    $trail->push('Create Customer', route('admin.customer.create'));
});

// Customer Edit
Breadcrumbs::for('admin.customer.edit', function ($trail, $customer) {
    $trail->push('Home', route('home'));
    $trail->push('Customer', route('admin.customer.index'));
    $trail->push('Edit Customer', route('admin.customer.edit', $customer));
});

// Operator Schedule
Breadcrumbs::for('schedule.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Schedule', route('schedule.index'));
});

// Operator Production
Breadcrumbs::for('production.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Production', route('production.index'));
});
Breadcrumbs::for('operator.production.show', function ($trail, Workorder $workorder) {
    $trail->push('Home', route('home'));
    $trail->push('Production', route('production.index'));
    $trail->push('Production Details', route('operator.production.show', $workorder));
});
Breadcrumbs::for('production.edit', function ($trail, Production $production) {
    $trail->push('Home', route('home'));
    $trail->push('Production', route('production.index'));
    $trail->push('Production Details', route('operator.production.show', $production->workorder_id));
    $trail->push('Edit Bundle Data', route('production.edit', $production));
});
Breadcrumbs::for('operator.production.editWo', function ($trail, Workorder $workorder) {
    $trail->push('Production Details', route('operator.production.show', $workorder->id));
    $trail->push('Edit Workorder Planning', route('operator.production.editWo', $workorder));
});
Breadcrumbs::for('operator.production.editSmelting', function ($trail, Workorder $workorder) {
    $trail->push('Production Details', route('operator.production.show', $workorder->id));
    $trail->push('Edit Leburan', route('operator.production.editSmelting', $workorder));
});

//Help Index
Breadcrumbs::for('help.index', function ($trail) {
    $trail->push('Home', route('help.index'));
});

// Admin Schedule
Breadcrumbs::for('admin.schedule.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Schedule', route('admin.production.index'));
});


// Dayoff Index
Breadcrumbs::for('admin.dayoff.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Dayoff', route('admin.dayoff.index'));
});

// Dayoff Create
Breadcrumbs::for('admin.dayoff.create', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Dayoff', route('admin.dayoff.index'));
    $trail->push('Create Dayoff', route('admin.dayoff.create'));
});

// Dayoff Edit
Breadcrumbs::for('admin.dayoff.edit', function ($trail, $dayoff) {
    $trail->push('Home', route('home'));
    $trail->push('Supplier', route('admin.dayoff.index'));
    $trail->push('Edit Dayoff', route('admin.dayoff.edit', $dayoff));
});

// Holiday Index
Breadcrumbs::for('admin.holiday.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Holiday', route('admin.holiday.index'));
});

// Holiday Create
Breadcrumbs::for('admin.holiday.create', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Holiday', route('admin.holiday.index'));
    $trail->push('Create Holiday', route('admin.holiday.create'));
});

// Holiday Edit
Breadcrumbs::for('admin.holiday.edit', function ($trail, $holiday) {
    $trail->push('Home', route('home'));
    $trail->push('Supplier', route('admin.holiday.index'));
    $trail->push('Edit Holiday', route('admin.holiday.edit', $holiday));
});

// Breaktime Index
Breadcrumbs::for('admin.breaktime.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Breaktime', route('admin.breaktime.index'));
});

// Breaktime Create
Breadcrumbs::for('admin.breaktime.create', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Breaktime', route('admin.breaktime.index'));
    $trail->push('Create Breaktime', route('admin.breaktime.create'));
});

// Breaktime Edit
Breadcrumbs::for('admin.breaktime.edit', function ($trail, $breaktime) {
    $trail->push('Home', route('home'));
    $trail->push('Supplier', route('admin.breaktime.index'));
    $trail->push('Edit Breaktime', route('admin.breaktime.edit', $breaktime));
});

// Color Index
Breadcrumbs::for('admin.color.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Color', route('admin.color.index'));
});

// Color Create
Breadcrumbs::for('admin.color.create', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Color', route('admin.color.index'));
    $trail->push('Create Color', route('admin.color.create'));
});

// Color Edit
Breadcrumbs::for('admin.color.edit', function ($trail, $color) {
    $trail->push('Home', route('home'));
    $trail->push('Color', route('admin.color.index'));
    $trail->push('Edit Color', route('admin.color.edit', $color));
});

// Spv Breadcrumb
Breadcrumbs::for('spvproduction.index', function ($trail) {
    $trail->push('Home', route('home'));
});
Breadcrumbs::for('spvproduction.showOnCheck', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('On Check List', route('spvproduction.index'));
});
Breadcrumbs::for('spvproduction.show', function ($trail, $workorder) {
    $trail->push('Home', route('home'));
    $trail->push('On Check List', route('spvproduction.index'));
    $trail->push('Supervisor Check', route('spvproduction.show', $workorder));
});
Breadcrumbs::for('spvproduction.edit', function ($trail, $workorder) {
    $trail->push('Home', route('home'));
    $trail->push('On Check List', route('spvproduction.index'));
    $trail->push('Supervisor Check', route('spvproduction.show', $workorder));
    $trail->push('Bundle Edit', route('spvproduction.edit', $workorder));
});

// Warehouse Breadcrumb
Breadcrumbs::for('warehouse.index', function ($trail) {
    $trail->push('Warehouse', route('home'));
});

// Bypass Breadcrumb
Breadcrumbs::for('bypass.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Bypass', route('bypass.index'));
});

// Downtime Reason
Breadcrumbs::for('downtimeReason.index', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Downtime Reason', route('downtimeReason.index'));
});
Breadcrumbs::for('downtimeReason.create', function ($trail) {
    $trail->parent('downtimeReason.index');
    $trail->push('Create Downtime Reason', route('downtimeReason.create'));
});
Breadcrumbs::for('downtimeReason.edit', function ($trail, DowntimeReason $downtimeReason) {
    $trail->parent('downtimeReason.index');
    $trail->push('Edit Downtime Reason', route('downtimeReason.edit', $downtimeReason));
});
