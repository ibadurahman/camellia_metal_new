<?php

namespace App\Http\Controllers\Operator;

use App\Models\Workorder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorkorderHasTpmController extends Controller
{
    public function store(Request $request, Workorder $workorder){
        if($request->method() != 'POST'){
            return redirect()->back()->with('error','Method not allowed')->withInput();
        }

        return redirect()->back()->with('success','Data has been saved');
    }
}
