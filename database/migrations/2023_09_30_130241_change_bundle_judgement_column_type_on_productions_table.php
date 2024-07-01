<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBundleJudgementColumnTypeOnProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productions',function(Blueprint $table){
            $table->string('bundle_judgement')->change();
            $table->string('visual')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('productions',function(Blueprint $table){
        //     $table->boolean('bundle_judgement')->change();
        // });
    }
}
