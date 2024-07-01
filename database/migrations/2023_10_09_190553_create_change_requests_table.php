<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workorder_id');
            $table->foreign('workorder_id')->references('id')->on('workorders')->onDelete('CASCADE');
            $table->longText('change_data');
            $table->unsignedBigInteger('changed_by');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('CASCADE');
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
        // drop foreign key
        Schema::table('change_requests', function (Blueprint $table) {
            $table->dropForeign(['workorder_id']);
            $table->dropForeign(['changed_by']);
        });
        Schema::dropIfExists('change_requests');
    }
}
