<?php

namespace App\Http\Controllers\api;

use App\Models\Machine;
use App\Models\Downtime;
use App\Models\Workorder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\DowntimeCaptured;

class DowntimeApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $aRequest = [
            'machine_id'=> $request->mesin_id,
            'time'      => date('H:i:00',strtotime($request->time)),
            'status'    => $request->status,
            'downtime'  => $request->downtime
        ];

        $machine = Machine::where('name',$aRequest['machine_id'])->first();
        if(is_null($machine))
        {
            return response()->json([
                'message' => 'Machine not Found'
            ],404);
        }
        $workorder = Workorder::where('machine_id',$machine->id)->where('status_wo','on process')->get();
        if(count($workorder)==0)
        {
            return response()->json([
                'message' => 'No Workorder is Running'
            ],200);
        }
        if (count($workorder)>1) {
            return response()->json([
                'message' => 'More than one workorder is running'
            ],200);
        }

        $downtime = Downtime::create([
            'workorder_id'          => $workorder[0]->id,
            'downtime_number'       => call_user_func(function() use ($aRequest,$workorder){
                                            if($aRequest['status']=='stop')
                                            {
                                                return Date($workorder[0]->machine->id.'YmdHis');
                                            }
                                            $lastDowntimeRun = Downtime::where('workorder_id',$workorder[0]->id)
                                                                    ->where('status','stop')->orderBy('id','desc')->first();
                                            return $lastDowntimeRun->downtime_number;
                                        }),
            'time'                  => $aRequest['time'],
            'status'                => $aRequest['status'],
            'downtime'              => $aRequest['downtime'],
            'is_downtime_stopped'   => call_user_func(function() use ($aRequest,$workorder){
                                            if($aRequest['status']=='stop'){
                                                return false;
                                            }
                                            $lastRunDowntime = Downtime::where('workorder_id',$workorder[0]->id)
                                                                ->where('status','stop')->orderBy('id','desc')->first();
                                            $lastRunDowntime->update([
                                                'is_downtime_stopped' => true,
                                            ]);
                                            return true;
                                        }),
            'is_remark_filled'      => false,
        ]);

        event(new DowntimeCaptured([
            'workorder_id'          => $workorder[0]->id,
            'downtime_number'       => call_user_func(function() use ($aRequest,$workorder){
                                            if($aRequest['status']=='stop')
                                            {
                                                return Date($workorder[0]->machine->id.'YmdHis');
                                            }
                                            $lastDowntimeRun = Downtime::where('workorder_id',$workorder[0]->id)
                                                                    ->where('status','stop')->orderBy('id','desc')->first();
                                            return $lastDowntimeRun->downtime_number;
                                        }),
            'time'                  => $aRequest['time'],
            'status'                => $aRequest['status'],
            'downtime'              => $aRequest['downtime'],
            'is_downtime_stopped'   => call_user_func(function() use ($aRequest,$workorder){
                                            if($aRequest['status']=='stop'){
                                                return false;
                                            }
                                            $lastRunDowntime = Downtime::where('workorder_id',$workorder[0]->id)
                                                                ->where('status','stop')->orderBy('id','desc')->first();
                                            $lastRunDowntime->update([
                                                'is_downtime_stopped' => true,
                                            ]);
                                            return true;
                                        }),
            'is_remark_filled'      => false,
            'machine'               => $machine->name
        ]));

        return response()->json([
            'message' => 'Data Submitted Successfully'
        ],200);
    }
}
