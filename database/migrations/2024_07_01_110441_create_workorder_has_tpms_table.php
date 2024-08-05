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
            $table->decimal('diameter');
            $table->string('grade');
            $table->decimal('panjang');
            $table->dateTime('tanggal');
            $table->string('kode_dies_awal');
            $table->string('kode_dies_akhir');
            $table->decimal('diameter_dies_awal');
            $table->decimal('diameter_dies_akhir');
            $table->decimal('diameter_aktual_setelah_dies_awal');
            $table->decimal('diameter_aktual_setelah_dies_akhir');
            $table->decimal('diameter_aktual_setelah_polishing_awal');
            $table->decimal('diameter_aktual_setelah_polishing_akhir');
            $table->enum('visual_barang_awal', ['ok', 'ng']);
            $table->enum('visual_barang_akhir', ['ok', 'ng']);
            $table->enum('kelurusan_awal', ['ok', 'ng']);
            $table->enum('kelurusan_akhir', ['ok', 'ng']);
            $table->enum('pre_straightening_putaran_roller_berputar', ['ok', 'ng']);
            $table->enum('pre_straightening_kondisi_produk_tidak_keluar_jalur', ['ok', 'ng']);
            $table->decimal('ampere_impeller_1');
            $table->decimal('ampere_impeller_2');
            $table->decimal('ampere_impeller_3');
            $table->decimal('ampere_impeller_4');
            $table->decimal('speed_motor');
            $table->decimal('ukuran_slide');
            $table->enum('kondisi_pelumas', ['ok', 'ng']);
            $table->enum('straightening_putaran_roller_berputar', ['ok', 'ng']);
            $table->enum('straightening_kondisi_produk_tidak_keluar_jalur', ['ok', 'ng']);
            $table->decimal('cutting_panjang');
            $table->decimal('ukuran_dies_cutting_in')->nullable();
            $table->decimal('ukuran_dies_cutting_out')->nullable();
            $table->decimal('ukuran_dies_cutting_out_cutter_5');
            $table->decimal('ukuran_dies_cutting_out_cutter_6');
            $table->decimal('ukuran_dies_cutting_out_cutter_7');
            $table->decimal('ukuran_dies_cutting_out_cutter_9');
            $table->enum('polishing_tidak_cacat', ['ok', 'ng']);
            $table->decimal('polishing_ukuran_plat_kuningan');
            $table->decimal('polishing_ampere_motor')->nullable();
            $table->decimal('polishing_ampere_motor_s2b')->nullable();
            $table->enum('polishing_kondisi_pelumas_lancar', ['ok', 'ng']);
            $table->enum('polishing_penutup_oli_tertutup', ['ok', 'ng']);
            $table->enum('hasil_setting', ['ok', 'ng']);
            $table->longText('catatan')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onUpdate('cascade');
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
            $table->dropForeign(['approved_by']);
        });
        Schema::dropIfExists('workorder_has_tpms');
    }
}
