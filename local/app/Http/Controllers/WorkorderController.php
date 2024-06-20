<?php

namespace App\Http\Controllers;

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

use App\Helpers\OEECalculation;

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Workorder $workorder)
    {
        $oeeCalculation = new OEECalculation($workorder);
        $downtime = $oeeCalculation->getTotalDowntime();
        $smeltings = $oeeCalculation->getSmeltingList();
        
        $createdBy = User::where('id',$workorder->created_by)->first();
        if(!$createdBy)
        {
            $createdBy = '';
        }
        else{
            $createdBy = $createdBy->name;
        }
        
        $editedBy = User::where('id',$workorder->edited_by)->first();
        if(!$editedBy)
        {
            $editedBy = '';
        }
        else{
            $editedBy = $editedBy->name;
        }

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
            'productions'           => $oeeCalculation->getProductions(),
            'reports'               => [
                'production_plan'   => $oeeCalculation->getProductionPlanned(),
                'production_count'  => $oeeCalculation->getTotalProduction() ." Pcs",
			    'total_good_product'=> $oeeCalculation->getTotalGoodProduct() ." Pcs",
                'total_bad_product' => $oeeCalculation->getTotalBadProduct() ." Pcs",
                'planned_time'      => $oeeCalculation->getPlannedTime()->text,
                'total_downtime'    => $downtime->totalDowntime,
                'waste_downtime'    => $downtime->wasteDowntime,
                'management_downtime'   => $downtime->managementDowntime,
                'off_production_time'   => $downtime->offProductionTime,
                'average_speed'         => $oeeCalculation->getAverageSpeed(),
            ],
            'indicator'             => [
                'performance'   => round($oeeCalculation->getPerformance(),1),
                'availability'  => round($oeeCalculation->getAvailability(),1),
                'quality'       => round($oeeCalculation->getQuality(),1),
                'oee'           => round($oeeCalculation->getOee(),1),
            ],
            'smeltingInputList'     => $smeltings,
            'downtimes'             => $oeeCalculation->getDowntimes(),
            'changeRequests'        => $workorder->changeRequests,
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

    

    

}
