<?php

namespace App\Http\Controllers\Supervisor;

use Illuminate\Http\Request;
use App\Models\DowntimeReason;
use App\Http\Controllers\Controller;
use App\Models\DowntimeCategory;

class DowntimeReasonController extends Controller
{
    public function index(){
        $categories = DowntimeCategory::all();
        return view('supervisor.downtimereason.index',[
            'title'         => 'Downtime Reason',
            'categories'    => $categories
        ]);
    }

    public function loadData(Request $request)
    {
        $downtimeReasons = DowntimeReason::with('downtimeCategory');
        if($request->category !== '0'){
            $downtimeReasons->where('dt_category_id', $request->category);
        }
        $downtimeReasons = $downtimeReasons->orderBy('created_at', 'DESC')->get();
        
        return datatables()->of($downtimeReasons)
            ->addColumn('downtime_category', function(DowntimeReason $downtimeReason){
                return $downtimeReason->downtimeCategory->name;
            })
            ->addColumn('action','supervisor.downtimereason.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getReason(Request $request)
    {
        $downtimeReasons = DowntimeReason::join('downtime_categories','downtime_categories.id','=','downtime_reasons.dt_category_id')
        ->select('downtime_reasons.name')
        ->where('downtime_categories.name', $request->category)
        ->orderBy('downtime_reasons.name','asc')->get();

        return response()->json([
            'success'   => true,
            'data'      => $downtimeReasons
        ]);
    }

    public function create()
    {
        return view('supervisor.downtimereason.create',[
            'title'         => 'Create Downtime Reason',
            'categories'    => DowntimeCategory::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'dt_category_id'    => 'required',
            'name'              => 'required',
        ]);

        $downtimeReason                 = new DowntimeReason();
        $downtimeReason->dt_category_id = $request->dt_category_id;
        $downtimeReason->name           = $request->name;
        $downtimeReason->save();

        return redirect()->route('downtimeReason.index')->with('success', 'Downtime Reason has been created');
    }

    public function edit(DowntimeReason $downtimeReason)
    {
        return view('supervisor.downtimereason.edit',[
            'title'             => 'Edit Downtime Reason',
            'downtimeReason'    => $downtimeReason,
            'categories'        => DowntimeCategory::all()
        ]);
    }

    public function update(Request $request, DowntimeReason $downtimeReason)
    {
        $request->validate([
            'dt_category_id'    => 'required',
            'name'              => 'required | unique:downtime_reasons,name,'.$downtimeReason->id,
        ]);

        $downtimeReason->dt_category_id = $request->dt_category_id;
        $downtimeReason->name = $request->name;
        $downtimeReason->save();

        return redirect()->route('downtimeReason.index')->with('success', 'Downtime Reason has been updated');
    }

    public function destroy(DowntimeReason $downtimeReason)
    {
        $downtimeReason->delete();

        return redirect()->route('downtimeReason.index')->with('success', 'Downtime Reason has been deleted');
    }
}
