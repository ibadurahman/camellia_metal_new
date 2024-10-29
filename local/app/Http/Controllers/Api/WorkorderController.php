<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiWorkorder\WorkorderCollection;
use App\Models\Workorder;
use Illuminate\Http\Request;

class WorkorderController extends Controller
{
    public function getWorkorders(Request $request) {
        $workorder = Workorder::all();
        $workorderCollection = new WorkorderCollection($workorder);
        
        return response()->json([
            'status' => 'success',
            'data' => $workorderCollection
        ]);
    }
}
