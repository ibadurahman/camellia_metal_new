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
            'diameter_dies_awal' => 'required | numeric',
            'diameter_aktual_setelah_dies_awal' => 'required | numeric',
            'diameter_aktual_setelah_polishing_awal' => 'required | numeric',
            'kode_dies_akhir' => 'required',
            'diameter_dies_akhir' => 'required | numeric',
            'diameter_aktual_setelah_dies_akhir' => 'required | numeric',
            'diameter_aktual_setelah_polishing_akhir' => 'required | numeric',
            'visual_barang_awal' => 'required',
            'kelurusan_awal' => 'required',
            'visual_barang_akhir' => 'required',
            'kelurusan_akhir' => 'required',
            'pre_straightening_putaran_roller_berputar'=> 'required',
            'pre_straightening_kondisi_produk_tidak_keluar_jalur'=> 'required',
            'ampere_impeller_1' => 'required | numeric',
            'ampere_impeller_2' => 'required | numeric',
            'ampere_impeller_3' => 'required | numeric',
            'ampere_impeller_4' => 'required | numeric',
            'speed_motor' => 'required | numeric',
            'ukuran_slide' => 'required | numeric',
            'kondisi_pelumas' => 'required',
            'straightening_putaran_roller_berputar' => 'required',
            'straightening_kondisi_produk_tidak_keluar_jalur' => 'required',
            'cutting_panjang' => 'required | numeric',
            'ukuran_dies_cutting_in' => 'required | numeric',
            'ukuran_dies_cutting_out' => 'numeric',
            'ukuran_dies_cutting_out_cutter_5' => 'numeric',
            'ukuran_dies_cutting_out_cutter_6' => 'numeric',
            'ukuran_dies_cutting_out_cutter_7' => 'numeric',
            'ukuran_dies_cutting_out_cutter_9' => 'numeric',
            'polishing_tidak_cacat' => 'required',
            'polishing_ukuran_plat_kuningan' => 'required',
            'polishing_ampere_motor' => 'numeric',
            'polishing_ampere_motor_s2b' => 'numeric',
            'polishing_kondisi_pelumas_lancar'  => 'required',
            'polishing_penutup_oli_tertutup'    => 'required',
            'hasil_setting' => 'required',
        ],[
            'kode_dies_awal.required' => 'Kode Dies Awal is required',
            'diameter_dies_awal.required' => 'Diameter Dies Awal is required',
            'diameter_dies_awal.numeric' => 'Diameter Dies Awal must be a number',
            'diameter_aktual_setelah_dies_awal.required' => 'Diameter Aktual Setelah Dies Awal is required',
            'diameter_aktual_setelah_dies_awal.numeric' => 'Diameter Aktual Setelah Dies Awal must be a number',
            'diameter_aktual_setelah_polishing_awal.required' => 'Diameter Aktual Setelah Polishing Awal is required',
            'diameter_aktual_setelah_polishing_awal.numeric' => 'Diameter Aktual Setelah Polishing Awal must be a number',
            'kode_dies_akhir.required' => 'Kode Dies Akhir is required',
            'diameter_dies_akhir.required' => 'Diameter Dies Akhir is required',
            'diameter_dies_akhir.numeric' => 'Diameter Dies Akhir must be a number',
            'diameter_aktual_setelah_dies_akhir.required' => 'Diameter Aktual Setelah Dies Akhir is required',
            'diameter_aktual_setelah_dies_akhir.numeric' => 'Diameter Aktual Setelah Dies Akhir must be a number',
            'diameter_aktual_setelah_polishing_akhir.required' => 'Diameter Aktual Setelah Polishing Akhir is required',
            'diameter_aktual_setelah_polishing_akhir.numeric' => 'Diameter Aktual Setelah Polishing Akhir must be a number',
            'visual_barang_awal.required' => 'Visual Barang Awal is required',
            'kelurusan_awal.required' => 'Kelurusan Awal is required',
            'visual_barang_akhir.required' => 'Visual Barang Akhir is required',
            'kelurusan_akhir.required' => 'Kelurusan Akhir is required',
            'pre_straightening_putaran_roller_berputar.required' => 'Pre Straightening Putaran Roller Berputar is required',
            'pre_straightening_kondisi_produk_tidak_keluar_jalur.required' => 'Pre Straightening Kondisi Produk Tidak Keluar Jalur is required',
            'ampere_impeller_1.required' => 'Ampere Impeller 1 is required',
            'ampere_impeller_1.numeric' => 'Ampere Impeller 1 must be a number',
            'ampere_impeller_2.required' => 'Ampere Impeller 2 is required',
            'ampere_impeller_2.numeric' => 'Ampere Impeller 2 must be a number',
            'ampere_impeller_3.required' => 'Ampere Impeller 3 is required',
            'ampere_impeller_3.numeric' => 'Ampere Impeller 3 must be a number',
            'ampere_impeller_4.required' => 'Ampere Impeller 4 is required',
            'ampere_impeller_4.numeric' => 'Ampere Impeller 4 must be a number',
            'speed_motor.required' => 'Speed Motor is required',
            'speed_motor.numeric' => 'Speed Motor must be a number',
            'ukuran_slide.required' => 'Ukuran Slide is required',
            'ukuran_slide.numeric' => 'Ukuran Slide must be a number',
            'kondisi_pelumas.required' => 'Kondisi Pelumas is required',
            'straightening_putaran_roller_berputar.required' => 'Straightening Putaran Roller Berputar is required',
            'straightening_kondisi_produk_tidak_keluar_jalur.required' => 'Straightening Kondisi Produk Tidak Keluar Jalur is required',
            'cutting_panjang.required' => 'Cutting Panjang is required',
            'cutting_panjang.numeric' => 'Cutting Panjang must be a number',
            'ukuran_dies_cutting_in.required' => 'Ukuran Dies Cutting In is required',
            'ukuran_dies_cutting_in.numeric' => 'Ukuran Dies Cutting In must be a number',
            'ukuran_dies_cutting_out.numeric' => 'Ukuran Dies Cutting Out must be a number',
            'ukuran_dies_cutting_out_cutter_5.numeric' => 'Ukuran Dies Cutting Out Cutter 5 must be a number',
            'ukuran_dies_cutting_out_cutter_6.numeric' => 'Ukuran Dies Cutting Out Cutter 6 must be a number',
            'ukuran_dies_cutting_out_cutter_7.numeric' => 'Ukuran Dies Cutting Out Cutter 7 must be a number',
            'ukuran_dies_cutting_out_cutter_9.numeric' => 'Ukuran Dies Cutting Out Cutter 9 must be a number',
            'polishing_tidak_cacat.required' => 'Polishing Tidak Cacat is required',
            'polishing_ukuran_plat_kuningan.required' => 'Polishing Ukuran Plat Kuningan is required',
            'polishing_ampere_motor.numeric' => 'Polishing Ampere Motor must be a number',
            'polishing_ampere_motor_s2b.numeric' => 'Polishing Ampere Motor S2B must be a number',
            'polishing_kondisi_pelumas_lancar.required' => 'Polishing Kondisi Pelumas Lancar is required',
            'polishing_penutup_oli_tertutup.required' => 'Polishing Penutup Oli Tertutup is required',
            'hasil_setting.required' => 'Hasil Setting is required',
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
        $workorderHasTpm->diameter_dies_awal = floatval($request->diameter_dies_awal ?? 0);
        $workorderHasTpm->diameter_dies_akhir = floatval($request->diameter_dies_akhir ?? 0);
        $workorderHasTpm->diameter_aktual_setelah_dies_awal = floatval($request->diameter_aktual_setelah_dies_awal ?? 0);
        $workorderHasTpm->diameter_aktual_setelah_dies_akhir = floatval($request->diameter_aktual_setelah_dies_akhir ?? 0);
        $workorderHasTpm->diameter_aktual_setelah_polishing_awal = floatval($request->diameter_aktual_setelah_polishing_awal ?? 0);
        $workorderHasTpm->diameter_aktual_setelah_polishing_akhir = floatval($request->diameter_aktual_setelah_polishing_akhir ?? 0);
        $workorderHasTpm->visual_barang_awal = $request->visual_barang_awal;
        $workorderHasTpm->visual_barang_akhir = $request->visual_barang_akhir;
        $workorderHasTpm->kelurusan_awal = $request->kelurusan_awal;
        $workorderHasTpm->kelurusan_akhir = $request->kelurusan_akhir;
        $workorderHasTpm->pre_straightening_putaran_roller_berputar = $request->pre_straightening_putaran_roller_berputar;
        $workorderHasTpm->pre_straightening_kondisi_produk_tidak_keluar_jalur = $request->pre_straightening_kondisi_produk_tidak_keluar_jalur;
        $workorderHasTpm->ampere_impeller_1 = floatval($request->ampere_impeller_1 ?? 0);
        $workorderHasTpm->ampere_impeller_2 = floatval($request->ampere_impeller_2 ?? 0);
        $workorderHasTpm->ampere_impeller_3 = floatval($request->ampere_impeller_3 ?? 0);
        $workorderHasTpm->ampere_impeller_4 = floatval($request->ampere_impeller_4 ?? 0);
        $workorderHasTpm->speed_motor = floatval($request->speed_motor ?? 0);
        $workorderHasTpm->ukuran_slide = floatval($request->ukuran_slide ?? 0);
        $workorderHasTpm->kondisi_pelumas = $request->kondisi_pelumas;
        $workorderHasTpm->straightening_putaran_roller_berputar = $request->straightening_putaran_roller_berputar;
        $workorderHasTpm->straightening_kondisi_produk_tidak_keluar_jalur = $request->straightening_kondisi_produk_tidak_keluar_jalur;
        $workorderHasTpm->cutting_panjang = floatval($request->cutting_panjang ?? 0);
        $workorderHasTpm->ukuran_dies_cutting_in = floatval($request->ukuran_dies_cutting_in ?? 0);
        $workorderHasTpm->ukuran_dies_cutting_out = floatval($request->ukuran_dies_cutting_out ?? 0);
        $workorderHasTpm->ukuran_dies_cutting_out_cutter_5 = floatval($request->ukuran_dies_cutting_out_cutter_5 ?? 0);
        $workorderHasTpm->ukuran_dies_cutting_out_cutter_6 = floatval($request->ukuran_dies_cutting_out_cutter_6 ?? 0);
        $workorderHasTpm->ukuran_dies_cutting_out_cutter_7 = floatval($request->ukuran_dies_cutting_out_cutter_7 ?? 0);
        $workorderHasTpm->ukuran_dies_cutting_out_cutter_9 = floatval($request->ukuran_dies_cutting_out_cutter_9 ?? 0);
        $workorderHasTpm->polishing_tidak_cacat = $request->polishing_tidak_cacat;
        $workorderHasTpm->polishing_ukuran_plat_kuningan = floatval($request->polishing_ukuran_plat_kuningan ?? 0);
        $workorderHasTpm->polishing_ampere_motor = floatval($request->polishing_ampere_motor ?? 0);
        $workorderHasTpm->polishing_ampere_motor_s2b = floatval($request->polishing_ampere_motor_s2b ?? 0);
        $workorderHasTpm->polishing_kondisi_pelumas_lancar = $request->polishing_kondisi_pelumas_lancar;
        $workorderHasTpm->polishing_penutup_oli_tertutup = $request->polishing_penutup_oli_tertutup;
        $workorderHasTpm->hasil_setting = $request->hasil_setting;
        $workorderHasTpm->catatan = $request->catatan;
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
        $pdf->render();

        return $pdf->stream($workorder->wo_number . '.pdf', array("Attachment" => false));
    }
}
