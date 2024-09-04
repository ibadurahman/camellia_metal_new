<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkorderHasTpmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workorder_has_tpms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workorder_id');
            $table->foreign('workorder_id')->references('id')->on('workorders')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('machine_id');
            $table->foreign('machine_id')->references('id')->on('machines')->onUpdate('cascade');
            $table->string('diameter');
            $table->string('grade');
            $table->string('panjang');
            $table->dateTime('tanggal');
            $table->string('kode_dies_awal');
            $table->string('kode_dies_akhir')->nullable();
            $table->string('diameter_dies_awal');
            $table->string('diameter_dies_akhir')->nullable();
            $table->string('diameter_aktual_setelah_dies_awal');
            $table->string('diameter_aktual_setelah_dies_akhir')->nullable();
            $table->string('diameter_aktual_setelah_polishing_awal');
            $table->string('diameter_aktual_setelah_polishing_akhir')->nullable();
            $table->string('visual_barang_awal');
            $table->string('visual_barang_akhir')->nullable();
            $table->string('kelurusan_awal');
            $table->string('kelurusan_akhir')->nullable();
            $table->enum('pre_straightening_putaran_roller_berputar', ['ok', 'ng'])->nullable();
            $table->enum('pre_straightening_kondisi_produk_tidak_keluar_jalur', ['ok', 'ng'])->nullable();
            $table->string('ampere_impeller_1')->nullable();
            $table->string('ampere_impeller_2')->nullable();
            $table->string('ampere_impeller_3')->nullable();
            $table->string('ampere_impeller_4')->nullable();
            $table->string('speed_motor')->nullable();
            $table->string('ukuran_slide')->nullable();
            $table->enum('kondisi_pelumas', ['ok', 'ng'])->nullable();
            $table->enum('straightening_putaran_roller_berputar', ['ok', 'ng'])->nullable();
            $table->enum('straightening_kondisi_produk_tidak_keluar_jalur', ['ok', 'ng'])->nullable();
            $table->string('cutting_panjang')->nullable();
            $table->string('ukuran_dies_cutting_in')->nullable();
            $table->string('ukuran_dies_cutting_out')->nullable();
            $table->string('ukuran_dies_cutting_out_cutter_5')->nullable();
            $table->string('ukuran_dies_cutting_out_cutter_6')->nullable();
            $table->string('ukuran_dies_cutting_out_cutter_7')->nullable();
            $table->string('ukuran_dies_cutting_out_cutter_9')->nullable();
            $table->enum('polishing_tidak_cacat', ['ok', 'ng']);
            $table->string('polishing_ukuran_plat_kuningan')->nullable();
            $table->string('polishing_ampere_motor')->nullable();
            $table->string('polishing_ampere_motor_s2b')->nullable();
            $table->enum('polishing_kondisi_pelumas_lancar', ['ok', 'ng'])->nullable();
            $table->enum('polishing_penutup_oli_tertutup', ['ok', 'ng'])->nullable();
            $table->enum('hasil_setting', ['ok', 'ng'])->nullable();
            $table->longText('catatan')->nullable();
            $table->string('quality_control')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade'); 
            $table->string('checked_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workorder_has_tpms', function (Blueprint $table) {
            $table->dropForeign(['workorder_id']);
            $table->dropForeign(['machine_id']);
            $table->dropForeign(['created_by']);
        });
        Schema::dropIfExists('workorder_has_tpms');
    }
}
