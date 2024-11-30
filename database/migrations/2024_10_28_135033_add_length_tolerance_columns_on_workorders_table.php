<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLengthToleranceColumnsOnWorkordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('workorders', function (Blueprint $table) {
            $table->string('length_tolerance_minus')->default('-')->after('tolerance_plus');
            $table->string('length_tolerance_plus')->default('-')->after('length_tolerance_minus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workorders', function (Blueprint $table) {
            $table->dropColumn('length_tolerance_minus');
            $table->dropColumn('length_tolerance_plus');
        });
    }
}
