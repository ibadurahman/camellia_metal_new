<?php

namespace App\Exports;

use DateTime;
use App\Models\Downtime;
use App\Models\Workorder;
use App\Models\DowntimeRemark;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\FromCollection;

class DowntimeDataSheet implements WithTitle, WithEvents
{
    public function __construct(Workorder $workorder)
    {
        $this->workorder = $workorder;
    }

    public function title(): string
    {
        return 'Downtime Record';
    }

    public function registerEvents(): array
    {
        $downtimes = Downtime::where('workorder_id',$this->workorder->id)->where('status','stop')->get();
        return [
            AfterSheet::class => function(AfterSheet $event) use ($downtimes){
                $event->sheet->setCellValue('B2','No.');
                $event->sheet->setCellValue('C2','Start');
                $event->sheet->setCellValue('D2','End');
                $event->sheet->setCellValue('E2','Duration');
                $event->sheet->setCellValue('F2','Reason');
                $event->sheet->setCellValue('G2','Remarks');
                $event->sheet->getStyle('B2:G2')->getFont()->setBold(true);
                $event->sheet->getStyle('B2:G2')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $event->sheet->getStyle('B2:G2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $j = 3; $k = 1;
                for ($i=0; $i < count($downtimes); $i++) { 
                    $startTime = Date('Y-m-d H:i:s',strtotime($downtimes[$i]->created_at));
                    $dtEnd = Downtime::where('downtime_number',$downtimes[$i]->downtime_number)->where('status','run')->first();
                    if(!$dtEnd)
                    {
                        $endTime = '';
                        $total_duration = '';
                    }else{
                        $endTime = Date('Y-m-d H:i:s',strtotime($dtEnd->created_at));
                        $duration = date_diff(new DateTime($startTime),new DateTime($endTime));
                        $durationSeconds = $duration->days * 24 * 60 * 60;
                        $durationSeconds += $duration->h * 60 * 60;
                        $durationSeconds += $duration->i * 60;
                        $durationSeconds += $duration->s;
                        if(($durationSeconds / 60) >=1)
                        {
                            $duration_min = floor($durationSeconds/60);
                            $duration_sec = $durationSeconds - ($duration_min * 60);
                            $total_duration = $duration_min." min ".$duration_sec." sec";
                        }
                        else{
                            $total_duration = $durationSeconds." sec";
                        }
                    }
                    
                    $remark = DowntimeRemark::where('downtime_id',$downtimes[$i]->id)->first();
                    if(!$remark){
                        $reason = '';
                        $remarks = '';
                    }
                    else if ($remark->is_waste_downtime) {
                        $reason = 'Waste';
                        $reason .= ' | '. $remark->downtime_reason;
                        $remarks = $remark->remarks;
                    }
                    else{
                        $reason = 'Management';
                        $reason .= ' | '. $remark->downtime_reason;
                        $remarks = $remark->remarks;
                    }

                    $event->sheet->setCellValue('B'.$j,$k);
                    $event->sheet->setCellValue('C'.$j,$startTime);
                    $event->sheet->setCellValue('D'.$j,$endTime);
                    $event->sheet->setCellValue('E'.$j,$total_duration);
                    $event->sheet->setCellValue('F'.$j,$reason);
                    $event->sheet->setCellValue('G'.$j,$remarks);

                    $j++; $k++;
                }

                //
                // Sheet Properties
                //
                $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
                $event->sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $event->sheet->getPageSetup()->setFitToWidth(true);
                $event->sheet->getPageMargins()->setTop(1);
                $event->sheet->getPageMargins()->setRight(0.75);
                $event->sheet->getPageMargins()->setLeft(0.75);
                $event->sheet->getPageMargins()->setBottom(1);
                $event->sheet->getPageSetup()->setPrintArea('A2:G'.$j);
                $event->sheet->getColumnDimension('A')->setWidth('3');
                $event->sheet->getColumnDimension('B')->setWidth('5');
                $event->sheet->getColumnDimension('C')->setWidth('20');
                $event->sheet->getColumnDimension('D')->setWidth('20');
                $event->sheet->getColumnDimension('E')->setWidth('20');
                $event->sheet->getColumnDimension('F')->setWidth('20');
                $event->sheet->getColumnDimension('G')->setWidth('20');
                $event->sheet->getStyle('B3:B'.$j)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('B3:G'.$j)->getAlignment()->setWrapText(true);
            }
        ];
    }
}
