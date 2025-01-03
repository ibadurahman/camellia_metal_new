<?php

namespace App\Http\Controllers\Operator;

use App\Models\User;
use App\Models\Color;
use App\Models\Downtime;
use App\Models\Smelting;
use App\Models\Workorder;
use App\Models\Production;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('operator.schedule.index', [
            'title'     => 'Workorder Schedule',
            'machines'  => Machine::all()
        ]);
    }


    public function showWaiting(Request $request)
    {
        $workorders = Workorder::where('status_wo', 'waiting')->orderBy('wo_order_num', 'asc')->limit(3);
        if ($request->machine != 0) {
            $workorders = Workorder::where('status_wo', 'waiting')->where('machine_id', $request->machine)->orderBy('wo_order_num', 'asc')->limit(3);
        }
        return datatables()->of($workorders)
            ->addColumn('bb_qty_combine', function (Workorder $model) {
                $combines = $model->bb_qty_pcs . " / " . $model->bb_qty_coil;
                return $combines;
            })
            ->addColumn('fg_size_combine', function (Workorder $model) {
                $combines = $model->fg_size_1 . " x " . $model->fg_size_2;
                return $combines;
            })
            ->addColumn('tolerance_combine', function (Workorder $model) {
                $combines = '(' . $model->tolerance_minus . ',' . (substr($model->tolerance_plus, 0, 1) !== '-' ? '+' : '') . $model->tolerance_plus . ')';
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
            ->addColumn('color', function (Workorder $model) {
                $color = Color::where('id', $model->color)->first();
                return $color->name;
            })
            ->addColumn('machine', function (Workorder $model) {
                return $model->machine->name;
            })
            ->addColumn('created_by', function (Workorder $model) {
                $user = User::where('id', $model->created_by)->first();
                return $user->name;
            })
            ->addColumn('created_at', function (Workorder $model) {
                return Date('Y-m-d H:i:s', strtotime($model->created_at));
            })
            ->addColumn('edited_by', function (Workorder $model) {
                $user = User::where('id', $model->edited_by)->first();
                if (!$user) {
                    return '';
                }
                return $user->name;
            })
            ->addColumn('updated_at', function (Workorder $model) {
                $user = User::where('id', $model->edited_by)->first();
                if (!$user) {
                    return '';
                }
                return $user->updated_at;
            })
            ->addColumn('smelting', 'user.smelting.smelting')
            ->addColumn('action', 'operator.schedule.action')
            ->rawColumns(['smelting', 'action'])
            ->setRowId(function (Workorder $model) {
                return $model->id;
            })
            ->addIndexColumn()
            ->toJson();
    }

    public function showOnProcess(Request $request)
    {
        $workorders = Workorder::where('status_wo', 'on process')->orderBy('wo_order_num', 'ASC')->limit(3);
        if ($request->machine != 0) {
            $workorders = Workorder::where('status_wo', 'on process')->where('machine_id', $request->machine)->orderBy('wo_order_num', 'ASC')->limit(3);
        }
        return datatables()->of($workorders)
            ->addColumn('bb_qty_combine', function (Workorder $model) {
                $combines = $model->bb_qty_pcs . " / " . $model->bb_qty_coil;
                return $combines;
            })
            ->addColumn('fg_size_combine', function (Workorder $model) {
                $combines = $model->fg_size_1 . " x " . $model->fg_size_2;
                return $combines;
            })
            ->addColumn('tolerance_combine', function (Workorder $model) {
                $combines = '(' . $model->tolerance_minus . ',' . (substr($model->tolerance_plus, 0, 1) !== '-' ? '+' : '') . $model->tolerance_plus . ')';
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
            ->addColumn('color', function (Workorder $model) {
                $color = Color::where('id', $model->color)->first();
                return $color->name;
            })
            ->addColumn('machine', function (Workorder $model) {
                return $model->machine->name;
            })
            ->addColumn('created_by', function (Workorder $model) {
                $user = User::where('id', $model->created_by)->first();
                return $user->name;
            })
            ->addColumn('created_at', function (Workorder $model) {
                return Date('Y-m-d H:i:s', strtotime($model->created_at));
            })
            ->addColumn('edited_by', function (Workorder $model) {
                if (!$model->edited_by) {
                    return '';
                }
                $user = User::where('id', $model->edited_by)->first();
                return $user->name;
            })
            ->addColumn('processed_by', function (Workorder $model) {
                $user = User::where('id', $model->processed_by)->first();
                return $user->name;
            })
            ->addColumn('process_start', function (Workorder $model) {
                return Date('Y-m-d H:i:s', strtotime($model->process_start));
            })
            ->addColumn('smelting', 'user.smelting.smelting')
            ->rawColumns(['smelting'])
            ->setRowId(function (Workorder $model) {
                return $model->id;
            })
            ->addIndexColumn()
            ->toJson();
    }

    public function process(Request $request, Workorder $id)
    {
        if ($id->machine->ip_address != $request->ip()) {
            return redirect(url('operator/schedule'));
        }

        $workorder = Workorder::where('machine_id', $id->machine_id)->where('status_wo', 'on process')->first();
        if ($workorder != null) {
            return redirect(route('schedule.index'));
        }

        $id->timestamps = false;
        $id->update([
            'status_wo' => 'on process',
            'wo_order_num' => null,
            'processed_by' => Auth::user()->id,
            'process_start' => date('Y-m-d H:i:s')
        ]);

        Downtime::create([
            'workorder_id'          => $id->id,
            'downtime_number'       => Date($id->machine_id . 'YmdHis'),
            'time'                  => 0,
            'status'                => 'stop',
            'downtime'              => 0,
            'is_downtime_stopped'   => false,
            'is_remark_filled'      => false,
        ]);

        return redirect(route('schedule.index'));
    }


    public function showOnCheck()
    {
        $workorders = Workorder::where('status_wo', 'on check')->orderBy('wo_order_num', 'ASC');
        return datatables()->of($workorders)
            ->addColumn('bb_qty_combine', function (Workorder $model) {
                $combines = $model->bb_qty_pcs . " / " . $model->bb_qty_coil;
                return $combines;
            })
            ->addColumn('fg_size_combine', function (Workorder $model) {
                $combines = $model->fg_size_1 . " x " . $model->fg_size_2;
                return $combines;
            })
            ->addColumn('tolerance', function (Workorder $model) {
                $combines = $model->tolerance_minus;
                return round($combines, 2);
            })
            ->addColumn('created_by', function (Workorder $model) {
                $user = User::where('id', $model->created_by)->first();
                return $user->name;
            })
            ->addColumn('created_date', function (Workorder $model) {
                return Date('Y-m-d H:i:s', strtotime($model->created_at));
            })
            ->addColumn('machine', function (Workorder $model) {
                return $model->machine->name;
            })
            ->addColumn('action', 'supervisor.production.action')
            ->setRowId(function (Workorder $model) {
                return $model->id;
            })
            ->addIndexColumn()
            ->toJson();
    }

    public function check(Workorder $id)
    {
        $workorder = Workorder::where('status_wo', 'on check')->first();
        if ($workorder != null) {
            return redirect(route('schedule.index'));
        }


        $smelting   = Smelting::where('workorder_id', $id->id)->get();
        $production = Production::where('workorder_id', $id->id)->get();
        $downtime   = Downtime::where('workorder_id', $id->id)->where('is_remark_filled', 0)->first();

        if (count($smelting) != count($production)) {
            return redirect(route('production.index'));
        }

        if ($downtime != null) {
            return redirect(route('production.index'));
        }

        $id->update(['status_wo' => 'on check', 'wo_order_num' => null]);

        return redirect(route('schedule.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
