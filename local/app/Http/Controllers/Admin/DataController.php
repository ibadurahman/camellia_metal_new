<?php

namespace App\Http\Controllers\Admin;

use App\Models\Oee;
use App\Models\Line;
use App\Models\User;
use App\Models\Color;
use App\Models\Dayoff;
use App\Models\Holiday;
use App\Models\Machine;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Schedule;
use App\Models\Smelting;
use App\Models\Supplier;
use App\Models\Breaktime;
use App\Models\Workorder;
use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    //User Data Controller
    public function users()
    {
        $users = User::where('id','!=','24')->where('id','!=','16')->where('is_active',true)->get();
        return datatables()->of($users)
                ->addColumn('role',function(User $model){
                    if($model->hasRole('office-admin'))
                    {
                        return 'office-admin';
                    }
                    if($model->hasRole('operator'))
                    {
                        return 'operator';
                    }
                    if($model->hasRole('super-admin'))
                    {
                        return 'super-admin';
                    }
                    if($model->hasRole('supervisor'))
                    {
                        return 'supervisor';
                    }
                    if($model->hasRole('warehouse'))
                    {
                        return 'warehouse';
                    }
                    return 'undefined';
                })
                ->addColumn('action','admin.user.action')
                ->addIndexColumn()
                ->toJson();
    }

    public function nonactiveUsers()
    {
        $users = User::where('id','!=','24')->where('id','!=','16')->where('is_active',false)->get();
        return datatables()->of($users)
                ->addColumn('role',function(User $model){
                    if($model->hasRole('office-admin'))
                    {
                        return 'office-admin';
                    }
                    if($model->hasRole('operator'))
                    {
                        return 'operator';
                    }
                    if($model->hasRole('super-admin'))
                    {
                        return 'super-admin';
                    }
                    if($model->hasRole('supervisor'))
                    {
                        return 'supervisor';
                    }
                    if($model->hasRole('warehouse'))
                    {
                        return 'warehouse';
                    }
                    return 'undefined';
                })
                ->addColumn('action','admin.user.nonactiveAction')
                ->addIndexColumn()
                ->toJson();
    }

    //Workorder Data Controller
    public function workordersDraft()
    {
        $workorders = Workorder::where('status_wo','draft')->orderBy('wo_order_num','ASC');
        return datatables()->of($workorders)
                ->addColumn('bb_qty_combine',function(Workorder $model){
                    $combines = $model->bb_qty_pcs . " / " . $model->bb_qty_coil;
                    return $combines;
                })
                ->addColumn('fg_size_combine',function(Workorder $model){
                    $combines = $model->fg_size_1 . " x " . $model->fg_size_2;
                    return $combines;
                })
                ->addColumn('tolerance_combine',function(Workorder $model){
                    $combines = '('.(substr($model->tolerance_plus,0,1)!=='-'?'+':'').$model->tolerance_plus.','.$model->tolerance_minus.')';
                    return $combines;
                })
                ->addColumn('length_tolerance_combine', function(Workorder $model) {
                    //check if length tolerance is a number
                    if (is_numeric($model->length_tolerance_plus) && is_numeric($model->length_tolerance_minus)) {
                        $combines = '('.$model->length_tolerance_plus.','.$model->length_tolerance_minus.')';
                        return $combines;
                    }else{
                        return '-';
                    }
                })
                ->addColumn('color',function(Workorder $model){
                    $color = Color::where('id',$model->color)->first();
                    return $color->name;
                })
                ->addColumn('machine',function(Workorder $model){
                    return $model->machine->name;
                })
                ->addColumn('created_by',function(Workorder $model){
                    $user = User::where('id',$model->created_by)->first();
                    return $user->name;
                })
                ->addColumn('created_at',function(Workorder $model){
                    return Date('Y-m-d H:i:s',strtotime($model->created_at));
                })
                ->addColumn('edited_by',function(Workorder $model){
                    $user = User::where('id',$model->edited_by)->first();
                    if(!$user)
                    {
                        return '';
                    }
                    return $user->name;
                })
                ->addColumn('updated_at',function(Workorder $model){
                    $user = User::where('id',$model->edited_by)->first();
                    if(!$user)
                    {
                        return '';
                    }
                    return Date('Y-m-d H:i:s',strtotime($model->updated_at));
                })
                ->addColumn('action','admin.workorder.action')
                ->addColumn('smelting','admin.workorder.smelting')
                ->rawColumns(['smelting','action'])
                ->setRowClass(function(){
                    return 'workorder-row';
                })
                ->setRowId(function(Workorder $model){
                    return $model->id;
                })
                ->setRowClass(function(Workorder $model){
                    if($model->status_wo == 'draft'){
                        return 'workorder-row alert-danger';
                    }
                    return 'workorder-row';
                })
                ->setRowAttr([
                    'data-toggle'       => 'tooltip',
                    'data-placement'    => 'top',
                    'title'             => function(Workorder $model){
                        if($model->status_wo == 'draft'){
                            return 'Smelting Number Must Be Input Correctly';
                        }
                        return 'Data OK';
                    }
                ])
                ->addIndexColumn()
                ->toJson();
    }

    //Workorder Data Controller
    public function workordersWaiting(Request $request)
    {
        $workorders = Workorder::where('status_wo','waiting')->orderBy('wo_order_num','ASC');
        if ($request->machine != 0) {
            $workorders = Workorder::where('status_wo','waiting')->where('machine_id',$request->machine)->orderBy('wo_order_num','asc');
        }
        return datatables()->of($workorders)
            ->addColumn('bb_qty_combine',function(Workorder $model){
                $combines = $model->bb_qty_pcs . " / " . $model->bb_qty_coil;
                return $combines;
            })
            ->addColumn('fg_size_combine',function(Workorder $model){
                $combines = $model->fg_size_1 . " x " . $model->fg_size_2;
                return $combines;
            })
            ->addColumn('tolerance_combine',function(Workorder $model){
                $combines = '('.(substr($model->tolerance_plus,0,1)!=='-'?'+':'').$model->tolerance_plus.','.$model->tolerance_minus.')';
                return $combines;
            })
            ->addColumn('length_tolerance_combine', function(Workorder $model) {
                //check if length tolerance is a number
                if (is_numeric($model->length_tolerance_plus) && is_numeric($model->length_tolerance_minus)) {
                    $combines = '('.$model->length_tolerance_plus.','.$model->length_tolerance_minus.')';
                    return $combines;
                }else{
                    return '-';
                }
            })
            ->addColumn('color',function(Workorder $model){
                $color = Color::where('id',$model->color)->first();
                return $color->name;
            })
            ->addColumn('machine',function(Workorder $model){
                return $model->machine->name;
            })
            ->addColumn('created_by',function(Workorder $model){
                $user = User::where('id',$model->created_by)->first();
                return $user->name;
            })
            ->addColumn('created_at',function(Workorder $model){
                return Date('Y-m-d H:i:s',strtotime($model->created_at));
            })
            ->addColumn('edited_by',function(Workorder $model){
                $user = User::where('id',$model->edited_by)->first();
                if(!$user)
                {
                    return '';
                }
                return $user->name;
            })
            ->addColumn('updated_at',function(Workorder $model){
                $user = User::where('id',$model->edited_by)->first();
                if(!$user)
                {
                    return '';
                }
                return  Date('Y-m-d H:i:s',strtotime($model->updated_at));
            })
            ->addColumn('action','admin.workorder.action')
            ->addColumn('smelting','admin.workorder.smelting')
            ->rawColumns(['smelting','action'])
            ->setRowClass(function(){
                return 'workorder-row';
            })
            ->setRowId(function(Workorder $model){
                return $model->id;
            })
            ->setRowClass(function(Workorder $model){
                if($model->status_wo == 'draft'){
                    return 'workorder-row alert-danger';
                }
                return 'workorder-row';
            })
            ->setRowAttr([
                'data-toggle'       => 'tooltip',
                'data-placement'    => 'top',
                'title'             => function(Workorder $model){
                    if($model->status_wo == 'draft'){
                        return 'Smelting Number Must Be Input Correctly';
                    }
                    return 'Data OK';
                }
            ])
            ->addIndexColumn()
            ->toJson();
    }

    //OnProcess Data Controller
    public function workordersOnProcess()
    {
        $workorders = Workorder::where('status_wo','on process')->orderBy('wo_order_num','ASC');
        return datatables()->of($workorders)
            ->addColumn('bb_qty_combine',function(Workorder $model){
                $combines = $model->bb_qty_pcs . " / " . $model->bb_qty_coil;
                return $combines;
            })
            ->addColumn('fg_size_combine',function(Workorder $model){
                $combines = $model->fg_size_1 . " x " . $model->fg_size_2;
                return $combines;
            })
            ->addColumn('tolerance_combine',function(Workorder $model){
                $combines = '('.(substr($model->tolerance_plus,0,1)!=='-'?'+':'').$model->tolerance_plus.','.$model->tolerance_minus.')';
                return $combines;
            })
            ->addColumn('length_tolerance_combine', function(Workorder $model) {
                //check if length tolerance is a number
                if (is_numeric($model->length_tolerance_plus) && is_numeric($model->length_tolerance_minus)) {
                    $combines = '('.$model->length_tolerance_plus.','.$model->length_tolerance_minus.')';
                    return $combines;
                }else{
                    return '-';
                }
            })
            ->addColumn('color',function(Workorder $model){
                $color = Color::where('id',$model->color)->first();
                return $color->name;
            })
            ->addColumn('machine',function(Workorder $model){
                return $model->machine->name;
            })
            ->addColumn('created_by',function(Workorder $model){
                $user = User::where('id',$model->created_by)->first();
                return $user->name;
            })
            ->addColumn('created_at',function(Workorder $model){
                return Date('Y-m-d H:i:s',strtotime($model->created_at));
            })
            ->addColumn('edited_by',function(Workorder $model){
                $user = User::where('id',$model->edited_by)->first();
                if(!$user)
                {
                    return '';
                }
                return $user->name;
            })
            ->addColumn('updated_at',function(Workorder $model){
                $user = User::where('id',$model->edited_by)->first();
                if(!$user)
                {
                    return '';
                }
                return  Date('Y-m-d H:i:s',strtotime($model->updated_at));
            })
            ->addColumn('processed_by',function(Workorder $model){
                $user = User::where('id',$model->processed_by)->first();
                return $user->name;
            })
            ->addColumn('process_start',function(Workorder $model){
                return Date('Y-m-d H:i:s',strtotime($model->process_start));
            })
            ->addColumn('smelting','admin.smelting.leburan_change')
            ->addColumn('action','admin.workorder.change_request')
            ->rawColumns(['smelting','action'])
            ->setRowId(function(Workorder $model){
                return $model->id;
            })
            ->addIndexColumn()
            ->toJson();
    }

    //OnProcess Data Controller
    public function workordersClosed()
    {
        $workorders = Workorder::where('status_wo','closed')->orderBy('wo_order_num','ASC');
        return datatables()->of($workorders)
            ->addColumn('bb_qty_combine',function(Workorder $model){
                $combines = $model->bb_qty_pcs . " / " . $model->bb_qty_coil;
                return $combines;
            })
            ->addColumn('fg_size_combine',function(Workorder $model){
                $combines = $model->fg_size_1 . " x " . $model->fg_size_2;
                return $combines;
            })
            ->addColumn('tolerance_combine',function(Workorder $model){
                $combines = '('.(substr($model->tolerance_plus,0,1)!=='-'?'+':'').$model->tolerance_plus.','.$model->tolerance_minus.')';
                return $combines;
            })
            ->addColumn('length_tolerance_combine', function(Workorder $model) {
                //check if length tolerance is a number
                if (is_numeric($model->length_tolerance_plus) && is_numeric($model->length_tolerance_minus)) {
                    $combines = '('.$model->length_tolerance_plus.','.$model->length_tolerance_minus.')';
                    return $combines;
                }else{
                    return '-';
                }
            })
            ->addColumn('color',function(Workorder $model){
                $color = Color::where('id',$model->color)->first();
                return $color->name;
            })
            ->addColumn('machine',function(Workorder $model){
                return $model->machine->name;
            })
            ->addColumn('created_by',function(Workorder $model){
                $user = User::where('id',$model->created_by)->first();
                return $user->name;
            })
            ->addColumn('created_at',function(Workorder $model){
                return Date('Y-m-d H:i:s',strtotime($model->created_at));
            })
            ->addColumn('edited_by',function(Workorder $model){
                $user = User::where('id',$model->edited_by)->first();
                if(!$user)
                {
                    return '';
                }
                return $user->name;
            })
            ->addColumn('updated_at',function(Workorder $model){
                $user = User::where('id',$model->edited_by)->first();
                if(!$user)
                {
                    return '';
                }
                return  Date('Y-m-d H:i:s',strtotime($model->updated_at));
            })
            ->addColumn('processed_by',function(Workorder $model){
                $user = User::where('id',$model->processed_by)->first();
                return $user->name;
            })
            ->addColumn('process_start',function(Workorder $model){
                return Date('Y-m-d H:i:s',strtotime($model->process_start));
            })
            ->addColumn('smelting','user.smelting.smelting')
            ->rawColumns(['smelting'])
            ->setRowId(function(Workorder $model){
                return $model->id;
            })
            ->addIndexColumn()
            ->toJson();
    }

    public function suppliers()
    {
        $suppliers = Supplier::where('is_active',true)->get();
        return datatables()->of($suppliers)
                ->addIndexColumn()
                ->addColumn('action','admin.supplier.action')
                ->toJson();
    }

    public function nonactiveSuppliers()
    {
        $suppliers = Supplier::where('is_active',false)->get();
        return datatables()->of($suppliers)
                ->addIndexColumn()
                ->addColumn('action','admin.supplier.nonactiveAction')
                ->toJson();
    }

    public function holidays()
    {
        $holidays = Holiday::query();
        return datatables()->of($holidays)
                ->addIndexColumn()
                ->addColumn('action','admin.holiday.action')
                ->toJson();
    }

    public function breaktimes()
    {
        $breaktimes = Breaktime::query();
        return datatables()->of($breaktimes)
                ->addIndexColumn()
                ->addColumn('action','admin.breaktime.action')
                ->toJson();
    }

    public function dayoffs()
    {
        $dayoffs = Dayoff::query();
        return datatables()->of($dayoffs)
                ->addIndexColumn()
                ->addColumn('action','admin.dayoff.action')
                ->toJson();
    }

    public function colors()
    {
        $colors = Color::query();
        return datatables()->of($colors)
                ->addIndexColumn()
                ->addColumn('action','admin.color.action')
                ->toJson();
    }

    public function lines()
    {
        $lines = Line::query();
        return datatables()->of($lines)
                ->addIndexColumn()
                ->addColumn('action','admin.line.action')
                ->toJson();
    }

    public function machines()
    {
        $machines = Machine::query();
        return datatables()->of($machines)
                ->addIndexColumn()
                ->addColumn('line',function(Machine $model){
                    return $model->line->name;
                })
                ->addColumn('action','admin.machine.action')
                ->toJson();
    }

    public function customers()
    {
        $customers = Customer::where('is_active',true)->get();
        return datatables()->of($customers)
                ->addIndexColumn()
                ->addColumn('size',function(Customer $model){
                    $combines = $model->size_1 . " x " . $model->size_2;
                    return $combines;
                })
                ->addColumn('action','admin.customer.action')
                ->toJson();
    }

    public function nonactiveCustomers()
    {
        $customers = Customer::where('is_active',false)->get();
        return datatables()->of($customers)
        ->addIndexColumn()
        ->addColumn('size',function(Customer $model){
            $combines = $model->size_1 . " x " . $model->size_2;
            return $combines;
        })
        ->addColumn('action','admin.customer.nonactiveAction')
        ->toJson();
    }

    // Leburan Data Controller
    public function wo_smeltings(Request $request)
    {
        $smeltings = Smelting::where('workorder_id',$request->wo_id)->orderby('coil_num','asc')->get();
        if(!$smeltings){
            return;
        }
        return $smeltings;
    }

    //Productions Data Controller
    public function productions()
    {
        $productions = Production::query();
        return datatables()->of($productions)
                ->addColumn('wo_number',function(Production $model){
                    return $model->workorder->wo_number;
                })
                ->addColumn('smelting_num',function(Production $model){
                    $smelting = Smelting::select('smelting_num')->where('workorder_id',$model->workorder_id)->where('bundle_num',$model->bundle_num)->first();
                    return $smelting['smelting_num'];
                })
                ->addIndexColumn()
                ->toJson();
    }

    //Smeltings Data Controller
    public function smeltings(Request $request)
    {
        $smeltings = Smelting::where('workorder_id',$request->wo_id)->orderBy('coil_num','asc')->get();
        return datatables()->of($smeltings)
                ->addColumn('wo_number',function(Smelting $model){
                    return $model->workorder->wo_number;
                })
                ->addColumn('action','admin.smelting.action')
                ->addIndexColumn()
                ->toJson();
    }
    //Smeltings Data Controller
    public function smeltingsChange(Request $request)
    {
        $smeltings = Smelting::where('workorder_id',$request->wo_id)->orderBy('coil_num','asc')->get();
        return datatables()->of($smeltings)
                ->addColumn('wo_number',function(Smelting $model){
                    return $model->workorder->wo_number;
                })
                ->addColumn('action','admin.smelting.actionChange')
                ->addIndexColumn()
                ->toJson();
    }

    //Oees Data Controller
    public function oees(Request $request)
    {
        $productions = Oee::query();
        return datatables()->of($productions)
                ->addColumn('wo_number',function(Oee $model){
                    return $model->workorder->wo_number;
                })
                ->addIndexColumn()
                ->toJson();
    }
}
