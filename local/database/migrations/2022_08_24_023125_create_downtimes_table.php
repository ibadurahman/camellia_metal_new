<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDowntimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downtimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workorder_id');
            $table->string('downtime_number');
            $table->time('time');
            $table->string('status');
            $table->bigInteger('downtime');
            $table->boolean('is_downtime_stopped');
            $table->boolean('is_remark_filled');
            $table->timestamps();

            $table->foreign('workorder_id')->references('id')->on('workorders')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //drop foreign key
        Schema::table('downtimes', function (Blueprint $table) {
            $table->dropForeign(['workorder_id']);
        });
        Schema::dropIfExists('downtimes');
    }
}
