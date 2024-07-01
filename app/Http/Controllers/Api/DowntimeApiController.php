<?php

namespace App\Http\Controllers\api;

use DateTime;
use App\Models\Machine;
use App\Models\Downtime;
use App\Models\Workorder;
use Illuminate\Http\Request;
use App\Events\DowntimeCaptured;
use App\Http\Controllers\Controller;

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
            ],400);
        }
        if (count($workorder)>1) {
            return response()->json([
                'message' => 'More than one workorder is running'
            ],400);
        }

        if($aRequest['status']=='stop')
        {
            $lastDowntimeRun = Downtime::where('workorder_id',$workorder[0]->id)->orderBy('id','desc')->first();
            if(!is_null($lastDowntimeRun) && $lastDowntimeRun->status=='stop')
            {
                return response()->json([
                    'message' => 'Downtime is already stopped'
                ],400);
            }

            
        }

        if($aRequest['status']=='run')
        {
            $lastDowntimeRun = Downtime::where('workorder_id',$workorder[0]->id)->orderBy('id','desc')->first();
            if(!is_null($lastDowntimeRun) && $lastDowntimeRun->status=='run')
            {
                return response()->json([
                    'message' => 'Downtime is already running'
                ],400);
            }

            // $downtimeRunId = Downtime::where('workorder_id',$workorder[0]->id)->where('status', 'stop')->where('downtime_number', $lastDowntimeRun->downtime_number)->first();
            // if(!is_null($downtimeRunId)){
            //     $duration = date_diff(new DateTime($lastDowntimeRun->created_at), new DateTime($downtimeRunId->created_at));

            //     $durationSec = $duration->days * 24 * 60 * 60;
            //     $durationSec += $duration->h * 60 * 60;
            //     $durationSec += $duration->i * 60;
            //     $durationSec += $duration->s;
    
            //     if($durationSec < 60)
            //     {
            //         $lastDowntimeRun->delete();
            //         return response()->json([
            //             'message' => 'Downtime is less than 1 minute'
            //         ],400);
            //     }
            // }
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
