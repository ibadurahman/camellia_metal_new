<?php

namespace App\Http\Controllers\Admin;

use App\Models\Smelting;
use App\Models\Workorder;
use Illuminate\Http\Request;
use App\Http\Requests\SmeltingRequest;
use App\Http\Controllers\Controller;
use App\Models\ChangeRequest;

class SmeltingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super-admin|office-admin|owner']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function leburanChangeRequest(Workorder $workorder)
    {
        return view('admin.smelting.leburan_change_form',[
            'title'        => 'Admin: Create Smelting',
            'wo_id'        => $workorder->id,
            'wo_number'    => $workorder->wo_number,
            'numberOfCoil' => $workorder->bb_qty_coil,
            'workorder'    => $workorder
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $workorder = Workorder::where('id',$request->id)->first();
        return view('admin.smelting.create',[
            'title'        => 'Admin: Create Smelting',
            'wo_id'        => $workorder->id,
            'wo_number'    => $workorder->wo_number,
            'numberOfCoil' => $workorder->bb_qty_coil
        ]);
    }

    public function addSmelting(SmeltingRequest $request){
        $coilNum = Smelting::where('workorder_id',$request->wo_id)->max('coil_num');
        $bundleCollection = Smelting::where('workorder_id',$request->wo_id)->orderBy('coil_num','asc')->get();

        $coilNum++;

        for($i = 0; $i < count($bundleCollection); $i++)
        {
            if($bundleCollection[$i]->coil_num != $i+1)
            {
                $coilNum = $i+1; 
                break;  
            }
        }

        Smelting::create([
            'coil_num'          =>$coilNum,
            'workorder_id'      =>$request->wo_id,
            'weight'            =>$request->weight,
            'smelting_num'      =>$request->smelting_num,
            'area'              =>$request->area,    
        ]);

        return response()->json([
            'message'=>'updated successfully'
        ],200);
    }

    public function getDataWo(Request $request){
        $bundleNum = Smelting::where('workorder_id',$request->wo_id)->count();
        $totalWeight = Smelting::where('workorder_id',$request->wo_id)->sum('weight');
        return response()->json([
            'number_of_smelting'=>$bundleNum,
            'total_weight'=>$totalWeight
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Smelting  $smelting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Smelting $smelting)
    {
        $smelting->update([
            'weight'            =>$request->weight,
            'smelting_num'      =>$request->smelting_num,
            'area'              =>$request->area,    
        ]);

        return response()->json([
            'message'=>'updated successfully'
        ],200);
    }


    public function addSmeltingChange(SmeltingRequest $request){
        $changeList = [];
        $changeList['weight'] = $request->weight;
        $changeList['smelting_num'] = $request->smelting_num .' added';
        $changeList['area'] = $request->area;

        $changeRequest = new ChangeRequest();
        $changeRequest->workorder_id = $request->wo_id;
        $changeRequest->change_data = json_encode($changeList);
        $changeRequest->changed_by = auth()->user()->id;
        $changeRequest->save();

        $coilNum = Smelting::where('workorder_id',$request->wo_id)->max('coil_num');
        $bundleCollection = Smelting::where('workorder_id',$request->wo_id)->orderBy('coil_num','asc')->get();

        $coilNum++;

        for($i = 0; $i < count($bundleCollection); $i++)
        {
            if($bundleCollection[$i]->coil_num != $i+1)
            {
                $coilNum = $i+1; 
                break;  
            }
        }

        Smelting::create([
            'coil_num'          =>$coilNum,
            'workorder_id'      =>$request->wo_id,
            'weight'            =>$request->weight,
            'smelting_num'      =>$request->smelting_num,
            'area'              =>$request->area,    
        ]);

        return response()->json([
            'message'=>'updated successfully'
        ],200);
    }

    public function getDataWoChange(Request $request){
        $bundleNum = Smelting::where('workorder_id',$request->wo_id)->count();
        $totalWeight = Smelting::where('workorder_id',$request->wo_id)->sum('weight');
        return response()->json([
            'number_of_smelting'=>$bundleNum,
            'total_weight'=>$totalWeight
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Smelting  $smelting
     * @return \Illuminate\Http\Response
     */
    public function updateChange(Request $request, Smelting $smelting)
    {
        $changeList = [];
        $changeList['weight'] = $request->weight;
        $changeList['smelting_num'] = $request->smelting_num .' updated';
        $changeList['area'] = $request->area;

        $changeRequest = new ChangeRequest();
        $changeRequest->workorder_id = $smelting->workorder_id;
        $changeRequest->change_data = json_encode($changeList);
        $changeRequest->changed_by = auth()->user()->id;
        $changeRequest->save();
        
        $smelting->update([
            'weight'            =>$request->weight,
            'smelting_num'      =>$request->smelting_num,
            'area'              =>$request->area,    
        ]);

        return response()->json([
            'message'=>'updated successfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Smelting  $smelting
     * @return \Illuminate\Http\Response
     */
    public function destroyChange(Smelting $smelting)
    {
        $changeList = [];
        $changeList['smelting_num'] = $smelting->smelting_num .' deleted';

        $changeRequest = new ChangeRequest();
        $changeRequest->workorder_id = $smelting->workorder_id;
        $changeRequest->change_data = json_encode($changeList);
        $changeRequest->changed_by = auth()->user()->id;
        $changeRequest->save();
        
        $smelting->delete();
        return redirect()->route('admin.smelting.leburanChangeRequest',['workorder' => $smelting->workorder_id])->with('success','Data Deleted Successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Smelting  $smelting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Smelting $smelting)
    {
        //
        $smelting->delete();
        return redirect()->route('admin.smelting.create',['id'=>$smelting->workorder_id])->with('success','Data Deleted Successfully');
    }
}
