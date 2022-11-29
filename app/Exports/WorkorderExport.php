<?php

namespace App\Exports;

use App\Models\Downtime;
use App\Models\Workorder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use App\Http\Resources\WorkorderReport\WorkorderReportCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;

class WorkorderExport implements WithMultipleSheets
{
    protected $workorder;

    public function __construct(Workorder $workorder)
    {
        $this->workorder = $workorder;
    }

    public function sheets(): array
    {
        $sheets = [
            'Workorder'         => new WorkorderDataSheet($this->workorder),
            'Production'        => new ProductionDataSheet($this->workorder),
            'Downtime Record'   => new DowntimeDataSheet($this->workorder),
            // 'Speed Record'      => new SpeedDataSheet($this->workorder),
        ];

        return $sheets;
        
    }
}
