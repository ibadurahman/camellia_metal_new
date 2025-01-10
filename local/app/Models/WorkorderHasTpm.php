<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\CustomHelpers;

class WorkorderHasTpm extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function workorder(){
        return $this->belongsTo(Workorder::class);
    }

    public static function isTPMCompleted($workorder){
        if(!$workorder->workorderHasTpm){
            return false;
        }

        $tpm = $workorder->workorderHasTpm;

        //validate TPM value
        if(!CustomHelpers::isContentValid($tpm->kode_dies_awal) || !CustomHelpers::isContentValid($tpm->diameter_dies_awal) || !CustomHelpers::isContentValid($tpm->diameter_aktual_setelah_dies_awal) || !CustomHelpers::isContentValid($tpm->diameter_aktual_setelah_polishing_awal) || !CustomHelpers::isContentValid($tpm->visual_barang_awal) || !CustomHelpers::isContentValid($tpm->kelurusan_awal)){
            return false;
        }

        if(!CustomHelpers::isContentValid($tpm->kode_dies_akhir) || !CustomHelpers::isContentValid($tpm->diameter_dies_akhir) || !CustomHelpers::isContentValid($tpm->diameter_aktual_setelah_dies_akhir) || !CustomHelpers::isContentValid($tpm->diameter_aktual_setelah_polishing_akhir) || !CustomHelpers::isContentValid($tpm->visual_barang_akhir) || !CustomHelpers::isContentValid($tpm->kelurusan_akhir)){
            return false;
        }

        if(!CustomHelpers::isContentValid($tpm->pre_straightening_putaran_roller_berputar) || !CustomHelpers::isContentValid($tpm->pre_straightening_kondisi_produk_tidak_keluar_jalur)){
            return false;
        }

        if(!CustomHelpers::isContentValid($tpm->ampere_impeller_1) || !CustomHelpers::isContentValid($tpm->ampere_impeller_2) || !CustomHelpers::isContentValid($tpm->ampere_impeller_3) || !CustomHelpers::isContentValid($tpm->ampere_impeller_4) || !CustomHelpers::isContentValid($tpm->speed_motor) || !CustomHelpers::isContentValid($tpm->ukuran_slide) || !CustomHelpers::isContentValid($tpm->kondisi_pelumas)){
            return false;
        }

        if(!CustomHelpers::isContentValid($tpm->straightening_putaran_roller_berputar) || !CustomHelpers::isContentValid($tpm->straightening_kondisi_produk_tidak_keluar_jalur)){
            return false;
        }

        if(!CustomHelpers::isContentValid($tpm->cutting_panjang) || !CustomHelpers::isContentValid($tpm->ukuran_dies_cutting_in) || (!CustomHelpers::isContentValid($tpm->ukuran_dies_cutting_out))){
            return false;
        }

        if(!CustomHelpers::isContentValid($tpm->polishing_tidak_cacat) || !CustomHelpers::isContentValid($tpm->polishing_ukuran_plat_kuningan) || (!CustomHelpers::isContentValid($tpm->polishing_ampere_motor) && !CustomHelpers::isContentValid($tpm->polishing_ampere_motor_s2b)) || !CustomHelpers::isContentValid($tpm->polishing_kondisi_pelumas_lancar)){
            return false;
        }

        if(!CustomHelpers::isContentValid($tpm->hasil_setting) || !CustomHelpers::isContentValid($tpm->quality_control)){
            return false;
        }

        if(!CustomHelpers::isContentValid($tpm->checked_by)){
            return false;
        }

        return true;
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    
}
