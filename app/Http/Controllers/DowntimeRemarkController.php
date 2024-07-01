<?php

namespace App\Http\Controllers;

use App\Models\Downtime;
use Illuminate\Http\Request;
use App\Models\DowntimeRemark;

class DowntimeRemarkController extends Controller
{
    //

    public function submitDowntimeRemark(Request $request)
    {
        try {
            $downtime = Downtime::where('downtime_number', $request->downtimeNumber);

            if ($downtime->count() == 0) {
                return response()->json([
                    'message' => 'Downtime Data Not Found'
                ], 404);
            }

            $request->validate([
                'downtimeNumber'    => 'required|numeric',
                'downtimeCategory'  => 'required',
                'downtimeReason'    => 'required',
            ]);

            DowntimeRemark::where('downtime_id', $downtime->first()->id)->delete();

            $remark = DowntimeRemark::create([
                'downtime_id'       => $downtime->first()->id,
                'downtime_category' => $request->downtimeCategory,
                'downtime_reason'   => $request->downtimeReason,
                'remarks'           => $request->downtimeRemarks,
            ]);

            $downtime = Downtime::where('downtime_number', $request->downtimeNumber)->get();
            foreach ($downtime as $dt) {
                $dt->is_remark_filled = true;
                $dt->save();
            }

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 400);
        }
        return response()->json([
            'message'   => 'data updated successfully',
        ], 200);
    }
}
