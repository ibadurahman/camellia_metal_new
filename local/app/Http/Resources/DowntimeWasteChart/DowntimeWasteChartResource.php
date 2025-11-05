<?php

namespace App\Http\Resources\DowntimeWasteChart;

use DateTime;
use App\Models\Downtime;
use App\Models\DowntimeRemark;
use Illuminate\Http\Resources\Json\JsonResource;

class DowntimeWasteChartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $downtimeRemark = DowntimeRemark::select('downtime_category')->where('downtime_id',$this->id)->first();
        if(!$downtimeRemark)
        {
            return '';
        }
        if($downtimeRemark->downtime_category != 'waste')
        {
            return '';
        }
        
        return [
            'workorder_number'  => $this->workorder->wo_number,
            'reason'            => call_user_func(function()
            {
                $reason = DowntimeRemark::select('downtime_reason')->where('downtime_id',$this->id)->first();
                return $reason->downtime_reason;
            }),
            'duration'          => call_user_func(function()
            {
                $startTime = Downtime::select('created_at')->where('workorder_id',$this->workorder->id)
                            ->where('status','stop')->where('downtime_number',$this->downtime_number)->first();
                $endTime = Downtime::select('created_at')->where('workorder_id',$this->workorder->id)
                            ->where('status','run')->where('downtime_number',$this->downtime_number)->first();
                if(!$endTime)
                {
                    return 0;
                }
                $downtime = date_diff(new DateTime($startTime->created_at),new DateTime($endTime->created_at));
                // Convert to minutes correctly: days*1440 + hours*60 + minutes + seconds/60
                $downtimeMin = $downtime->days * 24 * 60;      // days to minutes
                $downtimeMin += $downtime->h * 60;             // hours to minutes  
                $downtimeMin += $downtime->i;                  // minutes
                $downtimeMin += $downtime->s / 60;             // seconds to minutes

				return round($downtimeMin, 2);
            }),
            'downtime_category' => call_user_func(function()
            {
                $result = DowntimeRemark::where('downtime_id',$this->id)->first();
                return $result->downtime_category;
            }),
            'total_duration'    => call_user_func(function()
            {
                $reason = DowntimeRemark::select('downtime_reason')->where('downtime_id',$this->id)->first();
                $downtimeIds = DowntimeRemark::select('downtime_id')->where('downtime_reason',$reason->downtime_reason)->whereHas('downtime', function($query) {
                    $query->where('workorder_id', $this->workorder->id);
                })->get();
                $totalDurationSeconds = 0;
                
                foreach ($downtimeIds as $value) {
                    // Get the specific downtime record for this downtime_id
                    $downtimeRecord = Downtime::where('id', $value->downtime_id)->first();
                    if (!$downtimeRecord) {
                        continue;
                    }

                    $startTime = Downtime::select('created_at')->where('workorder_id',$this->workorder->id)
                                ->where('status','stop')->where('downtime_number',$downtimeRecord->downtime_number)->first();
                    $endTime = Downtime::select('created_at')->where('workorder_id',$this->workorder->id)
                                ->where('status','run')->where('downtime_number',$downtimeRecord->downtime_number)->first();
                    if(!$endTime)
                    {
                        continue; // Skip incomplete downtimes, don't return 0 for the whole calculation
                    }
                    $duration = date_diff(new DateTime($startTime->created_at),new DateTime($endTime->created_at));
                    // Convert to seconds correctly: days*86400 + hours*3600 + minutes*60 + seconds
                    $durationSec = $duration->days * 24 * 60 * 60;    // days to seconds
                    $durationSec += $duration->h * 60 * 60;           // hours to seconds
                    $durationSec += $duration->i * 60;                // minutes to seconds
                    $durationSec += $duration->s;                      // seconds

                    $totalDurationSeconds += $durationSec;
                }
                return round($totalDurationSeconds / 60, 2);
            })
        ];
    }
}
