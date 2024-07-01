<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBypassWorkordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bypass_workorders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workorder_id');
            $table->unsignedBigInteger('initiated_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->string('remarks');
            $table->foreign('workorder_id')->references('id')->on('workorders')
                ->onDelete('CASCADE');
            $table->foreign('initiated_by')->references('id')->on('users')
                ->onDelete('CASCADE');
            $table->foreign('approved_by')->references('id')->on('users')
                ->onDelete('CASCADE');
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
        //drop foreign key
        Schema::table('bypass_workorders', function (Blueprint $table) {
            $table->dropForeign(['workorder_id']);
            $table->dropForeign(['initiated_by']);
            $table->dropForeign(['approved_by']);
        });
        Schema::dropIfExists('bypass_workorders');
    }
}
