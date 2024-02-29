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

    // public function downloadStatus(Request $request)
    // {
    //     $workorder = Workorder::query()->orderBy('created_at', 'DESC');
    //     if ($request->machine_id != "0") {
    //         $workorder = $workorder->where('machine_id', $request->machine_id);
    //     }
    //     if ($request->status != '') {
    //         $workorder = $workorder->where('status_wo', $request->status);
    //     }
    //     if ($request->report_date_1 != '') {
    //         $workorder = $workorder->where('process_start', '>=', "$request->report_date_1" . ' 00:00:00');
    //     }
    //     if ($request->report_date_2 != '') {
    //         $workorder = $workorder->where('process_start', '<=', "$request->report_date_2" . ' 23:59:59');
    //     }
    //     if ($request->wo_number != '') {
    //         $workorder = $workorder->where('wo_number', 'like', '%' . $request->wo_number . '%');
    //     }
    //     $workorders = $workorder->get();  

    //     $fileLocation = public_path('temp/batch/');
    //     $status = [
    //         'total_wo' => $workorders->count(),
    //         'total_generated' => count(glob($fileLocation."*.xlsx")),
    //     ];

    //     return response()->json([
    //         'success' => true,
    //         'status' => $status
    //     ]);
    // }

    public function batchDownload(Request $request)
    {
        $workorder = Workorder::query()->orderBy('created_at', 'DESC');
        if ($request->machine_id != "0") {
            $workorder = $workorder->where('machine_id', $request->machine_id);
        }
        if ($request->status != '') {
            $workorder = $workorder->where('status_wo', $request->status);
        }
        if ($request->report_date_1 != '') {
            $workorder = $workorder->where('process_start', '>=', "$request->report_date_1" . ' 00:00:00');
        }
        if ($request->report_date_2 != '') {
            $workorder = $workorder->where('process_start', '<=', "$request->report_date_2" . ' 23:59:59');
        }
        if ($request->wo_number != '') {
            $workorder = $workorder->where('wo_number', 'like', '%' . $request->wo_number . '%');
        }
        $workorders = $workorder->get();  

        if(!is_dir(public_path('temp/batch'))){
            mkdir(public_path('temp/batch'), 0777, true);
        }

        //delete all files in temp/batch
        $files = glob(public_path('temp/batch/*'));
        foreach($files as $file){
            if(is_file($file))
            unlink($file);
        }

        foreach ($workorders as $workorder) {
            $this->excel->store(new WorkorderExport($workorder), str_replace('/','',$workorder->wo_number).'.xlsx', 'public_temp_batch_download' );
        }

        $zip = new \ZipArchive();
        $filename = 'workorder_batch_download_'. time() .'.zip';

        if($zip->open(public_path('temp/batch/'.$filename), \ZipArchive::CREATE) === TRUE){
            $files = glob(public_path('temp/batch/*'));
            foreach($files as $file){
                if(is_file($file)){
                    $zip->addFile($file, basename($file));
                }
            }
            $zip->close();
        }

        //delete all files in temp/batch except the zip file
        $files = glob(public_path('temp/batch/*'));
        foreach($files as $file){
            if(is_file($file) && $file != public_path('temp/batch/'.$filename))
            unlink($file);
        }

        return response()->json([
            'success' => true,
            'filename' => $filename
        ]);
    }

    public function downloadFile($filename)
    {
        $file_path = public_path('temp/batch/'.$filename);
        return response()->download($file_path);
    }
}
