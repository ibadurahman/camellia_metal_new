<?php

namespace App\Http\Controllers\operator;

use DateTime;
use App\Models\Oee;
use App\Models\User;
use App\Models\Color;
use App\Models\Machine;
use App\Models\Downtime;
use App\Models\Realtime;
use App\Models\Smelting;
use App\Models\Workorder;
use App\Models\Production;
use Illuminate\Http\Request;
use App\Models\DowntimeRemark;
use App\Http\Requests\OeeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use App\Http\Requests\ProductionRequest;
use App\Http\Resources\Downtime\DowntimeCollection;
use App\Models\BypassWorkorder;

class ProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('operator.production.index', [
            'title' => 'Operator Index',
            'machines' => Machine::all(),
        ]);
    }

    public function speedChart(Request $request)
    {
        //
        $data = json_decode(Realtime::select('speed', 'created_at')->where('workorder_id', $request->workorder)->orderBy('created_at', 'desc')->get());
        $response = [
            'speed'         => array_column($data, 'speed'),
            'created_at'    => array_column($data, 'created_at')
        ];
        for ($i = 0; $i < count($response['created_at']); $i++) {
            $response['created_at'][$i] = date('H:i:s', strtotime($response['created_at'][$i]));
        }
        return response()->json($response);
    }

    public function finish(Request $request, Workorder $workorder)
    {
        $production = Production::where('workorder_id', $workorder->id)->get();
        if ($workorder->bb_qty_bundle != count($production)) {
            return redirect(route('operator.production.show', $workorder));
        }

        $downtime = Downtime::where('workorder_id', $workorder->id)->get();
        if (count($downtime) > 0) {
            Downtime::where('workorder_id', $workorder->id)->where('is_downtime_stopped', false)->delete();

            Downtime::where('workorder_id', $workorder->id)->where('status','run')->where('is_downtime_stopped', true)->where('is_remark_filled', false)->delete();

            $downtimeDataUncomplete = Downtime::where('workorder_id', $workorder->id)->where(function ($query) {
                $query->where('is_remark_filled', false)->orWhere('is_downtime_stopped', false);
            })->first();
            if (!is_null($downtimeDataUncomplete)) {
                return redirect(route('operator.production.show', $workorder));
            }
        }

        $workorder->timestamps = false;
        $workorder->timestamps = false;
        $workorder->update([
            'production_remarks'    => $request->production_remarks,
            'status_wo'             => 'on check',
            'process_end'           => date('Y-m-d H:i:s'),
        ]);

        $bypassWorkorderCheck = BypassWorkorder::where('workorder_id', $workorder->id)->where('approved_by',null)->first();
        if ($bypassWorkorderCheck) {
            $bypassWorkorderCheck->delete();
        }

        return redirect(route('production.index'));
    }

    //OnProcess Data Controller
    public function showOnProcess(Request $request)
    {
        $workorders = Workorder::where('status_wo', 'on process')->orderBy('wo_order_num', 'ASC');
        if ($request->machine != 0) {
            $workorders = Workorder::where('status_wo', 'on process')->where('machine_id', $request->machine)->orderBy('wo_order_num', 'ASC');
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
                $combines = '(' . $model->tolerance_minus . ','.(substr($model->tolerance_plus,0,1)!=='-'?'+':''). $model->tolerance_plus . ')';
                return $combines;
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
                return Date('Y-m-d H:i:s', strtotime($user->updated_at));
            })
            ->addColumn('processed_by', function (Workorder $model) {
                $user = User::where('id', $model->processed_by)->first();
                return $user->name;
            })
            ->addColumn('process_start', function (Workorder $model) {
                return Date('Y-m-d H:i:s', strtotime($model->process_start));
            })
            ->addColumn('action', 'operator.production.action')
            ->setRowId(function (Workorder $model) {
                return $model->id;
            })
            ->addColumn('smelting', 'user.smelting.smelting')
            ->rawColumns(['smelting', 'action'])
            ->addIndexColumn()
            ->toJson();
    }

    public function getSmeltingNum(Request $request)
    {
        $workorder = Workorder::where('id', $request->workorder_id)->first();
        $smelting   = Smelting::where('workorder_id', $workorder->id)->where('bundle_num', $request->bundle_num)->first();
        return response()->json([
            $smelting->smelting_num
        ]);
    }

    public function getProductionInfo(Request $request)
    {
        $production = Production::where('workorder_id', $request->workorder_id)
            ->where('bundle_num', $request->bundle_num)->first();
        if (!$production) {
            return response()->json('Data not found', 404);
        }

        $result = [
            'id'                    => $production->id,
            'workorder_id'          => $production->workorder_id,
            'dies_num'              => $production->dies_num,
            'bundle_num'            => $production->bundle_num,
            'coil_num'              => Smelting::where('id', $production->coil_num)->first()->coil_num,
            'coil_weight'           => Smelting::where('id', $production->coil_num)->first()->weight,
            'coil_smelting_num'     => Smelting::where('id', $production->coil_num)->first()->smelting_num,
            'coil_area'             => Smelting::where('id', $production->coil_num)->first()->area,
            'diameter_ujung'        => $production->diameter_ujung,
            'diameter_tengah'       => $production->diameter_tengah,
            'diameter_ekor'         => $production->diameter_ekor,
            'kelurusan_aktual'      => $production->kelurusan_aktual,
            'panjang_aktual'        => $production->panjang_aktual,
            'berat_fg'              => $production->berat_fg,
            'pcs_per_bundle'        => $production->pcs_per_bundle,
            'bundle_judgement'      => $production->bundle_judgement,
            'visual'                => $production->visual,
            'created_by'            => $production->created_by,
            'edited_by'             => $production->edited_by,
            'created_at'            => $production->created_at,
            'updated_at'            => $production->updated_at
        ];

        $result['created_by'] = User::where('id', $production->created_by)->first()->name;
        $result['created_at'] = $production->created_at->format('Y-m-d H:i:s');

        if (!$result['edited_by']) {
            $result['edited_by'] = '';
            $result['updated_at'] = '';
            return response()->json($result, 200);
        }

        $result['edited_by'] = User::where('id', $production->edited_by)->first()->name;
        $result['updated_at'] = Date('Y-m-d H:i:s', strtotime($production->updated_at));
        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductionRequest $request)
    {
        //
        $workorder = Workorder::where('id', $request->workorder_id)->first();
        if (!$workorder) {
            return response()->json([
                'message' => 'Workorder Not Found'
            ], 400);
        }
        $production = Production::where('workorder_id', $request->workorder_id)->where('bundle_num', $request->bundle_num)->get();
        if (count($production) != 0) {
            return response()->json([
                'message' => 'Data Already Input'
            ], 400);
        }

        Production::create([
            'workorder_id'      => $request->workorder_id,
            'bundle_num'        => $request->bundle_num,
            'coil_num'          => $request->coil_num,
            'dies_num'          => $request->dies_num,
            'diameter_ujung'    => $request->diameter_ujung,
            'diameter_tengah'   => $request->diameter_tengah,
            'diameter_ekor'     => $request->diameter_ekor,
            'kelurusan_aktual'  => $request->kelurusan_aktual,
            'panjang_aktual'    => $request->panjang_aktual,
            'berat_fg'          => $request->berat_fg,
            'pcs_per_bundle'    => $request->pcs_per_bundle,
            'bundle_judgement'  => $request->bundle_judgement,
            'visual'            => $request->visual,
            'created_by'        => Auth::user()->id,
        ]);

        return response()->json([
            'message' => 'Submitted Successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Workorder $workorder)
    {
        if ($workorder->machine->ip_address != $request->ip() && !auth()->user()->hasRole(['supervisor', 'super-admin', 'owner'])) {
            return redirect(url('operator/production'));
        }
        //
        // Check Workorder is on process
        //
        if ($workorder->status_wo != 'on process') {
            return redirect(route('production.index'));
        }

        //
        // Poductions
        //
        $productions    = Production::where('workorder_id', $workorder->id)->get();
        $productionCount = 0;
        foreach ($productions as $prod) {
            $productionCount += $prod->pcs_per_bundle;
        }

        //
        // Smeltings
        //
        $smeltings      = Smelting::where('workorder_id', $workorder->id)->orderBy('coil_num', 'ASC')->get();
        $smeltingInputList = [];
        foreach ($smeltings as $smelting) {
            $productionCheck = Production::where('workorder_id', $workorder->id)->where('coil_num', $smelting->bundle_num)->first();
            if ($productionCheck == null) {
                $smeltingInputList[] = $smelting->coil_num;
            }
        }

        //
        // Downtimes
        //
        $totalDowntime = 0;
        $wasteDowntime = 0;
        $managementDowntime = 0;
        $offProductionTime = 0;
        $downtimes = Downtime::where('workorder_id', $workorder->id)->where('status', 'stop')->get();
        $downtimeSummary = Downtime::where('status', 'stop')
            ->where('workorder_id', $workorder->id)
            ->get();
        foreach ($downtimeSummary as $dt) {
            $downtimeRunId = Downtime::where('status', 'run')
                ->where('downtime_number', $dt->downtime_number)
                ->first();
            $downtimeStopId = Downtime::where('status', 'stop')
                ->where('downtime_number', $dt->downtime_number)
                ->first();
            $downtimeRemark = DowntimeRemark::where('downtime_id', $downtimeStopId->id)->first();

            if (!$downtimeRemark) {
                continue;
            }

            $duration = date_diff(new DateTime($downtimeStopId->created_at), new DateTime($downtimeRunId->created_at));

            $durationSec = $duration->days * 24 * 60 * 60;
            $durationSec += $duration->h * 60 * 60;
            $durationSec += $duration->i * 60;
            $durationSec += $duration->s;

            if ($downtimeRemark->downtime_category == 'waste') {
                $wasteDowntime += $durationSec;
            }
            if ($downtimeRemark->downtime_category == 'management') {
                $managementDowntime += $durationSec;
            }
            if ($downtimeRemark->downtime_category == 'off') {
                $offProductionTime += $durationSec;
            }
            $totalDowntime += $durationSec;
        }

        $total_downtime = 0;
        $waste_downtime = 0;
        $management_downtime = 0;
        $off_production_time = 0;

        // Total Downtime Calculation
        if (($totalDowntime / 60) >= 1) {
            $total_downtime_min = floor($totalDowntime / 60);
            $total_downtime_sec = $totalDowntime - ($total_downtime_min * 60);
            $total_downtime = $total_downtime_min . " Mins " . $total_downtime_sec . " Secs";
        } else {
            $total_downtime = $totalDowntime . " Secs";
        }

        if (($totalDowntime / 3600) >= 1) {
            $total_downtime_hour = floor($totalDowntime / 3600);
            $total_downtime_min = floor(($totalDowntime - ($total_downtime_hour * 60 * 60)) / 60);
            $total_downtime_sec = $totalDowntime - ($total_downtime_hour * 60 * 60) - ($total_downtime_min * 60);
            $total_downtime = $total_downtime_hour . " Hours " . $total_downtime_min . " Mins " . $total_downtime_sec . " Secs";
        }
        if (($totalDowntime / 86400) >= 1) {
            $total_downtime_days = floor($totalDowntime / 86400);
            $total_downtime_hour = floor(($totalDowntime - ($total_downtime_days * 24 * 60 * 60)) / 3600);
            $total_downtime_min = floor(($totalDowntime - ($total_downtime_days * 24 * 60 * 60) - ($total_downtime_hour * 60 * 60)) / 60);
            $total_downtime_sec = $totalDowntime - ($total_downtime_days * 24 * 60 * 60) - ($total_downtime_hour * 60 * 60) - ($total_downtime_min * 60);
            $total_downtime = $total_downtime_days . " Days " . $total_downtime_hour . " Hours " . $total_downtime_min . " Mins " . $total_downtime_sec . " Secs";
        }

        // Waste Downtime Calculation
        $waste_downtime_min = 0;
        if (($wasteDowntime / 60) >= 1) {
            $waste_downtime_min = floor($wasteDowntime / 60);
            $waste_downtime_sec = $wasteDowntime - ($waste_downtime_min * 60);
            $waste_downtime = $waste_downtime_min . " min " . $waste_downtime_sec . " sec";
        } else {
            $waste_downtime = $wasteDowntime . " sec";
        }
        if (($wasteDowntime / 3600) >= 1) {
            $waste_downtime_hour = floor($wasteDowntime / 3600);
            $waste_downtime_min = floor(($wasteDowntime - ($waste_downtime_hour * 60 * 60)) / 60);
            $waste_downtime_sec = $wasteDowntime - ($waste_downtime_hour * 60 * 60) - ($waste_downtime_min * 60);
            $waste_downtime = $waste_downtime_hour . " Hours " . $waste_downtime_min . " Mins " . $waste_downtime_sec . " Secs";
        }
        if (($wasteDowntime / 86400) >= 1) {
            $waste_downtime_days = floor($wasteDowntime / 86400);
            $waste_downtime_hour = floor(($wasteDowntime - ($waste_downtime_days * 24 * 60 * 60)) / 3600);
            $waste_downtime_min = floor(($wasteDowntime - ($waste_downtime_days * 24 * 60 * 60) - ($waste_downtime_hour * 60 * 60)) / 60);
            $waste_downtime_sec = $wasteDowntime - ($waste_downtime_days * 24 * 60 * 60) - ($waste_downtime_hour * 60 * 60) - ($waste_downtime_min * 60);
            $waste_downtime = $waste_downtime_days . " Days " . $waste_downtime_hour . " Hours " . $waste_downtime_min . " Mins " . $waste_downtime_sec . " Secs";
        }

        // Management Downtime Calculation
        $management_downtime_min = 0;
        if (($managementDowntime / 60) >= 1) {
            $management_downtime_min = floor($managementDowntime / 60);
            $management_downtime_sec = $managementDowntime - ($management_downtime_min * 60);
            $management_downtime = $management_downtime_min . " min " . $management_downtime_sec . " sec";
        } else {
            $management_downtime = $managementDowntime . " sec";
        }
        if (($managementDowntime / 3600) >= 1) {
            $management_downtime_hour = floor($managementDowntime / 3600);
            $management_downtime_min = floor(($managementDowntime - ($management_downtime_hour * 60 * 60)) / 60);
            $management_downtime_sec = $managementDowntime - ($management_downtime_hour * 60 * 60) - ($management_downtime_min * 60);
            $management_downtime = $management_downtime_hour . " Hours " . $management_downtime_min . " Mins " . $management_downtime_sec . " Secs";
        }
        if (($managementDowntime / 86400) >= 1) {
            $management_downtime_days = floor($managementDowntime / 86400);
            $management_downtime_hour = floor(($managementDowntime - ($management_downtime_days * 24 * 60 * 60)) / 3600);
            $management_downtime_min = floor(($managementDowntime - ($management_downtime_days * 24 * 60 * 60) - ($management_downtime_hour * 60 * 60)) / 60);
            $management_downtime_sec = $managementDowntime - ($management_downtime_days * 24 * 60 * 60) - ($management_downtime_hour * 60 * 60) - ($management_downtime_min * 60);
            $management_downtime = $management_downtime_days . " Days " . $management_downtime_hour . " Hours " . $management_downtime_min . " Mins " . $management_downtime_sec . " Secs";
        }

        // OFf Production Calculation
        $off_production_time_min = 0;
        if (($offProductionTime / 60) >= 1) {
            $off_production_time_min = floor($offProductionTime / 60);
            $off_production_time_sec = $offProductionTime - ($off_production_time_min * 60);
            $off_production_time = $off_production_time_min . " min " . $off_production_time_sec . " sec";
        } else {
            $off_production_time = $offProductionTime . " sec";
        }
        if (($offProductionTime / 3600) >= 1) {
            $off_production_time_hour = floor($offProductionTime / 3600);
            $off_production_time_min = floor(($offProductionTime - ($off_production_time_hour * 60 * 60)) / 60);
            $off_production_time_sec = $offProductionTime - ($off_production_time_hour * 60 * 60) - ($off_production_time_min * 60);
            $off_production_time = $off_production_time_hour . " Hours " . $off_production_time_min . " Mins " . $off_production_time_sec . " Secs";
        }
        if (($offProductionTime / 86400) >= 1) {
            $off_production_time_days = floor($offProductionTime / 86400);
            $off_production_time_hour = floor(($offProductionTime - ($off_production_time_days * 24 * 60 * 60)) / 3600);
            $off_production_time_min = floor(($offProductionTime - ($off_production_time_days * 24 * 60 * 60) - ($off_production_time_hour * 60 * 60)) / 60);
            $off_production_time_sec = $offProductionTime - ($off_production_time_days * 24 * 60 * 60) - ($off_production_time_hour * 60 * 60) - ($off_production_time_min * 60);
            $off_production_time = $off_production_time_days . " Days " . $off_production_time_hour . " Hours " . $off_production_time_min . " Mins " . $off_production_time_sec . " Secs";
        }

        // Total Good Product Calculation
        $total_good_product = 0;
        $good_products = Production::select('pcs_per_bundle')->where('workorder_id', $workorder->id)->where('bundle_judgement', 'good')->get();
        foreach ($good_products as $good_pro) {
            $total_good_product += $good_pro->pcs_per_bundle;
        }

        // Total Bad Product Calculation
        $total_bad_product = 0;
        $bad_products = Production::select('pcs_per_bundle')->where('workorder_id', $workorder->id)->where('bundle_judgement', 'notgood')->get();
        foreach ($bad_products as $bad_pro) {
            $total_bad_product += $bad_pro->pcs_per_bundle;
        }

        // //
        // // Performance Calculation
        // //
        // $productionPlanned = round($workorder->bb_qty_pcs / $workorder->fg_size_1 / $workorder->fg_size_1 / $workorder->fg_size_2 / $this->calculatePcsPerBundle($workorder->fg_shape) *1000,0);
        // $per = 0;
        // // $productionPlanned = ($workorder->fg_qty_pcs * $workorder->bb_qty_bundle);
        // if ($productionCount == 0) {
        //     $per = 100;
        // }else{
        //     $per = ($productionCount / $productionPlanned)*100;
        // }

        //
        // Availability Calculation
        //
        $plannedTime = 100;
        if (is_null($workorder->process_end)) {
            $plannedTime = date_diff(new DateTime($workorder->process_start), new DateTime(now()));
            // $plannedTime = $workorder->process_start->date_diff(strtotime(date('Y-m-d H:i:s')));
        } else {
            $plannedTime = date_diff(new DateTime($workorder->process_start), new DateTime($workorder->process_end));
        }
        $plannedTimeMinutes = $plannedTime->days * 24 * 60;
        $plannedTimeMinutes += $plannedTime->h * 60;
        $plannedTimeMinutes += $plannedTime->i;

        $fixedPlannedTime = '';
        if ($plannedTime->days > 0) {
            $fixedPlannedTime = $plannedTime->days . ' Days ';
        }
        if ($plannedTime->h > 0) {
            $fixedPlannedTime .= $plannedTime->h . ' Hours ';
        }

        $fixedPlannedTime .= $plannedTime->i . ' Minutes ';

        $otr = 0;
        if (floor($wasteDowntime / 60) == 0) {
            $otr = 100;
        } else {
            $otr = ((($plannedTimeMinutes - ($managementDowntime / 60) - ($offProductionTime / 60)) - (floor($wasteDowntime / 60))) / ($plannedTimeMinutes - ($managementDowntime / 60) - ($offProductionTime / 60))) * 100;
        }

        //
        // Quality Calculation
        //

        $qr = 0;
        if ($productionCount == 0) {
            $qr = 100;
        } else if ($total_good_product == 0) {
            $qr = 0;
        } else {
            $qr = (($total_good_product - $total_bad_product) / $total_good_product) * 100;
        }

        //
        // Machine Average Speed
        //
        $realtimeQuery = Realtime::select('speed')->where('workorder_id', $workorder->id)->where('speed','>=','10');
        if ($realtimeQuery->count() != 0) {
            $machineAvgSpeed = $realtimeQuery->sum('speed') / $realtimeQuery->count();
        } else {
            $machineAvgSpeed = 10;
        }

        //
        // Cycle Time Calculation
        //
        if ($machineAvgSpeed != 0) {
            $cycleTime = (($workorder->fg_size_2 * 60 / $machineAvgSpeed)) / 1000;
        } else {
            $cycleTime = 0;
        }

        //
        // Performance Calculation
        //
        $productionPlanned = round($workorder->bb_qty_pcs / $workorder->fg_size_1 / $workorder->fg_size_1 / $workorder->fg_size_2 / $this->calculatePcsPerBundle($workorder->fg_shape) * 1000, 0);
        $per = 0;
        // $productionPlanned = ($workorder->fg_qty_pcs * $workorder->bb_qty_bundle);
        if ($productionCount == 0 || $cycleTime == 0) {
            $per = 100;
        } else {
            $per = ($total_good_product / ((($plannedTimeMinutes - ($managementDowntime / 60) - ($offProductionTime / 60)) - ($wasteDowntime / 60)) * 60 / $cycleTime)) * 100;
        }

        //
        // OEE
        //

        $oee = 0;
        $oee = (($per / 100) * ($otr / 100) * ($qr / 100)) * 100;
        if ($oee > 100) {
            $oee = 100;
        }

        //
        // createdBy
        //
        $createdBy = User::where('id', $workorder->created_by)->first();
        if (!$createdBy) {
            $createdBy = '';
        } else {
            $createdBy = $createdBy->name;
        }

        //
        // editedBy
        //
        $editedBy = User::where('id', $workorder->edited_by)->first();
        if (!$editedBy) {
            $editedBy = '';
        } else {
            $editedBy = $editedBy->name;
        }

        //
        // processedBy
        //
        $processedBy = User::where('id', $workorder->processed_by)->first();
        if (!$processedBy) {
            $processedBy = '';
        } else {
            $processedBy = $processedBy->name;
        }

        return view('operator.production.show_detail', [
            'title'                 => 'Production Report',
            'workorder'             => $workorder,
            'color'                 => Color::where('id', $workorder->color)->first()->name,
            'user_involved'         => [
                'created_by'        => $createdBy,
                'edited_by'         => $editedBy,
                'processed_by'      => $processedBy,
            ],
            'smeltings'             => $smeltings,
            'productions'           => $productions,
            'reports'               => [
                'production_plan'   => $productionPlanned,
                'production_count'  => $productionCount . " Pcs",
                'total_good_product' => $total_good_product . " Pcs",
                'total_bad_product' => $total_bad_product . " Pcs",
                'planned_time'      => $fixedPlannedTime,
                'total_downtime'    => $total_downtime,
                'waste_downtime'    => $waste_downtime,
                'management_downtime'   => $management_downtime,
                'off_production_time'   => $off_production_time,
                'average_speed'   => $machineAvgSpeed,
            ],
            'indicator'             => [
                'performance'   => round($per, 1),
                'availability'  => round($otr, 1),
                'quality'       => round($qr, 1),
                'oee'           => round($oee, 1),
            ],
            'smeltingInputList'     => $smeltingInputList,
            // 'oee'                   => $oee,
            'downtimes'            => $downtimes,
            'bypass_workorder'    => BypassWorkorder::where('workorder_id', $workorder->id)->first(),
            'changeRequests'       => $workorder->changeRequests,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Production $production)
    {
        return view('operator.production.edit', [
            'production' => $production,
            'smeltings' => Smelting::where('workorder_id', $production->workorder_id)->get(),
            'title' => 'Operator: Edit Bundle Report'
        ]);
    }

    public function editSmelting(Workorder $workorder)
    {
        return view('operator.production.edit_smelting', [
            'title' => 'Operator: Edit Bundle Report',
            'workorder' => $workorder,
            'smeltings' => Smelting::where('workorder_id', $workorder->id)->get()
        ]);
    }

    public function updateSmelting(Request $request, Workorder $workorder){
        $smeltings = Smelting::where('workorder_id', $workorder->id)->get();
        foreach ($smeltings as $key => $smelt) {
            $smelt->weight = $request->weight[$key];
            $smelt->smelting_num = $request->smelting_num[$key];
            $smelt->area = $request->area[$key];
            $smelt->save();
        }

        return redirect()->route('operator.production.show', $workorder->id)->with('success', 'Data Updated Successfully');
    }

    public function editWo(Workorder $workorder)
    {
        return view('operator.production.edit_wo',[
            'title'         => 'Admin: edit Workorder',
            'workorder'     => $workorder,
        ]);
    }

    public function updateWo(Request $request, Workorder $workorder)
    {
        $request->validate([
            'bb_qty_pcs'    => 'required|numeric',
            'bb_qty_coil'   => 'required|numeric',
            'fg_qty_kg'     => 'required|numeric',
            'fg_qty_pcs'    => 'required|numeric',
        ]);

        $workorder->bb_qty_pcs = $request->bb_qty_pcs;
        $workorder->bb_qty_coil = $request->bb_qty_coil;
        $workorder->fg_qty_kg = $request->fg_qty_kg;
        $workorder->fg_qty_pcs = $request->fg_qty_pcs;
        $workorder->save();

        return redirect()->route('operator.production.show', $workorder->id)->with('success', 'Data Updated Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductionRequest $request, Production $production)
    {
        $workorder = Workorder::where('id', $request->workorder_id)->first();
        if (!$workorder) {
            return response()->json([
                'message' => 'Workorder Not Found'
            ], 400);
        }

        $production->update([
            'coil_num'          => $request->coil_num,
            'dies_num'          => $request->dies_num,
            'diameter_ujung'    => $request->diameter_ujung,
            'diameter_tengah'   => $request->diameter_tengah,
            'diameter_ekor'     => $request->diameter_ekor,
            'kelurusan_aktual'  => $request->kelurusan_aktual,
            'panjang_aktual'    => $request->panjang_aktual,
            'berat_fg'          => $request->berat_fg,
            'pcs_per_bundle'    => $request->pcs_per_bundle,
            'bundle_judgement'  => $request->bundle_judgement,
            'visual'            => $request->visual,
            'edited_by'         => Auth::user()->id,
        ]);

        return redirect()->route('operator.production.show', $production->workorder_id)->with('success', 'Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        //
        $production->delete();
        return redirect()->route('operator.production.show', $production->workorder_id)->with('success', 'Data Deleted Successfully');
    }

    public function calculatePcsPerBundle($shape)
    {
        if ($shape == "Round") {
            return 0.0061654;
        } elseif ($shape == "Hexagon") {
            return 0.006798;
        } elseif ($shape == "Square") {
            return 0.00785;
        } else {
            return 0;
        }
    }

    public function forceCloseInitiation(Request $request, Workorder $workorder)
    {
        try {
            $bypassWorkorder = new BypassWorkorder();
            $bypassWorkorder->workorder_id = $workorder->id;
            $bypassWorkorder->initiated_by = Auth::user()->id;
            $bypassWorkorder->remarks = $request->reason;
            $bypassWorkorder->save();
        } catch (\Throwable $th) {
            return response()->json([
                'success'       => false,
                'error_code'    => $th->getCode(),
                'error_message' => $th->getMessage(),
            ], 400);
        }
        return response()->json([
            'success'       => true,
            'message'       => 'Workorder Closed Successfully'
        ], 200);
    }

    public function forceCloseApproved(Request $request, Workorder $workorder)
    {
        try {

            $downtime = Downtime::where('workorder_id', $workorder->id)->get();
            if (count($downtime) > 0) {
                Downtime::where('workorder_id', $workorder->id)->where('is_downtime_stopped', false)->orWhere('is_remark_filled', false)->delete();
            }

            $productionData = Production::where('workorder_id', $workorder->id)->get();
            $smeltingData = Smelting::where('workorder_id', $workorder->id)->get();
            for ($i=count($productionData); $i < $workorder->bb_qty_bundle; $i++) { 
                $production = new Production();
                $production->workorder_id = $workorder->id;
                $production->bundle_num = $i+1;
                $production->coil_num = $smeltingData[0]->id;
                $production->dies_num = 0;
                $production->diameter_ujung = 0;
                $production->diameter_tengah = 0;
                $production->diameter_ekor = 0;
                $production->kelurusan_aktual = 0;
                $production->panjang_aktual = 0;
                $production->berat_fg = 0;
                $production->pcs_per_bundle = 0;
                $production->bundle_judgement = 'good';
                $production->visual = 'OK';
                $production->created_by = BypassWorkorder::where('workorder_id', $workorder->id)->first()->initiated_by;
                $production->save();
            }

            $bypassWorkorder = BypassWorkorder::where('workorder_id', $workorder->id)->first();
            $bypassWorkorder->approved_by = Auth::user()->id;
            $bypassWorkorder->save();

            $workorder->timestamps = false;
            $workorder->timestamps = false;
            $workorder->update([
                'production_remarks'    => $request->production_remarks,
                'status_wo'             => 'on check',
                'process_end'           => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success'       => false,
                'error_code'    => $th->getCode(),
                'error_message' => $th->getMessage(),
            ], 400);
        }
        return response()->json([
            'success'       => true,
            'message'       => 'Workorder Closed Successfully'
        ], 200);
    }
}
