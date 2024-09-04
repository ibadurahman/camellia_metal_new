<?php

namespace App\Http\Controllers\Operator;

use PDF;
use App\Models\Workorder;
use Illuminate\Http\Request;
use App\Models\WorkorderHasTpm;
use App\Http\Controllers\Controller;

class WorkorderHasTpmController extends Controller
{
    public function store(Request $request, Workorder $workorder){
        if($request->method() != 'POST'){
            return redirect()->back()->with('error','Method not allowed')->withInput();
        }

        $request->validate([
            'kode_dies_awal' => 'required',
            'diameter_dies_awal' => 'required',
            'diameter_aktual_setelah_dies_awal' => 'required',
            'diameter_aktual_setelah_polishing_awal' => 'required',
            'visual_barang_awal' => 'required',
            'kelurusan_awal' => 'required',
        ],[
            'kode_dies_awal.required' => 'Kode Dies Awal is required',
            'diameter_dies_awal.required' => 'Diameter Dies Awal is required',
            'diameter_aktual_setelah_dies_awal.required' => 'Diameter Aktual Setelah Dies Awal is required',
            'diameter_aktual_setelah_polishing_awal.required' => 'Diameter Aktual Setelah Polishing Awal is required',
            'visual_barang_awal.required' => 'Visual Barang Awal is required',
            'kelurusan_awal.required' => 'Kelurusan Awal is required',
        ]);

        if($workorder->workorderHasTpm){
            $workorderHasTpm = $workorder->workorderHasTpm;

        }else{
            $workorderHasTpm = new WorkorderHasTpm();
            $workorderHasTpm->workorder_id = $workorder->id;
            $workorderHasTpm->machine_id = $workorder->machine->id;
            $workorderHasTpm->created_by = auth()->id();
        }
        $workorderHasTpm->diameter = floatval($workorder->fg_size_1 ?? 0);
        $workorderHasTpm->grade = $workorder->bb_grade;
        $workorderHasTpm->panjang = floatval($workorder->fg_size_2 ?? 0);
        $workorderHasTpm->tanggal = $workorder->process_start;
        $workorderHasTpm->kode_dies_awal = $request->kode_dies_awal;
        $workorderHasTpm->kode_dies_akhir = $request->kode_dies_akhir;
        $workorderHasTpm->diameter_dies_awal = $request->diameter_dies_awal;
        $workorderHasTpm->diameter_dies_akhir = $request->diameter_dies_akhir;
        $workorderHasTpm->diameter_aktual_setelah_dies_awal = $request->diameter_aktual_setelah_dies_awal;
        $workorderHasTpm->diameter_aktual_setelah_dies_akhir = $request->diameter_aktual_setelah_dies_akhir;
        $workorderHasTpm->diameter_aktual_setelah_polishing_awal = $request->diameter_aktual_setelah_polishing_awal;
        $workorderHasTpm->diameter_aktual_setelah_polishing_akhir = $request->diameter_aktual_setelah_polishing_akhir;
        $workorderHasTpm->visual_barang_awal = $request->visual_barang_awal;
        $workorderHasTpm->visual_barang_akhir = $request->visual_barang_akhir;
        $workorderHasTpm->kelurusan_awal = $request->kelurusan_awal;
        $workorderHasTpm->kelurusan_akhir = $request->kelurusan_akhir;
        $workorderHasTpm->pre_straightening_putaran_roller_berputar = $request->pre_straightening_putaran_roller_berputar;
        $workorderHasTpm->pre_straightening_kondisi_produk_tidak_keluar_jalur = $request->pre_straightening_kondisi_produk_tidak_keluar_jalur;
        $workorderHasTpm->ampere_impeller_1 = $request->ampere_impeller_1;
        $workorderHasTpm->ampere_impeller_2 = $request->ampere_impeller_2;
        $workorderHasTpm->ampere_impeller_3 = $request->ampere_impeller_3;
        $workorderHasTpm->ampere_impeller_4 = $request->ampere_impeller_4;
        $workorderHasTpm->speed_motor = $request->speed_motor;
        $workorderHasTpm->ukuran_slide = $request->ukuran_slide;
        $workorderHasTpm->kondisi_pelumas = $request->kondisi_pelumas;
        $workorderHasTpm->straightening_putaran_roller_berputar = $request->straightening_putaran_roller_berputar;
        $workorderHasTpm->straightening_kondisi_produk_tidak_keluar_jalur = $request->straightening_kondisi_produk_tidak_keluar_jalur;
        $workorderHasTpm->cutting_panjang = $request->cutting_panjang;
        $workorderHasTpm->ukuran_dies_cutting_in = $request->ukuran_dies_cutting_in;
        $workorderHasTpm->ukuran_dies_cutting_out = $request->ukuran_dies_cutting_out;
        $workorderHasTpm->ukuran_dies_cutting_out_cutter_5 = $request->ukuran_dies_cutting_out_cutter_5;
        $workorderHasTpm->ukuran_dies_cutting_out_cutter_6 = $request->ukuran_dies_cutting_out_cutter_6;
        $workorderHasTpm->ukuran_dies_cutting_out_cutter_7 = $request->ukuran_dies_cutting_out_cutter_7;
        $workorderHasTpm->ukuran_dies_cutting_out_cutter_9 = $request->ukuran_dies_cutting_out_cutter_9;
        $workorderHasTpm->polishing_tidak_cacat = $request->polishing_tidak_cacat;
        $workorderHasTpm->polishing_ukuran_plat_kuningan = $request->polishing_ukuran_plat_kuningan;
        $workorderHasTpm->polishing_ampere_motor = $request->polishing_ampere_motor;
        $workorderHasTpm->polishing_ampere_motor_s2b = $request->polishing_ampere_motor_s2b;
        $workorderHasTpm->polishing_kondisi_pelumas_lancar = $request->polishing_kondisi_pelumas_lancar;
        $workorderHasTpm->polishing_penutup_oli_tertutup = $request->polishing_penutup_oli_tertutup;
        $workorderHasTpm->hasil_setting = $request->hasil_setting;
        $workorderHasTpm->quality_control = $request->quality_control;
        $workorderHasTpm->catatan = $request->catatan;
        $workorderHasTpm->checked_by = $request->checked_by;
        $workorderHasTpm->save();

        return redirect()->back()->with('success','Data has been saved');
    }

    public function approve(Request $request, Workorder $workorder){
        if($request->method() != 'POST'){
            return redirect()->back()->with('error','Method not allowed')->withInput();
        }

        if($workorder->workorderHasTpm){
            $workorderHasTpm = $workorder->workorderHasTpm;
            $workorderHasTpm->approved_by = auth()->id();
            $workorderHasTpm->save();
        }

        return redirect()->back()->with('success','Data has been approved');
    }

    public function printToPdf(Workorder $workorder){
        $data = [
            'workorder'         => $workorder,
            'workorderHasTpm'   => $workorder->workorderHasTpm,
        ];

        $pdf = Pdf::loadView('user.pdf.tpm', $data);
        $pdf->setPaper('A4', 'potrait');
        $pdf->setOptions([
            'margin-top' => '1mm',
            'margin-bottom' => '1mm',
        ]);
        $pdf->render();

        return $pdf->stream($workorder->wo_number . '.pdf', array("Attachment" => false));
    }
}
