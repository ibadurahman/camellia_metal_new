<?php

namespace App\Exports;

use DateTime;
use App\Models\User;
use App\Models\Color;
use App\Models\Downtime;
use App\Models\Smelting;
use App\Models\Workorder;
use App\Models\Production;
use App\Models\DowntimeRemark;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use App\Http\Resources\WorkorderReport\WorkorderReportCollection;

class WorkorderDataSheet implements ShouldAutoSize, WithTitle, WithEvents, WithDrawings
{
    public function __construct(Workorder $workorder)
    {
        $this->workorder = $workorder;
    }

    public function title(): string
    {
        return 'Workorder Data';
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Camellia Metal Logo');
        $drawing->setPath(public_path('dist/img/CamelliaMetalLogo.png'));
        $drawing->setHeight(50);
        $drawing->setCoordinates('B2');

        return $drawing;
    }

    public function registerEvents(): array
    {
        //
        // Poductions
        //
        $productions    = Production::where('workorder_id',$this->workorder->id)->get();
        $productionCount = 0;
        foreach($productions as $prod)
        {
            $productionCount += $prod->pcs_per_bundle;
        }

        //
        // Smeltings
        //
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

        //
        // Downtimes
        //
        $totalDowntime = 0;
        $wasteDowntime = 0;
        $managementDowntime = 0;
        $downtimes = Downtime::where('status','stop')
                        ->where('workorder_id',$this->workorder->id)
                        ->get();
        $downtimeSummary = Downtime::where('status','run')
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
                
            if($downtimeRemark->is_waste_downtime)
            {
                $wasteDowntime += $durationSec;
            }
            if(!$downtimeRemark->is_waste_downtime)
            {
                $managementDowntime += $durationSec;
            }
            $totalDowntime += $durationSec;
        }
        $total_downtime = 0;
        $waste_downtime = 0;
        $management_downtime = 0;

        // Total Downtime Calculation
        if(($totalDowntime / 60) >=1)
        {
            $total_downtime_min = floor($totalDowntime/60);
            $total_downtime_sec = $totalDowntime - ($total_downtime_min * 60);
            $total_downtime = $total_downtime_min." min ".$total_downtime_sec." sec";
        }
        else{
            $total_downtime = $totalDowntime." sec";
        }

        // Waste Downtime Calculation
        if(($wasteDowntime / 60) >=1)
        {
            $waste_downtime_min = floor($wasteDowntime/60);
            $waste_downtime_sec = $wasteDowntime - ($waste_downtime_min * 60);
            $waste_downtime = $waste_downtime_min." min ".$waste_downtime_sec." sec";
        }
        else{
            $waste_downtime = $wasteDowntime." sec";
        }

        // Management Downtime Calculation
        if(($managementDowntime / 60) >=1)
        {
            $management_downtime_min = floor($managementDowntime/60);
            $management_downtime_sec = $managementDowntime - ($management_downtime_min * 60);
            $management_downtime = $management_downtime_min." min ".$management_downtime_sec." sec";
        }
        else{
            $management_downtime = $managementDowntime." sec";
        }

        // Total Good Product Calculation
        $total_good_product = 0;
        $good_products = Production::select('pcs_per_bundle')->where('workorder_id',$this->workorder->id)->where('bundle_judgement',1)->get();  
        foreach($good_products as $good_pro)
        {
            $total_good_product += $good_pro->pcs_per_bundle;
        }

        // Total Bad Product Calculation
        $total_bad_product = 0;
        $bad_products = Production::select('pcs_per_bundle')->where('workorder_id',$this->workorder->id)->where('bundle_judgement',0)->get();  
        foreach($bad_products as $bad_pro)
        {
            $total_bad_product += $bad_pro->pcs_per_bundle;
        }

        //
        // Performance Calculation
        //
        $per = 0;
        $productionPlanned = ($this->workorder->fg_qty_pcs * $this->workorder->bb_qty_bundle);
        if ($productionCount == 0) {
            $per = 100;
        }else{
            $per = ($productionCount / $productionPlanned)*100;
        }

        //
        // Availability Calculation
        //
        $plannedTime = 100;
        if(is_null($this->workorder->process_end))
        {
            $plannedTime = date_diff(new DateTime($this->workorder->process_start),new DateTime(now()));
            // $plannedTime = $workorder->process_start->date_diff(strtotime(date('Y-m-d H:i:s')));
        }else{
            $plannedTime = date_diff(new DateTime($this->workorder->process_start),new DateTime($this->workorder->process_end));
        }
        $plannedTimeMinutes = $plannedTime->days * 24 * 60;
        $plannedTimeMinutes += $plannedTime->h * 60;
        $plannedTimeMinutes += $plannedTime->i;

        $otr = 0;
        if (floor($wasteDowntime/60) == 0) {
            $otr = 100;
        }
        else{
            $otr = (($plannedTimeMinutes - (floor($wasteDowntime/60))) / $plannedTimeMinutes)*100;
        }

        //
        // Quality Calculation
        //

        $qr = 0;
        if ($productionCount == 0) {
            $qr = 100;
        }else{
            $qr = ($total_good_product / $productionCount)*100;
        }

        //
        // OEE
        //

        $oee = 0;
        $oee = (($per/100) * ($otr/100) * ($qr/100))*100;
        if($oee > 100){
            $oee = 100;
        }

        return [
            AfterSheet::class => function (AfterSheet $event) use ($productionPlanned,
            $plannedTimeMinutes, $productionCount, $total_good_product, $total_bad_product, $per, $otr, $qr,
            $oee, $total_downtime, $waste_downtime, $management_downtime) {
                $event->sheet->getStyle('B5:B33')->getFont()->setBold(true);
                $event->sheet->getStyle('E5:E33')->getFont()->setBold(true);
                

                $event->sheet->getStyle('B5:C5')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('B5:C5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->setCellValue('B5', 'WO Number:');
                $event->sheet->setCellValue('C5', $this->workorder->wo_number);

                //
                // OEE Performance
                //
                $event->sheet->getStyle('B7:C8')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('B7:C8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->setCellValue('B7', 'Production Plan:');
                $event->sheet->setCellValue('C7', $productionPlanned);
                $event->sheet->setCellValue('B8', 'Process duration:');
                $event->sheet->setCellValue('C8', $plannedTimeMinutes);

                $event->sheet->getStyle('B10:C12')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('B10:C12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->setCellValue('B10', 'Total Production:');
                $event->sheet->setCellValue('C10', $productionCount);
                $event->sheet->setCellValue('B11', 'Good:');
                $event->sheet->setCellValue('C11', $total_good_product);
                $event->sheet->setCellValue('B12', 'Not Good:');
                $event->sheet->setCellValue('C12', $total_bad_product);

                $event->sheet->getStyle('E7:F9')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('E7:F9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->setCellValue('E7', 'Performance:');
                $event->sheet->setCellValue('F7', Round($per,2). ' %');
                $event->sheet->setCellValue('E8', 'Availability:');
                $event->sheet->setCellValue('F8', Round($otr,2). ' %');
                $event->sheet->setCellValue('E9', 'Quality:');
                $event->sheet->setCellValue('F9', Round($qr,2). ' %');

                $event->sheet->getStyle('E11:F11')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('E11:F11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->setCellValue('E11', 'OEE:');
                $event->sheet->setCellValue('F11', Round($oee,2). ' %');

                //
                // Downtime
                //
                $event->sheet->getStyle('B14:C16')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('B14:C16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->setCellValue('B14', 'Total Downtime:');
                $event->sheet->setCellValue('C14', $total_downtime);
                $event->sheet->setCellValue('B15', 'Management:');
                $event->sheet->setCellValue('C15', $management_downtime);
                $event->sheet->setCellValue('B16', 'Waste:');
                $event->sheet->setCellValue('C16', $waste_downtime);

                //
                // WO Created By Data
                //
                $event->sheet->getStyle('B18:C21')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('B18:C21')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->setCellValue('B18', 'Created By:');
                $event->sheet->setCellValue('C18', call_user_func(function () {
                        $user = User::where('id', $this->workorder->created_by)->first();
                        if (!$user) {
                            return '';
                        }
                        return $user->name;
                    })
                );
                $event->sheet->setCellValue('B19', 'Created At:');
                $event->sheet->setCellValue('C19', Date('Y-m-d H:i:s', strtotime($this->workorder->created_at)));
                $event->sheet->setCellValue('B20', 'Edited By:');
                $event->sheet->setCellValue('C20', call_user_func(function(){
                    $user = User::where('id',$this->workorder->edited_by)->first();
                    if(!$user)
                    {
                        return '';
                    }
                    return $user->name;
                }));
                $event->sheet->setCellValue('B21', 'Edited At:');
                $event->sheet->setCellValue('C21', call_user_func(function(){
                    $user = User::where('id',$this->workorder->edited_by)->first();
                    if(!$user)
                    {
                        return '';
                    }
                    return Date('Y-m-d H:i:s', strtotime($this->workorder->updated_at));
                }));

                //
                // WO Processed By Data
                //
                $event->sheet->getStyle('E18:F20')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('E18:F20')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->setCellValue('E18', 'Processed By:');
                $event->sheet->setCellValue('F18', call_user_func(function () {
                    $user = User::where('id', $this->workorder->processed_by)->first();
                    if (!$user) {
                        return '';
                    }
                    return $user->name;
                }));
                $event->sheet->setCellValue('E19', 'Start Time:');
                $event->sheet->setCellValue('F19', call_user_func(function () {
                    if (!$this->workorder->process_start) {
                        return '';
                    }
                    return Date('Y-m-d H:i:s', strtotime($this->workorder->process_start));
                }));
                $event->sheet->setCellValue('E20', 'End Time:');
                $event->sheet->setCellValue('F20', call_user_func(function () {
                    if (!$this->workorder->process_end) {
                        return '';
                    }
                    return Date('Y-m-d H:i:s', strtotime($this->workorder->process_end));
                }));

                //
                // Supplier Data
                //
                $event->sheet->getStyle('B23:C28')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('B23:C28')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->setCellValue('B23', 'Supplier:');
                $event->sheet->setCellValue('C23', $this->workorder->bb_supplier);
                $event->sheet->setCellValue('B24', 'Grade:');
                $event->sheet->setCellValue('C24', $this->workorder->bb_grade);
                $event->sheet->setCellValue('B25', 'Diameter:');
                $event->sheet->setCellValue('C25', $this->workorder->bb_diameter . ' mm');
                $event->sheet->setCellValue('B26', 'QTY (Kg):');
                $event->sheet->setCellValue('C26', $this->workorder->bb_qty_pcs . ' KG');
                $event->sheet->setCellValue('B27', 'QTY (Coil):');
                $event->sheet->setCellValue('C27', $this->workorder->bb_qty_coil . ' Coil');
                $event->sheet->setCellValue('B28', 'QTY (Bundle):');
                $event->sheet->setCellValue('C28', $this->workorder->bb_qty_bundle . ' Bundle');

                //
                // Customer Data
                //
                $event->sheet->getStyle('E23:F33')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('E23:F33')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->setCellValue('E23', 'Customer:');
                $event->sheet->setCellValue('F23', $this->workorder->fg_customer);
                $event->sheet->setCellValue('E24', 'Straightness Std:');
                $event->sheet->setCellValue('F24', $this->workorder->straightness_standard . '');
                $event->sheet->setCellValue('E25', 'size:');
                $event->sheet->setCellValue('F25', $this->workorder->fg_size_1 . " mm X " . $this->workorder->fg_size_2 . " mm");
                $event->sheet->setCellValue('E26', 'Tolerance:');
                $event->sheet->setCellValue('F26', '(+'. $this->workorder->tolerance_plus . " mm , " . $this->workorder->tolerance_minus . " mm)");
                $event->sheet->setCellValue('E27', 'Reduction Rate:');
                $event->sheet->setCellValue('F27', $this->workorder->fg_reduction_rate. " %");
                $event->sheet->setCellValue('E28', 'Shape:');
                $event->sheet->setCellValue('F28', $this->workorder->fg_shape);
                $event->sheet->setCellValue('E29', 'QTY (Kg):');
                $event->sheet->setCellValue('F29', $this->workorder->fg_qty_kg . " Kg");
                $event->sheet->setCellValue('E30', 'QTY (Pcs):');
                $event->sheet->setCellValue('F30', $this->workorder->fg_qty_pcs . " Pcs");
                $event->sheet->setCellValue('E31', 'Chamfer:');
                $event->sheet->setCellValue('F31', $this->workorder->chamfer);
                $event->sheet->setCellValue('E32', 'Color:');
                $event->sheet->setCellValue('F32', call_user_func(function(){
                    $color = Color::where('id',$this->workorder->color)->first();
                    return $color->name;
                }));
                $event->sheet->setCellValue('E33', 'Machine:');
                $event->sheet->setCellValue('F33', $this->workorder->machine->name);

                //
                // Remarks
                //
                $event->sheet->getStyle('B30:C30')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('B30:C30')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $event->sheet->setCellValue('B30', 'Remarks:');
                $event->sheet->setCellValue('C30', $this->workorder->remarks);

                //
                // Sheet Properties
                //
                // $event->sheet->getPageSetup()->setCreator('Camellia Metal');
                $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
                $event->sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $event->sheet->getPageSetup()->setFitToWidth(true);
                $event->sheet->getPageMargins()->setTop(1);
                $event->sheet->getPageMargins()->setRight(0.75);
                $event->sheet->getPageMargins()->setLeft(0.75);
                $event->sheet->getPageMargins()->setBottom(1);
                $event->sheet->getPageSetup()->setPrintArea('A2:F33');
                $event->sheet->getColumnDimension('A')->setWidth('3');
                $event->sheet->getColumnDimension('B')->setWidth('30');
                $event->sheet->getColumnDimension('C')->setWidth('30');
                $event->sheet->getColumnDimension('D')->setWidth('3');
                $event->sheet->getColumnDimension('E')->setWidth('20');
                $event->sheet->getColumnDimension('F')->setWidth('30');

                $event->sheet->getStyle('B5:F33')->getAlignment()->setWrapText(true);
            }
        ];
    }
}
