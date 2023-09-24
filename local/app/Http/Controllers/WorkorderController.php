<?php

namespace App\Http\Controllers;

use App\Exports\WorkorderExport;
use DateTime;
use Svg\Tag\Rect;
use App\Models\Oee;
use App\Models\User;
use App\Models\Color;
use App\Models\Downtime;
use App\Models\Machine;
use App\Models\Realtime;
use App\Models\Smelting;
use App\Models\Workorder;
use App\Models\Production;
use Illuminate\Http\Request;
use App\Models\DowntimeRemark;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Round;

class WorkorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('user.workorder.index',[
            'title'     =>'Workorder',
            'machines'  => Machine::all()
        ]);
    }

    public function speedChart(Request $request)
    {
        //
        $data = json_decode(Realtime::select('speed','created_at')->where('workorder_id',$request->workorder)->orderBy('created_at','desc')->limit(20)->get());
        $response = [
            'speed'         => array_column($data,'speed'),
            'created_at'    => array_column($data,'created_at')
        ];
        for ($i=0; $i < count($response['created_at']); $i++) { 
            $response['created_at'][$i] = date('H:i:s',strtotime($response['created_at'][$i]));
        }
        return response()->json($response);
    }

    public function ajaxRequestAll(Request $request)
    {
        $workorder = Workorder::query()->orderBy('created_at','DESC');

        if ($request->machine_id != "0") {
            $workorder = $workorder->where('machine_id',$request->machine_id);
        }

        if($request->status != ''){
            $workorder = $workorder->where('status_wo',$request->status);
        }
        
        return datatables()->of($workorder)
                ->filter(function($query) use ($request){
                    if($request->report_date_1 != '')
                    {
                        $query->where('process_start', '>=', "$request->report_date_1");
                    }

                    if($request->report_date_2 != '')
                    {
                        $query->where('process_start', '<=', "$request->report_date_2");
                    }

                    if($request->wo_number != '')
                    {
                        $query->where('wo_number' , 'like', '%'.$request->wo_number.'%');
                    }
                })
                ->addColumn('wo_number',function(Workorder $model){
                    return $model->wo_number;
                })
                ->addColumn('machine',function(Workorder $model){
                    return $model->machine->name;
                })
                ->addColumn('total_production',function(Workorder $model){
                    $productions = Production::where('workorder_id',$model->id)->get();
                    $totalProd = 0;
                    foreach($productions as $prod){
                        $totalProd += $prod->pcs_per_bundle;
                    }
                    if($totalProd == 0){
                        return 'No Data';
                    }
                    return $totalProd;
                })
                ->addColumn('process_start',function(Workorder $model){
                    if($model->status_wo == 'waiting'){
                        return 'In queue';
                    }
                    if($model->status_wo == 'draft'){
                        return 'Draft';
                    }
                    return $model->process_start;
                })
                ->addColumn('process_end',function(Workorder $model){
                    if($model->status_wo == 'waiting'){
                        return 'In queue';
                    }
                    if($model->status_wo == 'draft'){
                        return 'Draft';
                    }
                    if($model->status_wo == 'on process'){
                        return 'Process running';
                    }
                    return $model->process_end;
                })
                ->addColumn('action','user.workorder.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->toJson();
    }

    public function getDowntime(Request $request)
    {
        $oee = Oee::where('workorder_id',$request->workorder_id)->first();
        if(!$oee){
            return response()->json(null,200);
        }
        if($request->data == 'downtime'){
            return response()->json([
                $oee->dt_bongkar_pasang_dies,
                $oee->dt_tunggu_bahan_baku,
                $oee->dt_ganti_bahan_baku,
                $oee->dt_tunggu_dies,
                $oee->dt_gosok_dies,
                $oee->dt_ganti_part_shot_blast,
                $oee->dt_setting_ulang_kelurusan,
                $oee->dt_ganti_polishing_dies,
                $oee->dt_ganti_nozle_polishing_mesin,
                $oee->dt_ganti_roller_straightener,
                $oee->dt_dies_rusak,
                $oee->dt_mesin_trouble_operator,
                $oee->dt_validasi_qc,
                $oee->dt_mesin_trouble_maintenance,
            ],200);
        }
        if($request->data == 'management_time'){
            return response()->json([
                $oee->dt_briefing,
                $oee->dt_cek_shot_blast,
                $oee->dt_cek_mesin,
                $oee->dt_sambung_bahan,
                $oee->dt_setting_awal,
                $oee->dt_selesai_satu_bundle,
                $oee->dt_cleaning_area_mesin,
                $oee->dt_istirahat
            ],200);
        }
        
        
    }

    public function getOee(Request $request)
    {

        $oee = Oee::where('workorder_id',$request->workorder_id)->first();
        $productions = Production::where('workorder_id',$request->workorder_id)->get();
        $totalProductions = 0;
        foreach($productions as $prod)
        {
            $totalProductions += $prod->pcs_per_bundle;
        }
        $totalProductions = 2000;
        $oeeResult = [0,0,0,0];
        if ($totalProductions > 0) {
            $oeeResult      = $this->calculateOee($oee->total_downtime, $oee->dt_istirahat, $oee->total_runtime, $totalProductions, 3);
        }
        
        $oee = Oee::where('workorder_id',$request->workorder_id)->first();
        return response()->json([
            $oeeResult[0],
            $oeeResult[1],
            $oeeResult[2],
            $oeeResult[3],
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Workorder $workorder)
    {
        //
        // Poductions
        //
        $productions    = Production::where('workorder_id',$workorder->id)->get();
        $productionCount = 0;
        foreach($productions as $prod)
        {
            $productionCount += $prod->pcs_per_bundle;
        }
        // dd($productions);

        //
        // Smeltings
        //
        $smeltings      = Smelting::where('workorder_id',$workorder->id)->orderBy('coil_num','ASC')->get();
        $smeltingInputList = [];
        foreach ($smeltings as $smelting) 
        {
            $productionCheck = Production::where('workorder_id',$workorder->id)->where('coil_num',$smelting->bundle_num)->first();
            if($productionCheck == null)
            {
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
        $downtimes = Downtime::where('workorder_id',$workorder->id)->where('status','stop')->get();
        $downtimeSummary = Downtime::where('status','stop')
                                ->where('workorder_id',$workorder->id)
                                ->get();
        foreach($downtimeSummary as $dt)
        {
            $downtimeRunId = Downtime::where('status','run')
                                ->where('downtime_number',$dt->downtime_number)
                                ->first();
            $downtimeStopId = Downtime::where('status','stop')
                                ->where('downtime_number',$dt->downtime_number)
                                ->first();
            $downtimeRemark = DowntimeRemark::where('downtime_id',$downtimeStopId->id)->first();

            if(!$downtimeRemark)
            {
                continue;
            }

            $duration = date_diff(new DateTime($downtimeStopId->created_at),new DateTime($downtimeRunId->created_at));

            $durationSec = $duration->days * 24 * 60 * 60;
            $durationSec += $duration->h * 60 * 60;
            $durationSec += $duration->i * 60;
            $durationSec += $duration->s;
                
            if($downtimeRemark->downtime_category == 'waste')
            {
                $wasteDowntime += $durationSec;
            }
            if($downtimeRemark->downtime_category == 'management')
            {
                $managementDowntime += $durationSec;
            }
            if($downtimeRemark->downtime_category == 'off')
            {
                $offProductionTime += $durationSec;
            }
            $totalDowntime += $durationSec;
            
        }
        $total_downtime = 0;
        $waste_downtime = 0;
        $management_downtime = 0;
        $off_production_time = 0;

        // Total Downtime Calculation
        if(($totalDowntime / 60) >=1)
        {
            $total_downtime_min = floor($totalDowntime/60);
            $total_downtime_sec = $totalDowntime - ($total_downtime_min * 60);
            $total_downtime = $total_downtime_min." Mins ".$total_downtime_sec." Secs";
        }
        else{
            $total_downtime = $totalDowntime." Secs";
        }

        if(($totalDowntime / 3600) >=1)
        {
            $total_downtime_hour = floor($totalDowntime/3600);
            $total_downtime_min = floor(($totalDowntime - ($total_downtime_hour * 60 * 60))/60);
            $total_downtime_sec = $totalDowntime - ($total_downtime_hour * 60 * 60) - ($total_downtime_min * 60);
            $total_downtime = $total_downtime_hour." Hours ".$total_downtime_min." Mins ".$total_downtime_sec." Secs";
        }
        if(($totalDowntime / 86400) >=1)
        {
            $total_downtime_days = floor($totalDowntime/86400);
            $total_downtime_hour = floor(($totalDowntime - ($total_downtime_days * 24 * 60 * 60))/3600);
            $total_downtime_min = floor(($totalDowntime - ($total_downtime_days * 24 * 60 * 60) - ($total_downtime_hour * 60 * 60))/60);
            $total_downtime_sec = $totalDowntime - ($total_downtime_days * 24 * 60 * 60) - ($total_downtime_hour * 60 * 60) - ($total_downtime_min * 60);
            $total_downtime = $total_downtime_days." Days ".$total_downtime_hour." Hours ".$total_downtime_min." Mins ".$total_downtime_sec." Secs";
        }
        
        

        // Waste Downtime Calculation
        $waste_downtime_min = 0;
        if(($wasteDowntime / 60) >=1)
        {
            $waste_downtime_min = floor($wasteDowntime/60);
            $waste_downtime_sec = $wasteDowntime - ($waste_downtime_min * 60);
            $waste_downtime = $waste_downtime_min." min ".$waste_downtime_sec." sec";
        }
        else{
            $waste_downtime = $wasteDowntime." sec";
        }
        if(($wasteDowntime / 3600) >=1)
        {
            $waste_downtime_hour = floor($wasteDowntime/3600);
            $waste_downtime_min = floor(($wasteDowntime - ($waste_downtime_hour * 60 * 60))/60);
            $waste_downtime_sec = $wasteDowntime - ($waste_downtime_hour * 60 * 60) - ($waste_downtime_min * 60);
            $waste_downtime = $waste_downtime_hour." Hours ".$waste_downtime_min." Mins ".$waste_downtime_sec." Secs";
        }
        if(($wasteDowntime / 86400) >=1)
        {
            $waste_downtime_days = floor($wasteDowntime/86400);
            $waste_downtime_hour = floor(($wasteDowntime - ($waste_downtime_days * 24 * 60 * 60))/3600);
            $waste_downtime_min = floor(($wasteDowntime - ($waste_downtime_days * 24 * 60 * 60) - ($waste_downtime_hour * 60 * 60))/60);
            $waste_downtime_sec = $wasteDowntime - ($waste_downtime_days * 24 * 60 * 60) - ($waste_downtime_hour * 60 * 60) - ($waste_downtime_min * 60);
            $waste_downtime = $waste_downtime_days." Days ".$waste_downtime_hour." Hours ".$waste_downtime_min." Mins ".$waste_downtime_sec." Secs";
        }

        // Management Downtime Calculation
        $management_downtime_min = 0;
        if(($managementDowntime / 60) >=1)
        {
            $management_downtime_min = floor($managementDowntime/60);
            $management_downtime_sec = $managementDowntime - ($management_downtime_min * 60);
            $management_downtime = $management_downtime_min." min ".$management_downtime_sec." sec";
        }
        else{
            $management_downtime = $managementDowntime." sec";
        }
        if(($managementDowntime / 3600) >=1)
        {
            $management_downtime_hour = floor($managementDowntime/3600);
            $management_downtime_min = floor(($managementDowntime - ($management_downtime_hour * 60 * 60))/60);
            $management_downtime_sec = $managementDowntime - ($management_downtime_hour * 60 * 60) - ($management_downtime_min * 60);
            $management_downtime = $management_downtime_hour." Hours ".$management_downtime_min." Mins ".$management_downtime_sec." Secs";
        }
        if(($managementDowntime / 86400) >=1)
        {
            $management_downtime_days = floor($managementDowntime/86400);
            $management_downtime_hour = floor(($managementDowntime - ($management_downtime_days * 24 * 60 * 60))/3600);
            $management_downtime_min = floor(($managementDowntime - ($management_downtime_days * 24 * 60 * 60) - ($management_downtime_hour * 60 * 60))/60);
            $management_downtime_sec = $managementDowntime - ($management_downtime_days * 24 * 60 * 60) - ($management_downtime_hour * 60 * 60) - ($management_downtime_min * 60);
            $management_downtime = $management_downtime_days." Days ".$management_downtime_hour." Hours ".$management_downtime_min." Mins ".$management_downtime_sec." Secs";
        }

        // OFf Production Calculation
        $off_production_time_min = 0;
        if(($offProductionTime / 60) >=1)
        {
            $off_production_time_min = floor($offProductionTime/60);
            $off_production_time_sec = $offProductionTime - ($off_production_time_min * 60);
            $off_production_time = $off_production_time_min." min ".$off_production_time_sec." sec";
        }
        else{
            $off_production_time = $offProductionTime." sec";
        }
        if(($offProductionTime / 3600) >=1)
        {
            $off_production_time_hour = floor($offProductionTime/3600);
            $off_production_time_min = floor(($offProductionTime - ($off_production_time_hour * 60 * 60))/60);
            $off_production_time_sec = $offProductionTime - ($off_production_time_hour * 60 * 60) - ($off_production_time_min * 60);
            $off_production_time = $off_production_time_hour." Hours ".$off_production_time_min." Mins ".$off_production_time_sec." Secs";
        }
        if(($offProductionTime / 86400) >=1)
        {
            $off_production_time_days = floor($offProductionTime/86400);
            $off_production_time_hour = floor(($offProductionTime - ($off_production_time_days * 24 * 60 * 60))/3600);
            $off_production_time_min = floor(($offProductionTime - ($off_production_time_days * 24 * 60 * 60) - ($off_production_time_hour * 60 * 60))/60);
            $off_production_time_sec = $offProductionTime - ($off_production_time_days * 24 * 60 * 60) - ($off_production_time_hour * 60 * 60) - ($off_production_time_min * 60);
            $off_production_time = $off_production_time_days." Days ".$off_production_time_hour." Hours ".$off_production_time_min." Mins ".$off_production_time_sec." Secs";
        }

        // Total Good Product Calculation
        $total_good_product = 0;
        $good_products = Production::select('pcs_per_bundle')->where('workorder_id',$workorder->id)->where('bundle_judgement',1)->get();  
        foreach($good_products as $good_pro)
        {
            $total_good_product += $good_pro->pcs_per_bundle;
        }

        // Total Bad Product Calculation
        $total_bad_product = 0;
        $bad_products = Production::select('pcs_per_bundle')->where('workorder_id',$workorder->id)->where('bundle_judgement',0)->get();  
        foreach($bad_products as $bad_pro)
        {
            $total_bad_product += $bad_pro->pcs_per_bundle;
        }

        // //
        // // Performance Calculation
        // //
        // $productionPlanned = round($workorder->bb_qty_pcs / $workorder->fg_size_1 / $workorder->fg_size_1 / $workorder->fg_size_2 / $this->calculatePcsPerBundle($workorder->fg_shape) *1000,0);
        // // dd($productionPlanned);
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
        if(is_null($workorder->process_end))
        {
            $plannedTime = date_diff(new DateTime($workorder->process_start),new DateTime(now()));
            // $plannedTime = $workorder->process_start->date_diff(strtotime(date('Y-m-d H:i:s')));
        }else{
            $plannedTime = date_diff(new DateTime($workorder->process_start),new DateTime($workorder->process_end));
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

        $fixedPlannedTime .= $plannedTime->i . ' Minutes ' ;

        $otr = 0;
        if (floor($wasteDowntime/60) == 0) {
            $otr = 100;
        }
        else{
            $otr = ((($plannedTimeMinutes-($managementDowntime/60)-($offProductionTime/60)) - (floor($wasteDowntime/60))) / ($plannedTimeMinutes-($managementDowntime/60)-($offProductionTime/60)))*100;
        }

        //
        // Quality Calculation
        //

        $qr = 0;
        if ($productionCount == 0) {
            $qr = 100;
        }else if($total_good_product == 0){
            $qr = 0;
        }else{
            $qr = (($total_good_product - $total_bad_product) / $total_good_product)*100;
        }


        //
        // Machine Average Speed
        //
        $realtimeQuery = Realtime::select('speed')->where('workorder_id',$workorder->id)->where('speed','>=','20');
        if($realtimeQuery->count() != 0){
            $machineAvgSpeed = $realtimeQuery->sum('speed') / $realtimeQuery->count();
        }else{
            $machineAvgSpeed = 30;
        }

        //
        // Cycle Time Calculation
        //
        if ($machineAvgSpeed != 0) {
            $cycleTime = ($workorder->fg_size_2*60/$machineAvgSpeed)/1000;
        }else{
            $cycleTime = 0;
        }

        //
        // Performance Calculation
        //
        $productionPlanned = round($workorder->bb_qty_pcs / $workorder->fg_size_1 / $workorder->fg_size_1 / $workorder->fg_size_2 / $this->calculatePcsPerBundle($workorder->fg_shape) *1000,0);
        $per = 0;
        // $productionPlanned = ($workorder->fg_qty_pcs * $workorder->bb_qty_bundle);
        if ($productionCount == 0) {
            $per = 100;
        }else{
            $per = ($total_good_product/((($plannedTimeMinutes-($managementDowntime/60)-($offProductionTime/60))-($wasteDowntime/60))*60/$cycleTime))*100;
        }
        // dd($offProductionTime);
        //
        // OEE
        //

        $oee = 0;
        $oee = (($per/100) * ($otr/100) * ($qr/100))*100;
        if($oee > 100){
            $oee = 100;
        }

        //
        // Created By
        //
        $createdBy = User::where('id',$workorder->created_by)->first();
        if(!$createdBy)
        {
            $createdBy = '';
        }
        else{
            $createdBy = $createdBy->name;
        }

        //
        // Edited By
        //
        $editedBy = User::where('id',$workorder->edited_by)->first();
        if(!$editedBy)
        {
            $editedBy = '';
        }
        else{
            $editedBy = $editedBy->name;
        }

        //
        // Processed By
        //
        $processedBy = User::where('id',$workorder->processed_by)->first();
        if(!$processedBy)
        {
            $processedBy = '';
        }
        else{
            $processedBy = $processedBy->name;
        }

		return view('user.workorder.details',[
            'title'                 => 'Production Report',
            'workorder'             => $workorder,
            'color'                 => Color::where('id',$workorder->color)->first()->name,
            'user_involved'         => [
                'created_by'        => $createdBy,
                'edited_by'         => $editedBy,
                'processed_by'      => $processedBy,
            ],
            'smeltings'             => $smeltings,
            'productions'           => $productions,
            'reports'               => [
                'production_plan'   => $productionPlanned,
                'production_count'  => $productionCount." Pcs",
			    'total_good_product'=> $total_good_product." Pcs",
                'total_bad_product' => $total_bad_product." Pcs",
                'planned_time'      => $fixedPlannedTime,
                'total_downtime'    => $total_downtime,
                'waste_downtime'    => $waste_downtime,
                'management_downtime'   => $management_downtime,
                'off_production_time'   => $off_production_time,
                'average_speed'         => $machineAvgSpeed
            ],
            'indicator'             => [
                'performance'   => round($per,1),
                'availability'  => round($otr,1),
                'quality'       => round($qr,1),
                'oee'           => round($oee,1),
            ],
            'smeltingInputList'     => $smeltingInputList,
            // 'oee'                   => $oee,
             'downtimes'            => $downtimes,
        ]);
    }

    private function calculateOee(int $downtime, int $dt_istirahat, int $runtime, int $qtyProduction, int $cycleTime, int $defect = 0)
    {
        $otr    = round((($runtime - ($downtime-$dt_istirahat)) / $runtime) * 100,2);
        $per    = round(($qtyProduction/(($runtime-($downtime-$dt_istirahat))*60/$cycleTime))*100,2);
        $qr     = round((($qtyProduction - $defect)/$qtyProduction)*100,2);
        $oeeVal = round((($otr/100) * ($per/100) * ($qr/100))*100,2);
        $result = [
            $oeeVal, $otr, $per, $qr
        ];

        return $result;
    }

    public function calculatePcsPerBundle($shape)
    {
        if($shape == "Round"){
            return 0.0061654;
        }
        elseif($shape == "Hexagon")
        {
            return 0.006798;
        }
        elseif($shape == "Square")
        {
            return 0.00785;
        }
        else{
            return 0;
        }
    }

    

}
