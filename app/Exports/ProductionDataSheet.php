<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Smelting;
use App\Models\Workorder;
use App\Models\Production;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductionDataSheet implements ShouldAutoSize, WithTitle, WithEvents
{
    public function __construct(Workorder $workorder)
    {
        $this->workorder = $workorder;
    }

    public function title(): string
    {
        return 'Production Report';
    }

    public function registerEvents(): array
    {
        $outsideBorder = [
            'borders' => [
                'outline'   => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ]
            ]
        ];

        $productions = Production::where('workorder_id',$this->workorder->id)->get();

        return [
            AfterSheet::class => function (AfterSheet $event) use ($outsideBorder, $productions) {
                $j = 0;
                $l = 0;
                for ($i=0; $i < count($productions); $i++) {
                    $j = $j + 2;
                    $k = $j;
                    $event->sheet->setCellValue('B'.$j, 'Bundle No:');
                    $event->sheet->setCellValue('C'.$j, $productions[$i]->bundle_num);
                    $event->sheet->getStyle('B'.$k.':C'.$j)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

                    $j = $j + 2;
                    $event->sheet->setCellValue('B'.$j, 'Coil No:');
                    $event->sheet->setCellValue('C'.$j, call_user_func(function() use ($productions,$i){
                        $leburan = Smelting::where('id',$productions[$i]->coil_num)->first();
                        return $leburan->coil_num;
                    }));
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Coil Weight:');
                    $event->sheet->setCellValue('C'.$j, call_user_func(function() use ($productions,$i){
                        $leburan = Smelting::where('id',$productions[$i]->coil_num)->first();
                        return $leburan->weight;
                    }));
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'No. Leburan:');
                    $event->sheet->setCellValue('C'.$j, call_user_func(function() use ($productions,$i){
                        $leburan = Smelting::where('id',$productions[$i]->coil_num)->first();
                        return $leburan->smelting_num;
                    }));
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Area:');
                    $event->sheet->setCellValue('C'.$j, call_user_func(function() use ($productions,$i){
                        $leburan = Smelting::where('id',$productions[$i]->coil_num)->first();
                        return $leburan->area;
                    }));

                    $j = $j + 2;
                    $event->sheet->setCellValue('B'.$j, 'Dies Number:');
                    $event->sheet->setCellValue('C'.$j, $productions[$i]->dies_num);
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Diameter Ujung:');
                    $event->sheet->setCellValue('C'.$j, $productions[$i]->diameter_ujung . ' mm');
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Diameter Tengah:');
                    $event->sheet->setCellValue('C'.$j, $productions[$i]->diameter_tengah . ' mm');
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Diameter Ekor:');
                    $event->sheet->setCellValue('C'.$j, $productions[$i]->diameter_ekor . ' mm');
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Kelurusan Aktual:');
                    $event->sheet->setCellValue('C'.$j, $productions[$i]->kelurusan_aktual);
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Panjang Aktual:');
                    $event->sheet->setCellValue('C'.$j, $productions[$i]->panjang_aktual . ' mm');
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Berat FG:');
                    $event->sheet->setCellValue('C'.$j, $productions[$i]->berat_fg . ' Kg');
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'QTY (Pcs):');
                    $event->sheet->setCellValue('C'.$j, $productions[$i]->pcs_per_bundle . ' Pcs');
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Judgement:');
                    $event->sheet->setCellValue('C'.$j, call_user_func(function() use($productions,$i)
                    {
                        if($productions[$i]->bundle_judgement){
                            return 'GOOD';
                        }
                        return 'NOT GOOD';
                    }));
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Visual:');
                    $event->sheet->setCellValue('C'.$j, $productions[$i]->visual);

                    $j = $j + 2;
                    $event->sheet->setCellValue('B'.$j, 'Created By:');
                    $event->sheet->setCellValue('C'.$j, call_user_func(function() use($productions, $i)
                    {
                        $user = User::where('id',$productions[$i]->created_by)->first();
                        if(!$user)
                        {
                            return '';
                        }
                        return $user->name;
                    }));
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Created At:');
                    $event->sheet->setCellValue('C'.$j, Date('Y-m-d H:i:s',strtotime($productions[$i]->created_at)));
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Edited By:');
                    $event->sheet->setCellValue('C'.$j, call_user_func(function() use($productions, $i)
                    {
                        $user = User::where('id',$productions[$i]->edited_by)->first();
                        if(!$user)
                        {
                            return '';
                        }
                        return $user->name;
                    }));
                    $j++;
                    $event->sheet->setCellValue('B'.$j, 'Edited At:');
                    $event->sheet->setCellValue('C'.$j, call_user_func(function() use($productions, $i)
                    {
                        $user = User::where('id',$productions[$i]->edited_by)->first();
                        if(!$user)
                        {
                            return '';
                        }
                        return Date('Y-m-d H:i:s',strtotime($productions[$i]->updated_at));
                    }));
                    $event->sheet->getStyle('B'.$k.':C'.$j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $event->sheet->getStyle('B'.$k.':B'.$j)->getFont()->setBold(true);

                    //
                    // Column 2
                    //
                    $l = $l + 2;
                    $m = $l;
                    $i++;
                    if($i >= count($productions))
                    {
                        continue;
                    }
                    $event->sheet->setCellValue('E'.$l, 'Bundle No:');
                    $event->sheet->setCellValue('F'.$l, $productions[$i]->bundle_num);
                    $event->sheet->getStyle('E'.$m.':F'.$l)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

                    $l = $l + 2;
                    $event->sheet->setCellValue('E'.$l, 'Coil No:');
                    $event->sheet->setCellValue('F'.$l, call_user_func(function() use ($productions,$i){
                        $leburan = Smelting::where('id', $productions[$i]->coil_num)->first();
                        return $leburan->coil_num;
                    }));
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Coil Weight:');
                    $event->sheet->setCellValue('F'.$l, call_user_func(function() use ($productions,$i){
                        $leburan = Smelting::where('id',$productions[$i]->coil_num)->first();
                        return $leburan->weight;
                    }));
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'No. Leburan:');
                    $event->sheet->setCellValue('F'.$l, call_user_func(function() use ($productions,$i){
                        $leburan = Smelting::where('id',$productions[$i]->coil_num)->first();
                        return $leburan->smelting_num;
                    }));
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Area:');
                    $event->sheet->setCellValue('F'.$l, call_user_func(function() use ($productions,$i){
                        $leburan = Smelting::where('id',$productions[$i]->coil_num)->first();
                        return $leburan->area;
                    }));

                    $l = $l + 2;
                    $event->sheet->setCellValue('E'.$l, 'Dies Number:');
                    $event->sheet->setCellValue('F'.$l, $productions[$i]->dies_num);
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Diameter Ujung:');
                    $event->sheet->setCellValue('F'.$l, $productions[$i]->diameter_ujung . ' mm');
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Diameter Tengah:');
                    $event->sheet->setCellValue('F'.$l, $productions[$i]->diameter_tengah . ' mm');
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Diameter Ekor:');
                    $event->sheet->setCellValue('F'.$l, $productions[$i]->diameter_ekor . ' mm');
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Kelurusan Aktual:');
                    $event->sheet->setCellValue('F'.$l, $productions[$i]->kelurusan_aktual);
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Panjang Aktual:');
                    $event->sheet->setCellValue('F'.$l, $productions[$i]->panjang_aktual . ' mm');
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Berat FG:');
                    $event->sheet->setCellValue('F'.$l, $productions[$i]->berat_fg . ' Kg');
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'QTY (Pcs):');
                    $event->sheet->setCellValue('F'.$l, $productions[$i]->pcs_per_bundle . ' Pcs');
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Judgement:');
                    $event->sheet->setCellValue('F'.$l, call_user_func(function() use($productions,$i)
                    {
                        if($productions[$i]->bundle_judgement){
                            return 'GOOD';
                        }
                        return 'NOT GOOD';
                    }));
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Visual:');
                    $event->sheet->setCellValue('F'.$l, $productions[$i]->visual);

                    $l = $l + 2;
                    $event->sheet->setCellValue('E'.$l, 'Created By:');
                    $event->sheet->setCellValue('F'.$l, call_user_func(function() use($productions, $i)
                    {
                        $user = User::where('id',$productions[$i]->created_by)->first();
                        if(!$user)
                        {
                            return '';
                        }
                        return $user->name;
                    }));
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Created At:');
                    $event->sheet->setCellValue('F'.$l, Date('Y-m-d H:i:s',strtotime($productions[$i]->created_at)));
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Edited By:');
                    $event->sheet->setCellValue('F'.$l, call_user_func(function() use($productions, $i)
                    {
                        $user = User::where('id',$productions[$i]->edited_by)->first();
                        if(!$user)
                        {
                            return '';
                        }
                        return $user->name;
                    }));
                    $l++;
                    $event->sheet->setCellValue('E'.$l, 'Edited At:');
                    $event->sheet->setCellValue('F'.$l, Date('Y-m-d H:i:s',strtotime($productions[$i]->updated_at)));

                    $event->sheet->getStyle('E'.$m.':F'.$l)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $event->sheet->getStyle('E'.$m.':E'.$l)->getFont()->setBold(true);
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
                $event->sheet->getPageSetup()->setPrintArea('A2:F'.$l);
                $event->sheet->getColumnDimension('A')->setWidth('3');
                $event->sheet->getColumnDimension('B')->setWidth('20');
                $event->sheet->getColumnDimension('C')->setWidth('20');
                $event->sheet->getColumnDimension('D')->setWidth('3');
                $event->sheet->getColumnDimension('E')->setWidth('20');
                $event->sheet->getColumnDimension('F')->setWidth('20');

                $event->sheet->getStyle('B5:F'.$l)->getAlignment()->setWrapText(true);
            }
        ];
    }
}
