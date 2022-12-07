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
        $downtimeRemark = DowntimeRemark::select('is_waste_downtime')->where('downtime_id',$this->id)->first();
        if(!$downtimeRemark)
        {
            return '';
        }
        if(!$downtimeRemark->is_waste_downtime)
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
                $endTime = Downtime::select('downtime')->where('workorder_id',$this->workorder->id)
                            ->where('status','run')->where('downtime_number',$this->downtime_number)->first();
                if(!$endTime)
                {
                    return Date('H:i',strtotime($this->time));
                }
                if(($endTime->downtime / 60) >= 1)
                {
                    $resultMin = round($endTime->downtime / 60,0);
                    $resultSec = $endTime->downtime - ($resultMin*60);
                    return $resultMin." Min ".$resultSec." Sec";
                }
                
				return $endTime->downtime." Sec";
            }),
            'is_waste_downtime' => call_user_func(function()
            {
                $result = DowntimeRemark::where('downtime_id',$this->id)->first();
                if(!$result)
                {
                    return false;
                }
                if(!$result->is_waste_downtime)
                {
                    return false;
                }
                if($result->is_waste_downtime == 0)
                {
                    return false;
                }
                return true;
            }),
            'total_duration'    => call_user_func(function()
            {
                $reason = DowntimeRemark::select('downtime_reason')->where('downtime_id',$this->id)->first();
                $downtimeIds = DowntimeRemark::select('downtime_id')->where('downtime_reason',$reason->downtime_reason)->get();
                $totalDuration = 0;
                
                foreach ($downtimeIds as $value) {

                    $startTime = Downtime::select('created_at')->where('workorder_id',$this->workorder->id)
                                ->where('status','stop')->where('downtime_number',$this->downtime_number)->first();
                    $endTime = Downtime::select('created_at')->where('workorder_id',$this->workorder->id)
                                ->where('status','run')->where('downtime_number',$this->downtime_number)->first();
                    if(!$endTime)
                    {
                        return 0;
                    }
                    $duration = date_diff(new DateTime($startTime->created_at),new DateTime($endTime->created_at));
                    $durationSec = $duration->days * 24 * 60;
                    $durationSec += $duration->h * 60;
                    $durationSec += $duration->i;

                    $totalDuration += $durationSec;
                }
                return $totalDuration;
            })
        ];
    }
}
