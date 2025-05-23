<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmeltingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smeltings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workorder_id');
            $table->bigInteger('coil_num');
            $table->bigInteger('weight');
            $table->string('smelting_num');
            $table->string('area');
            $table->timestamps();

            $table->foreign('workorder_id')->references('id')->on('workorders')
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
        Schema::table('smeltings', function (Blueprint $table) {
            $table->dropForeign(['workorder_id']);
        });
        Schema::dropIfExists('smeltings');
    }
}
