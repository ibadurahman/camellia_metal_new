<?php

namespace App\Http\Controllers;

use App\Models\Workorder;
use Illuminate\Http\Request;
use App\Exports\WorkorderExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;

class WorkorderReportController extends Controller
{
    //
    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function export(Workorder $workorder)
    {
        $workorderExplode = explode('/',$workorder->wo_number);
        $workorderName = '';
        foreach ($workorderExplode as $wo) {
            $workorderName .= $wo;
        }
        return $this->excel->download(new WorkorderExport($workorder), $workorderName.'.xlsx');
    }
}
