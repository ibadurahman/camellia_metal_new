<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDowntimeReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downtime_reasons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dt_category_id');
            $table->foreign('dt_category_id')->references('id')->on('downtime_categories')->onDelete('cascade');
            $table->string('name');
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
        Schema::table('downtime_reasons', function (Blueprint $table) {
            $table->dropForeign(['dt_category_id']);
        });
        Schema::dropIfExists('downtime_reasons');
    }
}
