<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
        return view('admin.supplier.index',[
            'title' => 'Admin: Supplier'
        ]);
    }

    public function inactivated()
    {
        return view('admin.supplier.nonactive',[
            'title' => 'Admin: Non Active Supplier'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.supplier.create',[
            // 'wo_num'        => 'WO/'.date("Y")."/".$woOrder,
            'title'         => 'Admin: Create Supplier',
            // 'machines'      => Machine::orderBy('name','asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        //

        Supplier::create([
            'name'  => $request->name,
            'grade' => $request->grade,
            'diameter'  => $request->diameter,
            'qty_kg'    => $request->qty_kg,
            'qty_coil'  => $request->qty_coil,
            'qty_bundle' => $request->qty_bundle,
        ]);

        return redirect()->route('admin.supplier.index')->with('success','Data Added Successfully');
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
    public function edit(Supplier $supplier)
    {
        //
        return view('admin.supplier.edit',[
            'title'         => 'Admin: Edit Supplier',
            'supplier'     => $supplier,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        //
        $supplier->update([
            'name'      => $request->name,
            'grade'     => $request->grade,
            'diameter'  => $request->diameter,
            'qty_kg'    => $request->qty_kg,
            'qty_coil'  => $request->qty_coil,
            'qty_bundle'=> $request->qty_bundle
        ]);

        return redirect()->route('admin.supplier.index')->with('success','Data Updated Successfully');
    }

    public function inactive(Supplier $supplier)
    {
        //
        $supplier->is_active = false;
        $supplier->save();
        
        return redirect()->route('admin.supplier.index')->with('success','Data inactivated successfully');
    }

    public function activate(Supplier $supplier)
    {
        //
        $supplier->is_active = true;
        $supplier->save();
        
        return redirect()->route('admin.supplier.index')->with('success','Data activated successfully');
    }

    public function getSupplierData(Request $request)
    {
        $supplier = Supplier::where('name',$request->name)->first();
        if(!$supplier)
        {
            return response()->json([
                'message' => 'supplier data not found'
            ],404);
        }

        return response()->json([
            $supplier
        ],200);
    }
}
