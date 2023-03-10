<?php

namespace App\Http\Controllers\Api;

use App\Models\Machine;
use App\Models\Realtime;
use App\Models\Workorder;
use Illuminate\Http\Request;
use App\Events\productionGraph;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealtimeApiRequest;

class RealtimeApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(RealtimeApiRequest $request)
    {
        //
        $data = $request->all();

        $machine = Machine::where('name',$data['machine'])->first();
        if(!$machine)
        {
            return response()->json([
                'messages'=>'machine name not found'
            ],404);
        }
        $workorderId = Workorder::select('id')->where('status_wo','on process')->where('machine_id',$machine->id)->first();
        if(!$workorderId)
        {
            return response()->json([
                'messages'=>'workorder data not found'
            ],404);
        }

        $data = [
            'machine'       => $machine,
            'workorder_id'  => $workorderId->id,
            'speed'         => $data['speed'],
            'counter'       => $data['counter']
        ];

        Realtime::create([
            'workorder_id'  => $workorderId->id,
            'speed'         => $data['speed'],
            'counter'       => $data['counter']
        ]);

        Workorder::where('id',$workorderId->id)->update(['status_wo'=>'on process','wo_order_num'=>null]);

        event(new productionGraph($data));

        return response()->json([
            'messages'=>'New data submited successfully'
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
