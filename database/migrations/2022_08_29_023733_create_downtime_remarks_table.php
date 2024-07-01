<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDowntimeRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downtime_remarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('downtime_id');
            $table->enum('downtime_category', ['waste', 'management', 'off']);
            $table->string('downtime_reason');
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->foreign('downtime_id')->references('id')->on('downtimes')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
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
        Schema::table('downtime_remarks', function (Blueprint $table) {
            $table->dropForeign(['downtime_id']);
        });
        Schema::dropIfExists('downtime_remarks');
    }
}
