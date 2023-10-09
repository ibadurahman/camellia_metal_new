<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Color;
use App\Models\Machine;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Workorder;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\WorkorderRequest;
use App\Models\ChangeRequest;

class WorkorderController extends Controller
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
        return view('admin.workorder.index',[
            'title' => 'Admin: Workorder',
            'machines' => Machine::all()
        ]);
    }

    public function closedWorkorder()
    {
        return view('admin.workorder.closed',[
            'title' => 'Admin: Closed Workorder'
        ]);
    }

    public function changeRequest(Workorder $workorder)
    {
        return view('admin.workorder.change_form',[
            'title'         => 'Admin: Change Request',
            'workorder'     => $workorder,
            'colors'        => Color::get(),
            'machines'      => Machine::orderBy('name','asc')->get(),
            'suppliers'     => Supplier::where('is_active',true)->get(),
            'customers'     => Customer::where('is_active',true)->get()
        ]);
    }

    public function changeUpdate(WorkorderRequest $request, Workorder $workorder)
    {
        //Detect change
        $changeList = [];
        $request->wo_number != $workorder->wo_number ? $changeList[] = ['wo_number'=>$request->wo_number] : null;
        $request->bb_supplier != $workorder->bb_supplier ? $changeList[] = ['bb_supplier'=>$request->bb_supplier] : null;
        $request->bb_grade != $workorder->bb_grade ? $changeList[] = ['bb_grade'=>$request->bb_grade] : null;
        $request->bb_diameter != $workorder->bb_diameter ? $changeList[] = ['bb_diameter'=>$request->bb_diameter] : null;
        $request->bb_qty_pcs != $workorder->bb_qty_pcs ? $changeList[] = ['bb_qty_pcs'=>$request->bb_qty_pcs] : null;
        $request->bb_qty_coil != $workorder->bb_qty_coil ? $changeList[] = ['bb_qty_coil'=>$request->bb_qty_coil] : null;
        $request->bb_qty_bundle != $workorder->bb_qty_bundle ? $changeList[] = ['bb_qty_bundle'=>$request->bb_qty_bundle] : null;
        $request->fg_customer != $workorder->fg_customer ? $changeList[] = ['fg_customer'=>$request->fg_customer] : null;
        $request->fg_size_1 != $workorder->fg_size_1 ? $changeList[] = ['fg_size_1'=>$request->fg_size_1] : null;
        $request->fg_size_2 != $workorder->fg_size_2 ? $changeList[] = ['fg_size_2'=>$request->fg_size_2] : null;
        $request->tolerance_minus != $workorder->tolerance_minus ? $changeList[] = ['tolerance_minus'=>$request->tolerance_minus] : null;
        $request->tolerance_plus != $workorder->tolerance_plus ? $changeList[] = ['tolerance_plus'=>$request->tolerance_plus] : null;
        $request->straightness_standard != $workorder->straightness_standard ? $changeList[] = ['straightness_standard'=>$request->straightness_standard] : null;
        $request->fg_reduction_rate != $workorder->fg_reduction_rate ? $changeList[] = ['fg_reduction_rate'=>$request->fg_reduction_rate] : null;
        $request->fg_shape != $workorder->fg_shape ? $changeList[] = ['fg_shape'=>$request->fg_shape] : null;
        $request->fg_qty_kg != $workorder->fg_qty_kg ? $changeList[] = ['fg_qty_kg'=>$request->fg_qty_kg] : null;
        $request->fg_qty_pcs != $workorder->fg_qty_pcs ? $changeList[] = ['fg_qty_pcs'=>$request->fg_qty_pcs] : null;
        $request->chamfer != $workorder->chamfer ? $changeList[] = ['chamfer'=>$request->chamfer] : null;
        $request->color != $workorder->color ? $changeList[] = ['color'=>$request->color] : null;
        $request->machine_id != $workorder->machine_id ? $changeList[] = ['machine_id'=>$request->machine_id] : null;
        $request->remarks != $workorder->remarks ? $changeList[] = ['remarks'=>$request->remarks] : null;
        $request->label_remarks != $workorder->label_remarks ? $changeList[] = ['label_remarks'=>$request->label_remarks] : null;

        $changeRequest = new ChangeRequest();
        $changeRequest->workorder_id = $workorder->id;
        $changeRequest->change_data = json_encode($changeList);
        $changeRequest->changed_by = Auth::user()->id;
        $changeRequest->save();

        $workorder->update([
            'wo_number'             =>$request->wo_number,
            'bb_supplier'           =>$request->bb_supplier,
            'bb_grade'              =>$request->bb_grade,
            'bb_diameter'           =>$request->bb_diameter,
            'bb_qty_pcs'            =>$request->bb_qty_pcs,
            'bb_qty_coil'           =>$request->bb_qty_coil,
            'bb_qty_bundle'         =>$request->bb_qty_bundle,
            'fg_customer'           =>$request->fg_customer,
            'fg_size_1'             =>$request->fg_size_1,
            'fg_size_2'             =>$request->fg_size_2,
            'tolerance_minus'       =>$request->tolerance_minus,
			'tolerance_plus'        =>$request->tolerance_plus,
            'straightness_standard' =>$request->straightness_standard,
            'fg_reduction_rate'     =>$request->fg_reduction_rate,
            'fg_shape'              =>$request->fg_shape,
            'fg_qty_kg'             =>$request->fg_qty_kg,
            'fg_qty_pcs'            =>$request->fg_qty_pcs,
            'edited_by'             =>Auth::user()->id,
			'chamfer'               =>$request->chamfer,
			'color'                 =>$request->color,
            'machine_id'            =>$request->machine_id,
            'remarks'               =>preg_replace( "/\r|\n/", "", $request->remarks),
            'label_remarks'         =>preg_replace( "/\r|\n/", "", $request->label_remarks)
        ]);

        return redirect()->route('admin.workorder.index')->with('success','Data Updated Successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // workorder number auto-generate
        $workorders = Workorder::select('wo_number')->where('wo_number','LIKE','%'.date("Y").'%')->max('wo_number');
        
        $woOrder = str_pad("1",5,"0",STR_PAD_LEFT);
        if($workorders)
        {
            $woOrder = explode("/",$workorders);
            $woOrder = (integer) $woOrder[2] + 1;
            $woOrder = str_pad($woOrder,5,"0",STR_PAD_LEFT);
        }
        
        //
        return view('admin.workorder.create',[
            'wo_num'        => 'WO/'.date("Y")."/".$woOrder,
            'title'         => 'Admin: Create Workorder',
			'colors'        => Color::get(),
            'machines'      => Machine::orderBy('name','asc')->get(),
            'suppliers'     => Supplier::where('is_active',true)->get(),
            'customers'     => Customer::where('is_active',true)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkorderRequest $request)
    {
        //
        Workorder::create([
            'wo_number'             =>$request->wo_number,
            'bb_supplier'           =>$request->bb_supplier,
            'bb_grade'              =>$request->bb_grade,
            'bb_diameter'           =>$request->bb_diameter,
            'bb_qty_pcs'            =>$request->bb_qty_pcs,
            'bb_qty_coil'           =>$request->bb_qty_coil,
            'bb_qty_bundle'         =>$request->bb_qty_bundle,
            'fg_customer'           =>$request->fg_customer,
            'fg_size_1'             =>$request->fg_size_1,
            'fg_size_2'             =>$request->fg_size_2,
            'tolerance_minus'       =>$request->tolerance_minus,
			'tolerance_plus'        =>$request->tolerance_plus,
            'straightness_standard' =>$request->straightness_standard,
            'fg_reduction_rate'     =>$request->fg_reduction_rate,
            'fg_shape'              =>$request->fg_shape,
            'fg_qty_kg'             =>$request->fg_qty_kg,
            'fg_qty_pcs'            =>$request->fg_qty_pcs,
            // 'wo_order_num'          =>null,
            // 'status_prod'           => '0',
            // 'status_wo'             => '0',
            // 'status_smelting'       => '0',
            'created_by'            =>Auth::user()->id,
            // 'edited_by'             =>Auth::user()->id,
			'chamfer'               =>$request->chamfer,
			'color'                 =>$request->color,
            'machine_id'            =>$request->machine_id,
            'remarks'               =>preg_replace( "/\r|\n/", "", $request->remarks),
            'label_remarks'         =>preg_replace( "/\r|\n/", "", $request->label_remarks)
        ]);

        return redirect()->route('admin.workorder.index')->with('success','Data Added Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Workorder $workorder)
    {
        // dd($workorder->bb_supplier);
        return view('admin.workorder.edit',[
            'title'         => 'Admin: edit Workorder',
            'workorder'     => $workorder,
			'colors'        => Color::get(),
            'machines'      => Machine::orderBy('name','asc')->get(),
            'suppliers'     => Supplier::where('is_active',true)->get(),
            'customers'     => Customer::where('is_active',true)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WorkorderRequest $request, Workorder $workorder)
    {
        //
        // $workorders = Workorder::select('wo_order_num')->max('wo_order_num');
        // $woOrderNum = $workorders + 1;
        $workorder->update([
            'wo_number'             =>$request->wo_number,
            'bb_supplier'           =>$request->bb_supplier,
            'bb_grade'              =>$request->bb_grade,
            'bb_diameter'           =>$request->bb_diameter,
            'bb_qty_pcs'            =>$request->bb_qty_pcs,
            'bb_qty_coil'           =>$request->bb_qty_coil,
            'bb_qty_bundle'         =>$request->bb_qty_bundle,
            'fg_customer'           =>$request->fg_customer,
            'fg_size_1'             =>$request->fg_size_1,
            'fg_size_2'             =>$request->fg_size_2,
            'tolerance_minus'       =>$request->tolerance_minus,
			'tolerance_plus'        =>$request->tolerance_plus,
            'straightness_standard' =>$request->straightness_standard,
            'fg_reduction_rate'     =>$request->fg_reduction_rate,
            'fg_shape'              =>$request->fg_shape,
            'fg_qty_kg'             =>$request->fg_qty_kg,
            'fg_qty_pcs'            =>$request->fg_qty_pcs,
            // 'wo_order_num'          =>$woOrderNum,
            // 'status_prod'           => '0',
            // 'status_wo'             => '0',
            // 'status_smelting'       => '0',
            'edited_by'             =>Auth::user()->id,
			'chamfer'               =>$request->chamfer,
			'color'                 =>$request->color,
            'machine_id'            =>$request->machine_id,
            'remarks'               =>preg_replace( "/\r|\n/", "", $request->remarks),
            'label_remarks'         =>preg_replace( "/\r|\n/", "", $request->label_remarks)
        ]);

        return redirect()->route('admin.workorder.index')->with('success','Data Updated Successfully');
    }

    public function updateOrder(Request $request){
        $workorders = Workorder::where('status_wo','waiting')->get();

        // $workorders = Workorder::where('status_wo','0')->get();
        foreach($workorders as $workorder){
            $workorder->timestamps = false;
            $id = $workorder->id;

            foreach($request->order as $order){
                if($order['id'] == $id){
                    $workorder->update(['wo_order_num' => $order['position']]);
                }
            }
        }

        return response()->json([
            'message'=>'updated successfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workorder $workorder)
    {
        //
        $workorder->delete();
        return redirect()->route('admin.workorder.index')->with('success','Data Deleted Successfully');
    }

    public function setWoStatus(Request $request)
    {
        $woOrderNum = 0;
        $workorder = Workorder::where('id',$request->wo_id);
        $workorders = Workorder::select('wo_order_num')->max('wo_order_num');
        $woOrderNum = $workorders + 1;

        if($request->state == 'draft')
        {
            $woOrderNum = null;
        }

        $workorder->timestamps = false;
        $workorder->update([
            'status_wo'     => $request->state,
            'wo_order_num'  => $woOrderNum
        ]);

        return response()->json([
            'message' => 'Updated successfully'
        ],201);
    }

    public function calculatePcsPerBundle(Request $request)
    {
        if($request->shape == "Round"){
            return 0.0061654;
        }
        elseif($request->shape == "Hexagon")
        {
            return 0.006798;
        }
        elseif($request->shape == "Square")
        {
            return 0.00785;
        }
        else{
            return 0;
        }
    }

    //
    // Confirm Password
    //
    public function confirmPassword(Request $request)
    {
        $isValid = [
            'result' => true   
        ];
        
        $validation = $request->validate([
            'password' => ['required', new MatchOldPassword]
        ]);

        if(!$validation)
        {
            $isValid['result'] = false;
            return response()->json($isValid);
        }

        return response()->json($isValid);
    }

}
