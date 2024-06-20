<?php
namespace App\Helpers;

use DateTime;
use stdClass;
use App\Models\Downtime;
use App\Models\Realtime;
use App\Models\Smelting;
use App\Models\Production;
use App\Models\DowntimeRemark;

class OEECalculation {
    protected $workorder;
    public function __construct($workorder)
    {
        $this->workorder = $workorder;
    }

    public function getProductions(){
        $productions = Production::where('workorder_id',$this->workorder->id)->get();
        return $productions;
    }

    public function getTotalProduction(){
        $productions    = $this->getProductions();
        $productionCount = 0;
        foreach($productions as $prod)
        {
            $productionCount += $prod->pcs_per_bundle;
        }
        return $productionCount;
    }
    
    public function getSmeltingList(){
        $smeltings      = Smelting::where('workorder_id',$this->workorder->id)->orderBy('coil_num','ASC')->get();
        $smeltingInputList = [];
        foreach ($smeltings as $smelting) 
        {
            $productionCheck = Production::where('workorder_id',$this->workorder->id)->where('coil_num',$smelting->bundle_num)->first();
            if($productionCheck == null)
            {
                $smeltingInputList[] = $smelting->coil_num;
            }
        }
        return $smeltingInputList;
    }

    public function getDowntimes(){
        $downtimes = Downtime::where('workorder_id',$this->workorder->id)->where('status','stop')->get();
        return $downtimes;
    }

    public function getTotalDowntime(){
        $downtime = new stdClass();
        $downtime->totalDowntime = 0;
        $downtime->wasteDowntime = 0;
        $downtime->managementDowntime = 0;
        $downtime->offProductionTime = 0;

        $downtimeSummary = Downtime::where('status','stop')
                                ->where('workorder_id',$this->workorder->id)
                                ->get();
        foreach($downtimeSummary as $dt)
        {
            $downtimeRunId = Downtime::where('status','run')
                                ->where('downtime_number',$dt->downtime_number)
                                ->first();
            $downtimeStopId = Downtime::where('status','stop')
                                ->where('downtime_number',$dt->downtime_number)
                                ->first();
            $downtimeRemark = DowntimeRemark::where('downtime_id',$downtimeStopId->id)->first();

            if(!$downtimeRemark)
            {
                continue;
            }

            $duration = date_diff(new DateTime($downtimeStopId->created_at),new DateTime($downtimeRunId->created_at));

            $durationSec = $duration->days * 24 * 60 * 60;
            $durationSec += $duration->h * 60 * 60;
            $durationSec += $duration->i * 60;
            $durationSec += $duration->s;
                
            if($downtimeRemark->downtime_category == 'waste')
            {
                $downtime->wasteDowntime += $durationSec;
            }
            if($downtimeRemark->downtime_category == 'management')
            {
                $downtime->managementDowntime += $durationSec;
            }
            if($downtimeRemark->downtime_category == 'off')
            {
                $downtime->offProductionTime += $durationSec;
            }
            $downtime->totalDowntime += $durationSec;
        }

        $downtime->totalDOwntimeStr = $this->getDowntimeStr($downtime->totalDowntime);
        $downtime->wasteDowntimeStr = $this->getDowntimeStr($downtime->wasteDowntime);
        $downtime->managementDowntimeStr = $this->getDowntimeStr($downtime->managementDowntime);
        $downtime->offProductionTimeStr = $this->getDowntimeStr($downtime->offProductionTime);

        return $downtime;
    }

    private function getDowntimeStr($seconds){
        // Total Downtime Calculation
        if(($seconds / 60) >=1)
        {
            $total_downtime_min = floor($seconds/60);
            $total_downtime_sec = $seconds - ($total_downtime_min * 60);
            $total_downtime = $total_downtime_min." Mins ".$total_downtime_sec." Secs";
        }
        else{
            $total_downtime = $seconds." Secs";
        }
        if(($seconds / 3600) >=1)
        {
            $total_downtime_hour = floor($seconds/3600);
            $total_downtime_min = floor(($seconds - ($total_downtime_hour * 60 * 60))/60);
            $total_downtime_sec = $seconds - ($total_downtime_hour * 60 * 60) - ($total_downtime_min * 60);
            $total_downtime = $total_downtime_hour." Hours ".$total_downtime_min." Mins ".$total_downtime_sec." Secs";
        }
        if(($seconds / 86400) >=1)
        {
            $total_downtime_days = floor($seconds/86400);
            $total_downtime_hour = floor(($seconds - ($total_downtime_days * 24 * 60 * 60))/3600);
            $total_downtime_min = floor(($seconds - ($total_downtime_days * 24 * 60 * 60) - ($total_downtime_hour * 60 * 60))/60);
            $total_downtime_sec = $seconds - ($total_downtime_days * 24 * 60 * 60) - ($total_downtime_hour * 60 * 60) - ($total_downtime_min * 60);
            $total_downtime = $total_downtime_days." Days ".$total_downtime_hour." Hours ".$total_downtime_min." Mins ".$total_downtime_sec." Secs";
        }

        return $total_downtime;
    }

    public function getTotalGoodProduct(){
        // Total Good Product Calculation
        $total_good_product = 0;
        $good_products = Production::select('pcs_per_bundle')->where('workorder_id',$this->workorder->id)->where('bundle_judgement','good')->get();  
        foreach($good_products as $good_pro)
        {
            $total_good_product += $good_pro->pcs_per_bundle;
        }
        return $total_good_product;
    }

    public function getTotalBadProduct(){
        // Total Bad Product Calculation
        $total_bad_product = 0;
        $bad_products = Production::select('pcs_per_bundle')->where('workorder_id',$this->workorder->id)->where('bundle_judgement','notgood')->get();  
        foreach($bad_products as $bad_pro)
        {
            $total_bad_product += $bad_pro->pcs_per_bundle;
        }
        return $total_bad_product;
    }

    public function getAvailability(){
        $plannedTimeMinutes = $this->getPlannedTime()->minutes;
        $downtime = $this->getTotalDowntime();

        $otr = 0;
        if (floor($downtime->wasteDowntime/60) == 0) {
            $otr = 100;
        }
        else{
            $otr = ((($plannedTimeMinutes-($downtime->managementDowntime/60)-($downtime->offProductionTime/60)) - (floor($downtime->wasteDowntime/60))) / ($plannedTimeMinutes-($downtime->managementDowntime/60)-($downtime->offProductionTime/60)))*100;
        }

        return $otr;
    }

    public function getProductionPlanned(){
        $productionPlanned = round($this->workorder->bb_qty_pcs / $this->workorder->fg_size_1 / $this->workorder->fg_size_1 / $this->workorder->fg_size_2 / $this->getPcsPerBundle($this->workorder->fg_shape) *1000,0);
        return $productionPlanned;
    }

    public function getPerformance(){
        $productionPlanned = $this->getProductionPlanned();
        $productionCount = $this->getTotalProduction();
        $total_good_product = $this->getTotalGoodProduct();
        $cycleTime = $this->getCycletime();
        $plannedTimeMinutes = $this->getPlannedTime()->minutes;
        $downtime = $this->getTotalDowntime();

        $per = 0;
        // $productionPlanned = ($workorder->fg_qty_pcs * $workorder->bb_qty_bundle);
        if ($productionCount == 0 || $cycleTime == 0) {
            $per = 100;
        }else{
            $per = ($total_good_product/((($plannedTimeMinutes-($downtime->managementDowntime/60)-($downtime->offProductionTime/60))-($downtime->wasteDowntime/60))*60/$cycleTime))*100;
        }
        return $per;
    }

    public function getQuality(){
        $productionCount = $this->getTotalProduction();
        $total_good_product = $this->getTotalGoodProduct();
        $total_bad_product = $this->getTotalBadProduct();

        $qr = 0;
        if ($productionCount == 0) {
            $qr = 100;
        }else if($total_good_product == 0){
            $qr = 0;
        }else{
            $qr = (($total_good_product - $total_bad_product) / $total_good_product)*100;
        }

        return $qr;
    }

    public function getAverageSpeed(){
        $realtimeQuery = Realtime::select('speed')->where('workorder_id',$this->workorder->id)->where('speed','>=','10');
        if($realtimeQuery->count() != 0){
            $machineAvgSpeed = $realtimeQuery->sum('speed') / $realtimeQuery->count();
        }else{
            $machineAvgSpeed = 10;
        }

        return $machineAvgSpeed;
    }

    public function getCycletime(){
        $machineAvgSpeed = $this->getAverageSpeed();
        
        if ($machineAvgSpeed != 0) {
            $cycleTime = ($this->workorder->fg_size_2*60/$machineAvgSpeed)/1000;
        }else{
            $cycleTime = 0;
        }

        return $cycleTime;
    }

    public function getPcsPerBundle($shape)
    {
        if($shape == "Round"){
            return 0.0061654;
        }
        elseif($shape == "Hexagon")
        {
            return 0.006798;
        }
        elseif($shape == "Square")
        {
            return 0.00785;
        }
        else{
            return 0;
        }
    }

    public function getPlannedTime(){
        $plannedTimeObj = new stdClass();
        $plannedTimeObj->minutes = 0;
        $plannedTimeObj->text = "";

        if(is_null($this->workorder->process_end))
        {
            $plannedTime = date_diff(new DateTime($this->workorder->process_start),new DateTime(now()));
        }else{
            $plannedTime = date_diff(new DateTime($this->workorder->process_start),new DateTime($this->workorder->process_end));
        }

        $plannedTimeObj->minutes += $plannedTime->days * 24 * 60;
        $plannedTimeObj->minutes += $plannedTime->h * 60;
        $plannedTimeObj->minutes += $plannedTime->i;

        if ($plannedTime->days > 0) {
            $plannedTimeObj->text = $plannedTime->days . ' Days ';
        }
        if ($plannedTime->h > 0) {
            $plannedTimeObj->text .= $plannedTime->h . ' Hours ';
        }

        $plannedTimeObj->text .= $plannedTime->i . ' Minutes ' ;

        return $plannedTimeObj;
    }

    public function getOee(){
        $otr = $this->getAvailability();
        $per = $this->getPerformance();
        $qr = $this->getQuality();

        $oee = 0;
        $oee = (($per/100) * ($otr/100) * ($qr/100))*100;
        if($oee > 100){
            $oee = 100;
        }

        return $oee;
    }
}

