<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionRemarksColumnOnWorkordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add production_remarks column on workorders table
        Schema::table('workorders', function (Blueprint $table) {
            $table->string('production_remarks')->nullable()->after('remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop production_remarks column on workorders table
        Schema::table('workorders', function (Blueprint $table) {
            $table->dropColumn('production_remarks');
        });
    }
}
