<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Machine;
use App\Models\Realtime;
use App\Models\Workorder;
use Illuminate\Http\Request;

class RealtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $machines = Machine::all();
        foreach ($machines as $machine) {
            $woOnProcess = Workorder::where('status_wo','on process')->where('machine_id',$machine->id)->first();
            $data[$machine->name] =  [
                'wo_number'     => (!$woOnProcess)?'':$woOnProcess->wo_number,
                'createdBy'     => (!$woOnProcess)?'':User::where('id',$woOnProcess->created_by)->first()->name,
                'processedBy'   => (!$woOnProcess)?'':User::where('id',$woOnProcess->processed_by)->first()->name,
                'start_time'    => (!$woOnProcess)?'':Date('Y-m-d H:i:s',strtotime($woOnProcess->process_start)),
                'customer'      => (!$woOnProcess)?'':$woOnProcess->fg_customer,
                'machine'       => (!$woOnProcess)?'':$woOnProcess->machine->name,
                'size'          => (!$woOnProcess)?'':$woOnProcess->fg_size_1 . 'mm X ' . $woOnProcess->fg_size_2 . ' mm',
                'status'        => (!$woOnProcess)?'':$woOnProcess->status_wo
            ];
        }
        // dd($data);
        return view('user.home',[
            'title'=> 'Home',
            'data' => $data,
            'machines' => Machine::all(),
        ]);
    }

    public function ajaxRequest()
    {
        //
        $woId =  Workorder::where('status_wo','on process')->orderBy('wo_order_num','asc')->first();
        if(!$woId)
        {
            return response()->json([
                'speed'     => 0,
                'counter'   => 0
            ]);
        }
        $data =  Realtime::where('workorder_id',$woId['id'])->orderBy('created_at','desc')->first();
        return response()->json([
            'speed'     => $data->speed,
            'counter'   => $data->counter
        ]);
    }

    public function speedChart()
    {
        //
        $woId =  Workorder::where('status_wo','on process')->orderBy('wo_order_num','asc')->first();
        if(!$woId)
        {
            return response()->json([
                'speed'         => [],
                'created_at'    => []
            ]);
        }

        $data = json_decode(Realtime::select('speed','created_at')->where('workorder_id',$woId['id'])->orderBy('created_at','desc')->limit(20)->get());
        $response = [
            'speed'         => array_column($data,'speed'),
            'created_at'    => array_column($data,'created_at')
        ];
        for ($i=0; $i < count($response['created_at']); $i++) { 
            $response['created_at'][$i] = date('H:i:s',strtotime($response['created_at'][$i]));
        }
        return response()->json($response);
    }

    public function workorderOnProcess()
    {
        //
        $data =  Workorder::where('status_wo','on process')->orderBy('wo_order_num','asc')->first();
        if(!$data){
            return response('no data',404);
        }
        return response()->json([
            'wo_number'     => $data['wo_number'],
            'createdBy'     => User::where('id',$data->created_by)->first()->name,
            'processedBy'   => User::where('id',$data->processed_by)->first()->name,
            'start_time'    => Date('Y-m-d H:i:s',strtotime($data->process_start)),
            'customer'      => $data['fg_customer'],
            'machine'       => $data->machine->name,
            'size'          => $data->fg_size_1 . 'mm X ' . $data->fg_size_2 . ' mm',
        ],200);
    }

    public function searchSpeed(Request $request)
    {
        $data = Realtime::select('speed','created_at');
        
        if($request->report_date_1 != null)
        {
            $data->where('created_at','>=',$request->report_date_1);
        }
        if($request->report_date_2 != null)
        {
            $data->where('created_at','<=',$request->report_date_2);
        }
        $data = json_decode($data->get());
        $response = [
            'speed' => array_column($data,'speed'),
            'created_at'    => array_column($data,'created_at')
        ];
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Realtime  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function show(Realtime $monitoring)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Realtime  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function edit(Realtime $monitoring)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Realtime  $realtime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Realtime $monitoring)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Realtime  $realtime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Realtime $monitoring)
    {
        //
    }
}
