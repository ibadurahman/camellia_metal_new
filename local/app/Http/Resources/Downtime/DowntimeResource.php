<?php

namespace App\Http\Resources\Downtime;

use DateTime;
use App\Models\Downtime;
use App\Models\DowntimeRemark;
use Illuminate\Http\Resources\Json\JsonResource;

class DowntimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'workorder'             => $this->workorder,
            'machine_name'          => $this->workorder->machine->name,
            'downtime_number'       => $this->downtime_number,
            'downtime'              => $this->downtime,
            'is_downtime_stopped'   => $this->is_downtime_stopped,
            'is_remark_filled'      => $this->is_remark_filled,
            'dt_status'             => $this->status,
            'start_time'            => call_user_func(function()
            {
                $endTime = Downtime::select('created_at')->where('workorder_id',$this->workorder->id)
                            ->where('status','stop')->where('downtime_number',$this->downtime_number)->first();
                if(!$endTime)
                {
                    return Date('H:i:s',strtotime($this->created_at));
                }
                return Date('H:i:s',strtotime($endTime->created_at));
            }),
            'end_time'              => call_user_func(function()
            {
                $startTime = Downtime::select('created_at')->where('workorder_id',$this->workorder->id)
                            ->where('status','run')->where('downtime_number',$this->downtime_number)->first();
                if(!$startTime)
                {
                    return null;
                }
                return Date('H:i:s',strtotime($startTime->created_at));
            }), 
            'duration'              => call_user_func(function()
            {
                $endTime = Downtime::select('created_at')->where('workorder_id',$this->workorder->id)
                            ->where('status','run')->where('downtime_number',$this->downtime_number)->first();
                if(!$endTime)
                {
                    return "0 Sec";
                }

                $duration = date_diff(new DateTime($this->created_at),new DateTime($endTime->created_at));

                $durationMinutes = $duration->days * 24 * 60;
                $durationMinutes += $duration->h * 60;
                $durationMinutes += $duration->i;

                if($durationMinutes >= 1)
                {
                    $resultMin = $durationMinutes;
                    $resultSec = $duration->s;
                    return $resultMin." Min ".$resultSec." Sec";
                }
                
				return $duration->s. " Sec";

            }),  
            'updated_at'            => $this->updated_at,
			'downtime_category'     => call_user_func(function()
            {
                $downtime_category = DowntimeRemark::select('downtime_category')->where('downtime_id',$this->id)->first();
                if(!$downtime_category)
                {
                    return null;
                }
                if(!$downtime_category->downtime_category)
                {
                    return null;
                }
                return $downtime_category->downtime_category;
            }), 
			'downtime_reason'       => call_user_func(function()
            {
                $downtime_reason = DowntimeRemark::select('downtime_reason')->where('downtime_id',$this->id)->first();
                if(!$downtime_reason)
                {
                    return null;
                }
                return $downtime_reason->downtime_reason;
            }), 
			'remarks'               => call_user_func(function()
            {
                $remarks = DowntimeRemark::select('remarks')->where('downtime_id',$this->id)->first();
                if(is_null($remarks))
                {
                    return '';
                }
                if(is_null($remarks->remarks))
                {
                    return '';
                }
                return $remarks->remarks;
            }), 
        ];
    }
}
